<x-transactions-layout>
  <div class="flex flex-col flex-wrap gap-x-4 gap-y-2 mt-0 sm:mt-10">
    <!-- Filters Section -->
    <div class="flex flex-wrap gap-4 items-center justify-start mb-1">
      <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4">

        <!-- Status Filter -->
        <select name="status"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[200px]"
          onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="waiting confirmation" {{ request('status')==='to be confirmed' ? 'selected' : '' }}>
            Waiting Confirmation
          </option>
          <option value="confirmed" {{ request('status')==='confirmed' ? 'selected' : '' }}>
            Confirmed
          </option>
          <option value="to be scheduled" {{ request('status')==='to be scheduled' ? 'selected' : '' }}>
            To Be Scheduled
          </option>
          <option value="adoption on-going" {{ request('status')==='adoption on-going' ? 'selected' : '' }}>
            Adoption On-going
          </option>
          <option value="picked up" {{ request('status')==='picked up' ? 'selected' : '' }}>
            Adopted
          </option>
          <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>
            Rejected
          </option>
        </select>

      </form>
    </div>

    @if ($adoptionApplications->isEmpty())
    <div class="w-full sm:text-center text-left text-gray-500 text-lg">
      No adoption applications found.
    </div>
    @else

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-6">
      @foreach($adoptionApplications as $application)
      <div
        class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-shadow duration-300">
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
                  data-civil="{{ $application->civil_status }}" data-citizenship="{{ $application->citizenship }}"
                  data-reason="{{ $application->reason_for_adoption }}"
                  data-visitvet="{{ $application->visit_veterinarian }}"
                  data-existingpets="{{ $application->existing_pets }}"
                  data-validid="{{ asset('storage/' . $application->valid_id) }}">
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
              {{ $application->status === 'picked up' ? 'Adopted' : ucfirst($application->status) }}
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

        <!-- Button Section (Fixed at the Bottom) -->
        <div class="p-4 pt-0">
          @if ($application->status === 'to be picked up' || $application->status === 'to be scheduled')
          <div class="flex items-center gap-2">
            <button
              class="flex-1 w-full bg-green-500 text-white px-3 py-2 rounded-md text-sm disabled cursor-not-allowed">
              {{ $application->status === 'to be picked up' ? 'Pick-up on ' . $application->pickup_date->format('M d,
              Y') : 'To be scheduled' }}
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="bg-red-500 text-white px-3 py-2 rounded-md text-sm">
              Cancel
            </button>
          </div>
          @elseif ($application->status === 'rejected')
          <div class="flex items-center gap-2">
            <button class="w-full bg-gray-500 text-white px-3 py-2 rounded-md text-sm opacity-75 cursor-not-allowed">
              Rejected
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="w-full bg-red-500 text-white px-3 py-2 rounded-md text-sm">
              Delete
            </button>
          </div>
          @elseif ($application->status === 'picked up')
          <button
            class="w-full bg-gray-500 italic text-white px-3 py-2 rounded-md text-sm opacity-75 cursor-not-allowed"
            disabled>
            Picked Up
          </button>
          @else
          <button class="w-full bg-gray-500 text-white  px-3 py-2 rounded-md text-sm opacity-75 cursor-not-allowed"
            disabled>
            Pending for Approval
          </button>
          @endif
        </div>
      </div>
      @endforeach
    </div>

    @endif
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $adoptionApplications->appends(request()->except('page'))->links() }}
  </div>

  @if(!$adoptionApplications->isEmpty())
  <!-- Cancel/Delete Confirmation Modal -->
  <div id="cancelModal" class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Action</h2>
      <p class="text-sm text-gray-600">Are you sure you want to cancel/delete this adoption request?</p>

      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="deleteForm" method="POST" action="{{ url('/transactions/' . $application->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Confirm</button>
        </form>
      </div>
    </div>
  </div>
  @endif

  <!-- Pet Info Modal -->
  <div id="petInfoModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-md w-full max-w-2xl relative overflow-y-auto scrollbar-hidden max-h-[90vh]">
      <!-- Close Button (X) -->
      <button id="closePetInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i> <!-- Using Phosphor Icons -->
      </button>

      <h2 class="text-xl font-semibold text-gray-800 mb-4">Pet Information</h2>

      <!-- Pet Image and Details -->
      <div class="flex flex-col sm:flex-row gap-6">
        <!-- Pet Image on top for mobile, left for larger screens -->
        <img id="petImage" src="" alt="Pet Image" class="w-full sm:w-2/5 h-auto object-cover rounded-md mb-6 sm:mb-0">

        <!-- Pet Details on the right for larger screens -->
        <div class="flex flex-col w-full sm:w-3/5 space-y-4">
          <!-- Left side: Basic Information -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium text-gray-600">Pet No</label>
              <input type="text" id="petNumber" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Pet Name</label>
              <input type="text" id="petName" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Species</label>
              <input type="text" id="petSpecies" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Age</label>
              <input type="text" id="petAge" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Color</label>
              <input type="text" id="petColor" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Sex</label>
              <input type="text" id="petSex" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Reproductive Status</label>
              <input type="text" id="petReproStatus" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Source</label>
              <input type="text" id="petSource" readonly
                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Adopter Info Modal -->
  <div id="adopterInfoModal"
    class="fixed inset-0 px-2 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-md w-full max-w-2xl relative overflow-y-auto scrollbar-hidden max-h-[90vh]">
      <!-- Close Button -->
      <button id="closeAdopterInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 mb-4">Adopter's Information</h2>

      <div class="mt-4">
        <div class="flex gap-x-2 items-center">
          <label class="text-sm font-medium text-gray-600">Valid ID</label>
          <div>
            <a id="adopterValidId" href="#" target="_blank" class="text-blue-500 underline text-sm">View Uploaded
              ID</a>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
          <label class="text-sm font-medium text-gray-600">Name</label>
          <input type="text" id="adopterName" readonly
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Email</label>
          <input type="text" id="adopterEmail" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Age</label>
          <input type="text" id="adopterAge" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Birthdate</label>
          <input type="text" id="adopterBirthdate" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Contact Number</label>
          <input type="text" id="adopterPhone" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Address</label>
          <input type="text" id="adopterAddress" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Civil Status</label>
          <input type="text" id="adopterCivilStatus" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Citizenship</label>
          <input type="text" id="adopterCitizenship" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">Do you visit a Veterinarian?</label>
          <input type="text" id="adopterVisitVet" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600">How many existing pets?</label>
          <input type="text" id="adopterExistingPets" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>
      </div>

      <div class="mt-4">
        <label class="text-sm font-medium text-gray-600">Reason for Adoption</label>
        <textarea id="adopterReason" disabled
          class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100" rows="3"></textarea>
      </div>
    </div>
  </div>
</x-transactions-layout>