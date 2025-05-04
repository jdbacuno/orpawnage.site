<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Notifications\AdoptionStatusNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdoptionApplicationController extends Controller
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

        $query = AdoptionApplication::with(['pet', 'user'])
            ->orderBy($sort, $direction);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $perPage = 9;
        $applications = $query->paginate($perPage);

        return view('admin.adoption-applications', ['adoptionApplications' => $applications]);
    }

    public function create(Pet $pet)
    {
        return view('adoption-form', compact('pet'));
    }

    public function store(Request $request, Pet $pet)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'age' => ['required', 'integer', 'min:18'],
            'birthdate' => ['required', 'date', 'after_or_equal:1900-01-01', 'before_or_equal:2099-12-31'],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
            'address' => ['required', 'string', 'max:500'],
            'civil_status' => ['required', 'string'],
            'citizenship' => ['required', 'string'],
            'reason_for_adoption' => ['required', 'string', 'max:1000'],
            'visit_veterinarian' => ['required', 'string', 'in:Yes,No,Sometimes'],
            'existing_pets' => ['required', 'integer', 'min:0'],
            'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('submission_error', 'Failed to submit application. Please check the form for errors.');
        }

        // Check if pet is already adopted or has pending applications
        if ($pet->is_adopted) {
            return back()->with('error_request', 'This pet has already been adopted.');
        }

        if (AdoptionApplication::where('pet_id', $pet->id)
            ->where('status', '!=', 'rejected')
            ->exists()
        ) {
            return back()->with('error_request', 'This pet has already been requested for adoption.');
        }

        $validated = $validator->validated();
        $validated['full_name'] = ucwords(strtolower(trim($validated['full_name'])));
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['address'] = ucfirst(trim($validated['address']));
        $validated['civil_status'] = ucfirst(trim($validated['civil_status']));
        $validated['citizenship'] = ucfirst(strtolower(trim($validated['citizenship'])));
        $validated['reason_for_adoption'] = ucfirst(trim($validated['reason_for_adoption']));
        $validated['transaction_number'] = $this->generateUniqueTransactionNumber();

        // Upload valid ID (after validation passed)
        $extension = $request->valid_id->getClientOriginalExtension();
        $filename = str_replace(' ', '_', $validated['full_name']) . '_' . $validated['transaction_number'] . '.' . $extension;
        $validIdPath = $request->file('valid_id')->storeAs('valid_ids', $filename, 'public');
        $validated['valid_id'] = $validIdPath;

        $application = AdoptionApplication::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            ...$validated,
        ]);

        // Notify user
        $application->user->notify(new AdoptionStatusNotification($application));

        return back()->with(
            'success',
            'Adoption application submitted successfully! Please check your email to confirm your application within 24 hours. You can visit the ' . '<a href="/transactions/adoption-status" class="text-blue-500">Transactions' . "</a>" . ' page to track your application. You may resend the confirmation email if you did not receive it.'
        );
    }

    public function confirmApplication($id)
    {
        $application = AdoptionApplication::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'to be confirmed')
            ->first();

        if (!$application) {
            return redirect()->route('transactions.adoption-status')
                ->with('error_request', 'Invalid or already confirmed application.');
        }

        $application->status = 'confirmed';
        $application->save();

        // Notify user that their application has been confirmed
        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->route('transactions.adoption-status')
            ->with('success', 'Your adoption application has been successfully confirmed. A confirmation email has been sent.');
    }

    public function markAsPickedUp(Request $request)
    {
        $application = AdoptionApplication::with(['pet'])->findOrFail($request->application_id);

        if ($application->status !== 'adoption on-going') {
            return redirect()->back()->with('error', 'Invalid status change.');
        }

        $application->update(['status' => 'picked up']);
        $application->pet->update(['is_adopted' => true]);

        // send email regarding the photo that will be posted on FB

        return redirect()->back()->with('success', 'Adoption marked as completed.');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'application_id' => ['required', 'exists:adoption_applications,id'],
            'reject_reason' => ['required', 'string', 'max:500'],
        ]);

        $application = AdoptionApplication::with(['user', 'pet'])->findOrFail($request->application_id);

        $application->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason,
        ]);

        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->back()->with('success', 'Adoption application rejected.');
    }

    public function archive(Request $request)
    {
        $application = AdoptionApplication::findOrFail($request->application_id);

        if ($application->status !== 'picked up') {
            return redirect()->back()->with('error', 'Only completed adoptions can be archived.');
        }

        $application->update(['status' => 'archive']);

        return redirect()->back()->with('success', 'Adoption application archived.');
    }

    private function generateUniqueTransactionNumber()
    {
        do {
            $date = now()->format('Ymd');
            $random = strtoupper(Str::random(3)) . rand(100, 999);
            $transactionNumber = "AP{$date}{$random}";
        } while (AdoptionApplication::where('transaction_number', $transactionNumber)->exists());

        return $transactionNumber;
    }
}
