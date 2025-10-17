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
    $search = request('search');

    $allowedSorts = ['created_at', 'pet_number', 'species', 'age', 'sex', 'color', 'status'];
    if (!in_array($sort, $allowedSorts)) {
      $sort = 'created_at';
    }

    $query = SurrenderApplication::with(['user'])
      ->where('status', '!=', 'archived')
      ->orderBy($sort, $direction);

    if ($status && $status !== 'all') {
      $query->where('status', $status);
    }

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('transaction_number', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('full_name', 'like', "%$search%");
      });
    }

    $perPage = request()->get('per_page', 12);
    $applications = $query->paginate($perPage);

    return view('admin.surrender-applications', ['surrenderApplications' => $applications]);
  }

  public function create(Pet $pet)
  {
    return view('surrender', [
      'pet' => $pet
    ]);
  }

  public function store(Request $request)
  {
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
      'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
      'animal_photos' => ['required', 'array', 'max:5'],
      'animal_photos.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
      'declaration' => ['required', 'accepted'],
    ]);

    $validator->after(function ($validator) use ($request) {
      if ($request->birthdate) {
        $birthdate = new \DateTime($request->birthdate);
        $today = new \DateTime();
        $calculatedAge = $today->diff($birthdate)->y;

        if ($calculatedAge != $request->age) {
          $validator->errors()->add('age', 'The age does not match the birthdate provided.');
        }
      }

      $totalSize = 0;
      if ($request->hasFile('valid_id')) {
        $totalSize += $request->file('valid_id')->getSize();
      }
      if ($request->hasFile('animal_photos')) {
        foreach ($request->file('animal_photos') as $photo) {
          $totalSize += $photo->getSize();
        }
      }

      if ($totalSize > 26214400) {
        $validator->errors()->add('files', 'Total file size cannot exceed 25MB.');
      }
    });

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput()
        ->with('submission_error', 'Failed to submit application. Please check the form for errors.');
    }

    $validated = $validator->validated();

    $validated['full_name'] = ucwords(strtolower(trim($validated['full_name'])));
    $validated['email'] = strtolower(trim($validated['email']));
    $validated['address'] = ucfirst(trim($validated['address']));
    $validated['civil_status'] = ucfirst(trim($validated['civil_status']));
    $validated['citizenship'] = ucfirst(strtolower(trim($validated['citizenship'])));
    $validated['reason'] = trim($validated['reason']);
    $validated['transaction_number'] = $this->generateUniqueTransactionNumber();

    $validIdExtension = $request->valid_id->getClientOriginalExtension();
    $validIdFilename = str_replace(' ', '_', $validated['email']) . '_' . $validated['transaction_number'] . '.' . $validIdExtension;
    $validIdPath = $request->file('valid_id')->storeAs('valid_ids', $validIdFilename, 'public');
    $validated['valid_id_path'] = $validIdPath;

    $animalPhotos = [];
    foreach ($request->file('animal_photos') as $index => $photo) {
      $photoName = "animal_photo_{$validated['transaction_number']}_{$index}." . $photo->getClientOriginalExtension();
      $path = $photo->storeAs('surrender_animal_photos', $photoName, 'public');
      $animalPhotos[] = $path;
    }
    $validated['animal_photos'] = json_encode($animalPhotos);

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
      'animal_photos' => $validated['animal_photos'],
      'transaction_number' => $validated['transaction_number'],
    ]);

    $application->user->notify(new SurrenderStatusNotification($application->id));

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
      ->where('status', 'to be confirmed')
      ->first();

    if (!$application) {
      return response()->view('confirmation-result', [
        'success' => false,
        'message' => 'Invalid or already confirmed application.'
      ]);
    }

    if ($application->created_at->diffInHours(now()) > 24) {
      $application->update([
        'status' => 'rejected',
        'reject_reason' => 'Application expired - not confirmed within 24 hours'
      ]);

      return response()->view('confirmation-result', [
        'success' => false,
        'message' => 'This confirmation link has expired. Please submit a new application.'
      ]);
    }

    $application->status = 'confirmed';
    $application->confirmed_at = now();
    $application->save();

    $application->user->notify(new SurrenderStatusNotification($application->id));

    return response()->view('confirmation-result', [
      'success' => true,
      'message' => 'Your surrender application has been successfully confirmed!',
      'type' => 'surrender'
    ]);
  }

  public function markAsCompleted(Request $request)
  {
    $application = SurrenderApplication::with(['user'])->findOrFail($request->application_id);

    if ($application->status !== 'confirmed') {
      return redirect()->back()->with('error', 'Invalid status change.');
    }

    $application->update(['status' => 'completed']);
    $application->user->notify(new SurrenderStatusNotification($application->id));

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

    $application->user->notify(new SurrenderStatusNotification($application->id));

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
    $application->user->notify(new SurrenderStatusNotification($application->id));

    return back()->with('success', 'Confirmation email resent successfully.');
  }

  public function destroy(SurrenderApplication $application)
  {
    if ($application->valid_id_path) {
      Storage::disk('public')->delete($application->valid_id_path);
    }
    if ($application->animal_photos) {
      $photos = json_decode($application->animal_photos);
      foreach ($photos as $photo) {
        Storage::disk('public')->delete($photo);
      }
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
