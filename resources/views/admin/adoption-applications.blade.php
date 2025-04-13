<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Pet Adoption Applications</h1>

  <div class="bg-white p-6 shadow-md rounded-lg mt-4">
    {{-- Filter Section --}}
    <div class="flex flex-wrap gap-2 mb-4">
      <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4">
        <!-- Status Filter -->
        <select name="status"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
          onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="to be scheduled" {{ request('status')==='to be scheduled' ? 'selected' : '' }}>
            To Be Scheduled
          </option>
          <option value="to be picked up" {{ request('status')==='to be picked up' ? 'selected' : '' }}>
            To Be Picked Up
          </option>
          <option value="picked up" {{ request('status')==='picked up' ? 'selected' : '' }}>
            Picked Up
          </option>
          <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>
            Rejected
          </option>
        </select>

        <select name="direction"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
          onchange="this.form.submit()">
          <option value="desc" {{ request('direction', 'desc' )==='desc' ? 'selected' : '' }}>
            Newest First
          </option>
          <option value="asc" {{ request('direction')==='asc' ? 'selected' : '' }}>
            Oldest First
          </option>
        </select>
      </form>
    </div>

    @if($adoptionApplications->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No adoption applications found.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
      @foreach($adoptionApplications as $application)
      <div
        class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
        <!-- Pet and Adopter Info Header -->
        <div class="p-4 border-b border-gray-200">
          <div class="flex items-start space-x-2">
            <!-- Pet Image (placeholder if no image) -->
            <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
              <img src="{{ asset('storage/' . $application->pet->image_path) }}" alt="{{ $application->pet->pet_name }}"
                class="w-full h-full object-cover">
            </div>

            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold flex items-center"><i class="ph-fill ph-tag mr-2"></i> {{
                $application->transaction_number }}</h3>
              <p class="text-sm font-medium text-gray-900 truncate">
                <a href="#" class="pet-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $application->id }}" data-image="{{ asset('storage/' . $application->pet->image_path) }}"
                  data-number="{{ $application->pet->pet_number }}"
                  data-name="{{ strtolower($application->pet->pet_name) !== 'n/a' ? ucwords($application->pet->pet_name) : 'Unnamed' }}"
                  data-species="{{ $application->pet->species }}" data-age="{{ $application->pet->age }}"
                  data-age-unit="{{ $application->pet->age_unit }}" data-color="{{ $application->pet->color }}"
                  data-sex="{{ $application->pet->sex }}"
                  data-repro-status="{{ $application->pet->reproductive_status }}"
                  data-source="{{ $application->pet->source }}">
                  {{ strtolower($application->pet->pet_name) !== 'n/a' ? ucwords($application->pet->pet_name) :
                  'Unnamed' }} ({{ $application->pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{
                  $application->pet->pet_number }})
                </a>
              </p>
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Applicant:</span> <a href="#"
                  class="adopter-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $application->id }}" data-name="{{ $application->full_name }}"
                  data-email="{{ $application->email }}" data-age="{{ $application->age }}"
                  data-birthdate="{{ $application->birthdate->format('F j, Y') }}"
                  data-address="{{ $application->address }}" data-phone="{{ $application->contact_number }}"
                  data-civil="{{ $application->civil_status }}" data-citizenship="{{ $application->citizenship }}">
                  {{ $application->full_name }}
                </a>
              </p>
            </div>
          </div>
        </div>

        <!-- Application Details -->
        <div class="p-4 space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500">Status</span>
            <span class="px-2 py-1 text-xs rounded 
                    {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $application->status === 'to be picked up' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $application->status === 'picked up' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
              {{ ucfirst($application->status) }}
            </span>
          </div>

          <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500">Pickup Date</span>
            <span class="text-sm text-gray-900">
              {{ $application->pickup_date ? $application->pickup_date->format('F j, Y') : 'Not set' }}
            </span>
          </div>

          <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500">Date Applied</span>
            <span class="text-sm text-gray-900">
              {{ $application->created_at->format('M d, Y h:i A') }}
            </span>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-gray-50 px-4 py-3 flex justify-between space-x-2">
          @if ($application->status === 'to be picked up')
          <form method="POST" action="/admin/adoption-applications/pickedup" class="w-full">
            @csrf
            @method('PATCH')
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            <button type="submit" class="w-full bg-blue-500 text-white px-3 py-2 rounded-md text-sm hover:bg-blue-400">
              Mark as Picked Up
            </button>
          </form>
          @elseif ($application->status !== 'picked up' && $application->status !== 'rejected')
          <button class="flex-1 bg-green-500 text-white px-3 py-2 rounded-md text-sm hover:bg-green-400 approve-btn"
            data-id="{{ $application->id }}" data-pickup="{{ $application->pickup_date }}">
            {{ $application->pickup_date ? 'Reschedule' : 'Approve' }}
          </button>
          <button class="flex-1 bg-red-500 text-white px-3 py-2 rounded-md text-sm hover:bg-red-400 reject-btn"
            data-id="{{ $application->id }}">
            Reject
          </button>
          @elseif ($application->status === 'rejected')
          <button
            class="w-full bg-gray-500 italic text-white px-3 py-2 rounded-md text-sm opacity-75 cursor-not-allowed"
            disabled>
            Rejected
          </button>
          @else
          <button
            class="w-full bg-gray-500 italic text-white px-3 py-2 rounded-md text-sm opacity-75 cursor-not-allowed"
            disabled>
            Picked Up
          </button>
          @endif
        </div>
      </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $adoptionApplications->links() }}
    </div>
    @endif
  </div>

  <!-- Pet Info Modal -->
  <div id="petInfoModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">

      <!-- Close Button (X) -->
      <button id="closePetInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i> <!-- Using Phosphor Icons -->
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Pet Information</h2>

      <!-- Pet Image -->
      <div class="flex justify-start gap-4 my-4">
        <img id="petImage" src="" alt="Pet Image" class="w-1/2 h-auto object-cover rounded-md">

        <div>
          <p><strong>Pet No:</strong> #<span id="petNumber"></span></p>
          <p><strong>Pet Name:</strong> <span id="petName"></span></p>
          <p><strong>Species:</strong> <span id="petSpecies"></span></p>
          <p><strong>Age:</strong> <span id="petAge"></span> <span id="petAgeUnit"></span></p>
          <p><strong>Color:</strong> <span id="petColor"></span></p>
          <p><strong>Sex:</strong> <span id="petSex"></span></p>
          <p><strong>Reproductive Status:</strong> <span id="petReproStatus"></span></p>
          <p><strong>Source:</strong> <span id="petSource"></span></p>
        </div>
      </div>
    </div>
  </div>


  <!-- Adopter Info Modal -->
  <div id="adopterInfoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <!-- Close Button (X) -->
      <button id="closeAdopterInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i> <!-- Using Phosphor Icons -->
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Adopter's Information</h2>
      <p><strong>Name:</strong> <span id="adopterName"></span></p>
      <p><strong>Email:</strong> <span id="adopterEmail"></span></p>
      <p><strong>Age:</strong> <span id="adopterAge"></span> years old</p>
      <p><strong>Birthdate:</strong> <span id="adopterBirthdate"></span></p>
      <p><strong>Address:</strong> <span id="adopterAddress"></span></p>
      <p><strong>Phone:</strong> <span id="adopterPhone"></span></p>
      <p><strong>Civil Status:</strong> <span id="adopterCivilStatus"></span></p>
      <p><strong>Citizenship:</strong> <span id="adopterCitizenship"></span></p>

    </div>
  </div>

  <!-- Approve Modal -->
  <div id="approveModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">

      <!-- Close Button -->
      <button type="button" id="closeApproveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i> <!-- Phosphor Icons -->
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Approve Adoption</h2>
      <p class="mb-2">Set a pickup date:</p>

      <p class="mb-4 text-green-500 text-sm">This will send an email notification to the user.</p>

      <!-- Form -->
      <form id="approveForm" method="POST" action="/admin/adoption-applications/approve">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="applicationId">

        <!-- Date Input -->
        <label for="pickupDate" class="block font-medium text-gray-700">Pickup Date:</label>
        <input type="date" id="pickupDate" name="pickup_date" class="w-full border p-2 rounded-md mb-4" required>
        <x-form-error name="pickup_date" />

        <button type="submit" class="bg-green-500 px-4 py-2 text-white hover:bg-green-400 rounded-md w-full">
          Submit
        </button>
      </form>
    </div>
  </div>

  <!-- Reject Modal -->
  <div id="rejectModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">

      <!-- Close Button -->
      <button type="button" id="closeRejectModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Reject Adoption</h2>
      <p class="mb-2">Please provide a reason for rejecting this application:</p>
      <p class="my-2 text-green-500 text-sm">This will send an email notification to the user.</p>

      <!-- Form -->
      <form id="rejectForm" method="POST" action="/admin/adoption-applications/reject">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="rejectApplicationId">

        <!-- Rejection Reason -->
        <label for="rejectReason" class="block font-medium text-gray-700">Reason:</label>
        <textarea id="rejectReason" name="reject_reason" class="w-full border p-2 rounded-md mb-4" required></textarea>
        <x-form-error name="reject_reason" />

        <button type="submit" class="bg-red-500 px-4 py-2 text-white hover:bg-red-400 rounded-md w-full">
          Submit
        </button>
      </form>
    </div>
  </div>


</x-admin-layout>