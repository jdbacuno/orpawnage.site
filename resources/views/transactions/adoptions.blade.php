<x-transactions-layout>
  <h1 class="text-lg sm:text-2xl font-bold text-gray-900 mt-0 sm:mt-10">Adoption Applications</h1>

  <!-- Filters Section -->
  <div class="flex flex-wrap gap-2 my-4">
    <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4">
      <!-- Status Filter -->
      <select name="status"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[180px]"
        onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="to be confirmed" {{ request('status')==='to be confirmed' ? 'selected' : '' }}>
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
        <option value="archive" {{ request('status')==='archive' ? 'selected' : '' }}>
          Archived
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
            <h3 class="text-lg font-semibold flex items-center truncate"><i class="ph-fill ph-tag mr-2"></i> {{
              $application->transaction_number }}</h3>
            <p class="text-sm font-medium text-gray-900 truncate">
              <a href="#" class="pet-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                data-id="{{ $application->id }}" data-image="{{ asset('storage/' . $application->pet->image_path) }}"
                data-number="{{ $application->pet->pet_number }}"
                data-name="{{ strtolower($application->pet->pet_name) !== 'n/a' ? ucwords($application->pet->pet_name) : 'Unnamed' }}"
                data-species="{{ $application->pet->species }}" data-age="{{ $application->pet->age }}"
                data-age-unit="{{ $application->pet->age == 1 ? Str::singular($application->pet->age_unit) : Str::plural($application->pet->age_unit) }}"
                data-color="{{ ucfirst($application->pet->color) }}" data-sex="{{ $application->pet->sex }}"
                data-repro-status="{{ $application->pet->reproductive_status }}"
                data-source="{{ ucfirst($application->pet->source) }}"
                data-created-at="{{ $application->pet->created_at }}">
                {{ strtolower($application->pet->pet_name) !== 'n/a' ? ucwords($application->pet->pet_name) :
                'Unnamed' }} ({{ $application->pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{
                $application->pet->pet_number }})
              </a>
            </p>
            <p class="text-sm mt-1 truncate">
              <span class="text-gray-500">Adopter:</span>
              <a href="#" class="adopter-info-btn text-blue-500 hover:text-blue-600 hover:underline"
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
                    {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-600' : '' }}
                    {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $application->status === 'adoption on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
                    {{ $application->status === 'picked up' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $application->status === 'archive' ? 'bg-gray-100 text-gray-700' : '' }}">
            @switch($application->status)
            @case('to be confirmed')
            Waiting Confirmation
            @break
            @case('picked up')
            Adopted
            @break
            @default
            {{ ucfirst($application->status) }}
            @endswitch
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

      <!-- Action Buttons - User Side -->
      <div class="bg-gray-50 px-4 py-3 flex justify-end relative">
        <div class="relative inline-block text-left">
          <div>
            <button type="button"
              class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
              id="options-menu-{{ $application->id }}" aria-expanded="true" aria-haspopup="true"
              onclick="toggleDropdownMenu('{{ $application->id }}')">
              <span class="mr-2">Actions</span>
              <span class="px-2 py-1 text-xs rounded 
        {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
        {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
        {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
        {{ $application->status === 'adoption on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
        {{ $application->status === 'picked up' ? 'bg-green-100 text-green-700' : '' }}
        {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
        {{ $application->status === 'archive' ? 'bg-gray-100 text-gray-700' : '' }}">
                @switch($application->status)
                @case('to be confirmed') Waiting @break
                @case('confirmed') Confirmed @break
                @case('to be scheduled') To be Scheduled @break
                @case('adoption on-going') On-going @break
                @case('picked up') Adopted @break
                @case('rejected') Rejected @break
                @case('archive') Archived @break
                @endswitch
              </span>
              <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </button>
          </div>

          <!-- Dropdown menu positioned upward -->
          <div
            class="origin-bottom-right absolute right-0 bottom-full mb-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50"
            id="dropdown-{{ $application->id }}">
            <div class="py-1" role="menu" aria-orientation="vertical"
              aria-labelledby="options-menu-{{ $application->id }}">

              @if($application->status === 'to be scheduled')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900"
                role="menuitem" onclick="openScheduleModal({{ $application->id }})">
                <i class="ph-fill ph-calendar mr-2"></i> Schedule Pickup
              </button>
              @endif

              @if($application->status === 'adoption on-going')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900"
                role="menuitem"
                onclick="openPickupModal('{{ \Carbon\Carbon::parse($application->pickup_date)->format('F j, Y') }}')">
                <i class="ph-fill ph-calendar-check mr-2"></i> View Schedule
              </button>
              @endif

              @if($application->status === 'to be confirmed')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-orange-700 hover:bg-orange-100 hover:text-orange-900"
                role="menuitem" onclick="openResendModal({{ $application->id }})">
                <i class="ph-fill ph-envelope-simple-open mr-2"></i> Resend Confirmation
              </button>
              @endif

              @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled', 'adoption
              on-going']))
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                role="menuitem" onclick="openCancelModal({{ $application->id }})">
                <i class="ph-fill ph-x-circle mr-2"></i> Cancel Application
              </button>
              @endif

              @if($application->status === 'rejected')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                role="menuitem" onclick="openCancelModal({{ $application->id }})">
                <i class="ph-fill ph-trash mr-2"></i> Delete Application
              </button>
              @endif

              @if($application->status === 'picked up')
              <div class="block w-full text-left px-4 py-2 text-sm text-gray-500 italic">
                <i class="ph-fill ph-check-circle mr-2"></i> Adoption Completed
              </div>
              @endif

              @if($application->status === 'archive')
              <div class="block w-full text-left px-4 py-2 text-sm text-gray-500 italic">
                <i class="ph-fill ph-archive mr-2"></i> Archived
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $adoptionApplications->appends(request()->except('page'))->links() }}
  </div>
  @endif

  @if(!$adoptionApplications->isEmpty())
  <!-- Cancel Confirmation Modal -->
  <div id="cancelModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Action</h2>
      <p class="text-sm text-gray-600">Are you sure you want to cancel this adoption request?</p>

      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="deleteForm" method="POST" action="{{ url('/transactions/' . $application->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-400 text-white rounded-lg">Confirm</button>
        </form>
      </div>
    </div>
  </div>
  @endif

  <!-- Pet Info Modal -->
  <div id="petInfoModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-md w-full max-w-4xl relative overflow-y-auto scrollbar-hidden max-h-[90vh]">
      <!-- Close Button (X) -->
      <button id="closePetInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <div class="flex flex-col sm:flex-row gap-6">
        <!-- Pet Image on the left -->
        <div class="w-full sm:w-2/5">
          <!-- Pet Name and Number Badge at the top -->
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800" id="petName"></h2>
            <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full flex items-center">
              <span id="petNumber"></span>
            </span>
          </div>
          <img id="petImage" src="" alt="Pet Image" class="w-full h-64 sm:h-80 object-cover rounded-lg">
        </div>

        <!-- Pet Details on the right -->
        <div class="w-full sm:w-3/5">
          <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
              <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="ph-fill ph-paw-print mr-2 text-orange-500"></i>Pet Details
              </h3>
              <span class="bg-black/10 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                <i class="ph-fill ph-clock mr-1"></i> <span id="petTimeAgo">Loading...</span>
              </span>
            </div>

            <!-- Badge Grid -->
            <div class="grid grid-cols-2 gap-3">
              <!-- Species -->
              <div class="bg-blue-50 text-blue-800 px-4 py-3 rounded-lg border border-blue-100 flex flex-col">
                <p class="text-xs font-medium text-blue-600 flex items-center">
                  <i class="ph-fill ph-dog mr-1" id="speciesIcon"></i> Species
                </p>
                <p class="font-medium mt-1" id="petSpecies"></p>
              </div>

              <!-- Age -->
              <div class="bg-purple-50 text-purple-800 px-4 py-3 rounded-lg border border-purple-100 flex flex-col">
                <p class="text-xs font-medium text-purple-600 flex items-center">
                  <i class="ph-fill ph-cake mr-1"></i> Age
                </p>
                <p class="font-medium mt-1" id="petAge"></p>
              </div>

              <!-- Sex -->
              <div class="bg-blue-50 text-blue-800 border-blue-100 px-4 py-3 rounded-lg border flex flex-col"
                id="sexContainer">
                <p class="text-xs font-medium text-blue-600 flex items-center" id="sexLabel">
                  <i class="ph-fill ph-gender-male mr-1"></i> Sex
                </p>
                <p class="font-medium mt-1" id="petSex"></p>
              </div>

              <!-- Reproductive Status -->
              <div class="bg-green-50 text-green-800 border-green-100 px-4 py-3 rounded-lg border flex flex-col"
                id="reproStatusContainer">
                <p class="text-xs font-medium text-gray-600 flex items-center">
                  <i class="ph-fill ph-scissors mr-1" id="reproStatusIcon"></i> Reproductive
                </p>
                <p class="font-medium mt-1" id="petReproStatus"></p>
              </div>

              <!-- Color -->
              <div class="bg-indigo-50 text-indigo-800 px-4 py-3 rounded-lg border border-indigo-100 flex flex-col">
                <p class="text-xs font-medium text-indigo-600 flex items-center">
                  <i class="ph-fill ph-palette mr-1"></i> Color
                </p>
                <p class="font-medium mt-1" id="petColor"></p>
              </div>

              <!-- Source -->
              <div class="bg-gray-50 text-gray-800 px-4 py-3 rounded-lg border border-gray-200 flex flex-col">
                <p class="text-xs font-medium text-gray-600 flex items-center">
                  <i class="ph-fill ph-buildings mr-1"></i> Source
                </p>
                <p class="font-medium mt-1" id="petSource"></p>
              </div>
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
            <button id="viewValidId" class="text-blue-500 underline text-sm hover:text-blue-600 cursor-pointer">
              View Uploaded ID
            </button>
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

  {{-- RESEND CONFIRMATION EMAIL MODAL --}}
  <div id="resendModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Resend</h2>
      <p class="text-sm text-gray-600">Are you sure you want to resend the confirmation email?</p>
      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeResendModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="resendForm" method="POST" action="">
          @csrf
          <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-400">Resend</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Schedule Pickup Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-100">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Select Pickup Date</h2>
      <p class="text-sm text-gray-600 mb-4">Please select a weekday (Monday-Friday) within the next 7 business days.</p>

      <form id="scheduleForm" method="POST" action="{{ url('/transactions/schedule-pickup') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="application_id" id="scheduleAppId">

        <input type="date" name="pickup_date" id="pickupDateInput" class="w-full border px-3 py-2 rounded" required
          min="" max="">

        <div class="mt-4 flex justify-end gap-2">
          <button type="button" onclick="closeScheduleModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Pickup Date Modal -->
  <div id="pickupModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-1">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full space-y-4 relative">
      <!-- Close Button -->
      <button id="closePickupModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold">Scheduled Pickup Date</h2>
      <p id="pickupDateText" class="text-lg font-medium text-gray-700"></p>
      <p class="text-sm text-gray-600">Failure to visit after 3 business days from your scheduled date will cancel the
        adoption.</p>
    </div>
  </div>

  {{-- VALID ID --}}
  <div id="imageModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-h-[90vh] overflow-auto">
      <button id="closeImageModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800 mb-2">Uploaded Valid ID</h2>
      <div class="w-full mt-2 flex justify-center items-center">
        <img id="modalImage" alt="Uploaded ID" class="max-h-[70vh] max-w-full object-contain rounded-lg shadow-md">
      </div>
    </div>
  </div>

  <script>
    // Improved toggle function for upward dropdown
    function toggleDropdownMenu(id) {
      const dropdown = document.getElementById(`dropdown-${id}`);
      dropdown.classList.toggle('hidden');
      
      // Close other open dropdowns
      document.querySelectorAll('[id^="dropdown-"]').forEach(otherDropdown => {
        if (otherDropdown.id !== `dropdown-${id}` && !otherDropdown.classList.contains('hidden')) {
          otherDropdown.classList.add('hidden');
        }
      });
      
      // Prevent the click from propagating to document
      event.stopPropagation();
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
      document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
        dropdown.classList.add('hidden');
      });
    });

    function openScheduleModal(appId) {
      // Show the schedule modal
      document.getElementById('scheduleModal').classList.remove('hidden');
      
      // Set the application ID in the hidden field
      document.getElementById('scheduleAppId').value = appId;

      // Dynamically set the action URL for the form
      const formAction = `/transactions/schedule-pickup/${appId}`;
      document.getElementById('scheduleForm').action = formAction;

      // Get the next 7 business days
      const allowedDates = getNext7BusinessDays();
      const input = document.getElementById('pickupDateInput');
      
      // Set min and max dates
      input.min = allowedDates[0];
      input.max = allowedDates[allowedDates.length - 1];
      
      // Clear any previous value
      input.value = '';
      
      // Add event listener to prevent weekend selection
      input.addEventListener('input', function() {
        const selectedDate = new Date(this.value);
        if (isWeekend(selectedDate)) {
          alert('Weekends are not allowed. Please select a weekday (Monday-Friday).');
          this.value = '';
        }
      });
    }

    // Disable weekends in the date picker
    document.getElementById('pickupDateInput').addEventListener('focus', function() {
      const allowedDates = getNext7BusinessDays();
      this.setAttribute('min', allowedDates[0]);
      this.setAttribute('max', allowedDates[allowedDates.length - 1]);
    });

    function isWeekend(date) {
      const day = date.getDay();
      return (day === 0 || day === 6); // 0 = Sunday, 6 = Saturday
    }

    function getNext7BusinessDays() {
      const days = [];
      let date = new Date();
      let daysAdded = 0;
      
      // Skip weekends and get the next 7 business days
      while (daysAdded < 7) {
        // Skip weekends
        if (!isWeekend(date)) {
          days.push(formatDate(date));
          daysAdded++;
        }
        date.setDate(date.getDate() + 1);
      }
      
      return days;
    }

    function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }

    function closeScheduleModal() {
      // Hide the modal
      document.getElementById('scheduleModal').classList.add('hidden');
    }

    function openPickupModal(pickupDate) {
      // Show the modal
      document.getElementById('pickupModal').classList.remove('hidden');
      
      // Set the pickup date in the modal
      document.getElementById('pickupDateText').innerText = `Your scheduled pickup date is: ${pickupDate}`;
    }

    // Close the modal when the close button is clicked
    document.getElementById('closePickupModalBtn').addEventListener('click', function () {
      closePickupModal();
    });

    function closePickupModal() {
      // Hide the modal
      document.getElementById('pickupModal').classList.add('hidden');
    }

    function openCancelModal(appId) {
      document.getElementById('cancelModal').classList.remove('hidden');
      document.getElementById('deleteForm').action = `/transactions/adoption-status/${appId}`;
    }

    function closeCancelModal() {
      document.getElementById('cancelModal').classList.add('hidden');
    }

    function openResendModal(appId) {
      document.getElementById('resendModal').classList.remove('hidden');
      document.getElementById('resendForm').action = `/transactions/resend-confirmation/${appId}`;
    }

    function closeResendModal() {
      document.getElementById('resendModal').classList.add('hidden');
    }

    // Pet Info Modal functionality
    document.querySelectorAll('.pet-info-btn').forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        const modal = document.getElementById('petInfoModal');
        
        // Set pet data
        document.getElementById('petImage').src = this.dataset.image;
        document.getElementById('petName').textContent = this.dataset.name;
        document.getElementById('petNumber').textContent = '#' + this.dataset.number;
        document.getElementById('petSpecies').textContent = this.dataset.species === 'feline' ? 'Cat' : 'Dog';
        document.getElementById('petAge').textContent = `${this.dataset.age} ${this.dataset.ageUnit} old`;
        document.getElementById('petSex').textContent = this.dataset.sex;
        document.getElementById('petReproStatus').textContent = this.dataset.reproStatus;
        document.getElementById('petColor').textContent = this.dataset.color;
        document.getElementById('petSource').textContent = this.dataset.source;
        
        // Set species icon
        const speciesIcon = document.getElementById('speciesIcon');
        speciesIcon.className = this.dataset.species === 'feline' ? 'ph-fill ph-cat mr-1' : 'ph-fill ph-dog mr-1';
        
        // Set sex icon and colors
        const sexContainer = document.getElementById('sexContainer');
        const sexLabel = document.getElementById('sexLabel');
        if (this.dataset.sex === 'Male') {
          sexContainer.className = 'bg-blue-50 text-blue-800 border-blue-100 px-4 py-3 rounded-lg border flex flex-col';
          sexLabel.innerHTML = '<i class="ph-fill ph-gender-male mr-1"></i> Sex';
        } else {
          sexContainer.className = 'bg-pink-50 text-pink-800 border-pink-100 px-4 py-3 rounded-lg border flex flex-col';
          sexLabel.innerHTML = '<i class="ph-fill ph-gender-female mr-1"></i> Sex';
        }
        
        // Set reproductive status icon
        const reproStatusIcon = document.getElementById('reproStatusIcon');
        if (this.dataset.reproStatus === 'Neutered' || this.dataset.reproStatus === 'Spayed') {
          reproStatusIcon.className = 'ph-fill ph-scissors mr-1 text-green-500';
        } else {
          reproStatusIcon.className = 'ph-fill ph-scissors mr-1 text-gray-500';
        }
        
        // Calculate time ago
        const createdAt = new Date(this.dataset.createdAt);
        const now = new Date();
        const diffInDays = Math.floor((now - createdAt) / (1000 * 60 * 60 * 24));
        
        let timeAgo;
        if (diffInDays === 0) {
          timeAgo = 'Today';
        } else if (diffInDays === 1) {
          timeAgo = 'Yesterday';
        } else {
          timeAgo = `${diffInDays} days ago`;
        }
        
        document.getElementById('petTimeAgo').textContent = timeAgo;
        
        // Show modal
        modal.classList.remove('hidden');
      });
    });

    // Adopter's Info Modal
    document.addEventListener('DOMContentLoaded', function () {
      const adopterInfoModal = document.getElementById('adopterInfoModal');
      const closeAdopterInfoModal = document.getElementById('closeAdopterInfoModal');
      const viewValidIdBtn = document.getElementById('viewValidId'); // Get the view button

      document.querySelectorAll(".adopter-info-btn").forEach(button => {
        button.addEventListener("click", function(e) {
          e.preventDefault();
          // Assign to modal
          document.getElementById("adopterName").value = this.getAttribute("data-name");
          document.getElementById("adopterEmail").value = this.getAttribute("data-email");
          document.getElementById("adopterAge").value = this.getAttribute("data-age") + " years old";
          document.getElementById("adopterBirthdate").value = this.getAttribute("data-birthdate");
          document.getElementById("adopterAddress").value = this.getAttribute("data-address");
          document.getElementById("adopterPhone").value = this.getAttribute("data-phone");
          document.getElementById("adopterCivilStatus").value = this.getAttribute("data-civil");
          document.getElementById("adopterCitizenship").value = this.getAttribute("data-citizenship");
          document.getElementById("adopterReason").value = this.getAttribute("data-reason");
          document.getElementById("adopterVisitVet").value = this.getAttribute("data-visitvet");
          document.getElementById("adopterExistingPets").value = this.getAttribute("data-existingpets");
          
          // Set the data-src attribute on the view button instead of href
          viewValidIdBtn.setAttribute('data-src', this.getAttribute('data-validid'));

          adopterInfoModal.classList.remove("hidden");
        });
      });

      closeAdopterInfoModal.addEventListener('click', function (e) {
        e.preventDefault();
        adopterInfoModal.classList.add('hidden');
      });

      // Add click handler for viewing the ID
      viewValidIdBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const validIdUrl = this.getAttribute('data-src');
        if (validIdUrl) {
          document.getElementById('modalImage').src = validIdUrl;
          document.getElementById('imageModal').classList.remove('hidden');
        }
      });
    });

    // Close image modal
    document.getElementById('closeImageModal').addEventListener('click', function() {
      document.getElementById('imageModal').classList.add('hidden');
    });

    // Close modals
    document.getElementById('closePetInfoModal').addEventListener('click', function() {
      document.getElementById('petInfoModal').classList.add('hidden');
    });

    document.getElementById('closeAdopterInfoModal').addEventListener('click', function() {
      document.getElementById('adopterInfoModal').classList.add('hidden');
    });

    // View Valid ID in modal
    document.addEventListener('click', function(e) {
      if (e.target && e.target.id === 'viewValidId') {
        const validIdUrl = document.getElementById('adopterValidId').getAttribute('data-src');
        document.getElementById('modalImage').src = validIdUrl;
        document.getElementById('imageModal').classList.remove('hidden');
      }
    });

    // Close image modal
    document.getElementById('closeImageModal').addEventListener('click', function() {
      document.getElementById('imageModal').classList.add('hidden');
    });
  </script>
</x-transactions-layout>