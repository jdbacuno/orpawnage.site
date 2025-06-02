<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\SurrenderApplication;
use App\Notifications\SurrenderStatusNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SurrenderApplicationController extends Controller
{
  public function index()
  {
    $sort = request('sort', 'created_at');
    $direction = request('direction', 'desc');
    $status = request('status');

    $allowedSorts = ['created_at', 'pet_number', 'species', 'age', 'sex', 'color', 'status'];
    if (!in_array($sort, $allowedSorts)) {
      $sort = 'created_at';
    }

    $query = SurrenderApplication::with(['user'])
      ->where('status', '!=', 'archived') // Exclude archived applications by default
      ->orderBy($sort, $direction);

    if ($status && $status !== 'all') {
      $query->where('status', $status);
    }

    $perPage = request()->get('per_page', 12);
    $applications = $query->paginate($perPage);

    return view('admin.surrender-applications', ['surrenderApplications' => $applications]);
  }

  public function create(Pet $pet)
  {
    $hasPendingApplication = SurrenderApplication::where('user_id', Auth::id())
      ->whereIn('status', ['to be confirmed', 'confirmed', 'surrender on-going', 'to be scheduled'])
      ->exists();

    return view('surrender', [
      'pet' => $pet,
      'hasPendingApplication' => $hasPendingApplication
    ]);
  }

  public function store(Request $request)
  {
    $existingApplication = SurrenderApplication::where('user_id', Auth::id())
      ->whereIn('status', ['to be confirmed', 'confirmed', 'surrender on-going', 'to be scheduled'])
      ->first();

    if ($existingApplication) {
      return back()->with(
        'error_request',
        'You already have a pending surrender application (Transaction #' . $existingApplication->transaction_number . '). ' .
          'Please wait until your current application is completed or rejected before submitting a new one.'
      );
    }

    $validator = Validator::make($request->all(), [
      'full_name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255'],
      'birthdate' => ['required', 'date', 'before_or_equal:today'],
      'age' => ['required', 'integer', 'min:18'],
      'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
      'address' => ['required', 'string', 'max:500'],
      'civil_status' => ['required', 'string'],
      'citizenship' => ['required', 'string'],
      'pet_name' => ['nullable', 'string', 'max:255'],
      'species' => ['required', 'string'],
      'breed' => ['nullable', 'string', 'max:255'],
      'sex' => ['required', 'string', 'in:Male,Female,Unknown'],
      'reason' => ['required', 'string', 'max:1000'],
      'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:10240'],
      'animal_photos' => ['required', 'array', 'max:5'],
      'animal_photos.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
      'declaration' => ['required', 'accepted'],
    ]);

    // Custom age-birthdate validation
    $validator->after(function ($validator) use ($request) {
      if ($request->birthdate) {
        $birthdate = new \DateTime($request->birthdate);
        $today = new \DateTime();
        $calculatedAge = $today->diff($birthdate)->y;

        if ($calculatedAge != $request->age) {
          $validator->errors()->add('age', 'The age does not match the birthdate provided.');
        }
      }
    });

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput()
        ->with('submission_error', 'Failed to submit application. Please check the form for errors.');
    }

    // Only proceed with file uploads and DB storage if validation passes
    $validated = $validator->validated();

    // Sanitize and normalize data
    $validated['full_name'] = ucwords(strtolower(trim($validated['full_name'])));
    $validated['email'] = strtolower(trim($validated['email']));
    $validated['address'] = ucfirst(trim($validated['address']));
    $validated['civil_status'] = ucfirst(trim($validated['civil_status']));
    $validated['citizenship'] = ucfirst(strtolower(trim($validated['citizenship'])));
    $validated['reason'] = ucfirst(trim($validated['reason']));
    $validated['transaction_number'] = $this->generateUniqueTransactionNumber();

    // Upload valid ID
    $validIdExtension = $request->valid_id->getClientOriginalExtension();
    $validIdFilename = str_replace(' ', '_', $validated['email']) . '_' . $validated['transaction_number'] . '.' . $validIdExtension;
    $validIdPath = $request->file('valid_id')->storeAs('valid_ids', $validIdFilename, 'public');
    $validated['valid_id_path'] = $validIdPath;

    // Upload animal photos
    $animalPhotos = [];
    foreach ($request->file('animal_photos') as $index => $photo) {
      $photoName = "animal_photo_{$validated['transaction_number']}_{$index}." . $photo->getClientOriginalExtension();
      $path = $photo->storeAs('surrender_animal_photos', $photoName, 'public');
      $animalPhotos[] = $path;
    }
    $validated['animal_photos'] = json_encode($animalPhotos);

    // Store application
    $application = SurrenderApplication::create([
      'user_id' => Auth::id(),
      'full_name' => $validated['full_name'],
      'email' => $validated['email'],
      'birthdate' => $validated['birthdate'],
      'age' => $validated['age'],
      'contact_number' => $validated['contact_number'],
      'address' => $validated['address'],
      'civil_status' => $validated['civil_status'],
      'citizenship' => $validated['citizenship'],
      'pet_name' => $validated['pet_name'] ?? null,
      'species' => $validated['species'],
      'breed' => $validated['breed'] ?? null,
      'sex' => $validated['sex'],
      'reason' => $validated['reason'],
      'valid_id_path' => $validated['valid_id_path'],
      'animal_photos' => $validated['animal_photo_path'], // Correct field name
      'transaction_number' => $validated['transaction_number'],
    ]);

    $application->user->notify(new SurrenderStatusNotification($application));

    return back()->with(
      'success',
      'Surrender application submitted successfully! Please check your email to confirm your application within 24 hours. ' .
        'You can visit the <a href="/transactions/surrender-status" class="text-blue-500">Transactions</a> page to track your application. ' .
        'You may resend the confirmation email if you did not receive it.'
    );
  }

  public function confirmApplication($id)
  {
    $application = SurrenderApplication::where('id', $id)
      ->where('user_id', Auth::id())
      ->where('status', 'to be confirmed')
      ->first();

    if (!$application) {
      return redirect()->route('transactions.surrender-status')
        ->with('error_request', 'Invalid or already confirmed application.');
    }

    $application->status = 'confirmed';
    $application->confirmed_at = now();
    $application->save();

    $application->user->notify(new SurrenderStatusNotification($application));

    return redirect()->route('transactions.surrender-status')
      ->with('success', 'Your surrender application has been successfully confirmed. A confirmation email has been sent.');
  }

  public function moveToSchedule(Request $request)
  {
    $request->validate([
      'application_id' => ['required', 'exists:surrender_applications,id']
    ]);

    $application = SurrenderApplication::with(['user'])->findOrFail($request->application_id);

    $application->update(['status' => 'to be scheduled']);
    $application->user->notify(new SurrenderStatusNotification($application));

    return redirect()->back()->with('success', 'Application moved to scheduling. An email has been sent to the applicant.');
  }

  public function markAsCompleted(Request $request)
  {
    $application = SurrenderApplication::with(['user'])->findOrFail($request->application_id);

    if ($application->status !== 'surrender on-going') {
      return redirect()->back()->with('error', 'Invalid status change.');
    }

    $application->update(['status' => 'completed']);
    $application->user->notify(new SurrenderStatusNotification($application));

    return redirect()->back()->with('success', 'Surrender marked as completed and notification sent.');
  }

  public function reject(Request $request)
  {
    $request->validate([
      'application_id' => ['required', 'exists:surrender_applications,id'],
      'reject_reason' => ['required', 'string', 'max:500'],
    ]);

    $application = SurrenderApplication::with(['user'])->findOrFail($request->application_id);

    $application->update([
      'status' => 'rejected',
      'reject_reason' => $request->reject_reason,
    ]);

    $application->user->notify(new SurrenderStatusNotification($application));

    return redirect()->back()->with('success', 'Surrender application rejected.');
  }

  public function archive(Request $request)
  {
    $request->validate([
      'application_id' => 'required|exists:surrender_applications,id'
    ]);

    $application = SurrenderApplication::findOrFail($request->application_id);

    if (!in_array($application->status, ['completed', 'rejected'])) {
      return redirect()->back()->with('error', 'Only completed or rejected surrenders can be archived.');
    }

    $application->update([
      'previous_status' => $application->status,
      'status' => 'archived'
    ]);

    return redirect()->back()->with('success', 'Surrender application archived.');
  }

  public function resendEmail($id)
  {
    $application = SurrenderApplication::findOrFail($id);
    $application->user->notify(new SurrenderStatusNotification($application));

    return back()->with('success', 'Confirmation email resent successfully.');
  }

  public function scheduleSurrender(Request $request, $id)
  {
    $application = SurrenderApplication::findOrFail($id);

    $validated = $request->validate([
      'surrender_date' => 'required|date|after_or_equal:today'
    ]);

    $surrenderDate = Carbon::parse($validated['surrender_date']);

    // Build 7 business day window (including today if not weekend)
    $start = Carbon::now();
    $end = $start->copy();
    $businessDays = 0;
    while ($businessDays < 7) {
      if (!$end->isWeekend()) $businessDays++;
      if ($businessDays < 7) $end->addDay();
    }

    if ($surrenderDate->gt($end) || $surrenderDate->isWeekend()) {
      return redirect()->back()->withErrors(['surrender_date' => 'Date must be a weekday within 7 business days.']);
    }

    $application->surrender_date = $surrenderDate;
    $application->status = 'surrender on-going';
    $application->save();

    $application->user->notify(new SurrenderStatusNotification($application));

    return redirect()->back()->with('success', 'Surrender scheduled successfully!');
  }

  public function destroy(SurrenderApplication $application)
  {
    // Delete the associated files if they exist
    if ($application->valid_id_path) {
      Storage::disk('public')->delete($application->valid_id_path);
    }
    if ($application->animal_photo_path) {
      Storage::disk('public')->delete($application->animal_photo_path);
    }

    $application->delete();

    return redirect()->back()->with('success', 'Surrender request deleted successfully.');
  }

  private function generateUniqueTransactionNumber()
  {
    do {
      $date = now()->format('Ymd');
      $random = strtoupper(Str::random(3)) . rand(100, 999);
      $transactionNumber = "SR{$date}{$random}";
    } while (SurrenderApplication::where('transaction_number', $transactionNumber)->exists());

    return $transactionNumber;
  }
}
