<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Pet Adoption Applications</h1>

  <div class="bg-white p-6 shadow-md rounded-lg mt-4">
    {{-- Filter Section --}}
    <div class="flex flex-wrap gap-2 mb-4">
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

                {{-- Application Info Button --}}
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
                    {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
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
            <span class="text-sm font-medium text-gray-500">Adopted On</span>
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

        <!-- Action Buttons Dropdown - Admin Side -->
        <div class="bg-gray-50 px-4 py-3 flex justify-end relative z-10">
          <div class="relative inline-block text-left">
            <div>
              <button type="button"
                class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                id="options-menu-{{ $application->id }}" aria-expanded="true" aria-haspopup="true"
                onclick="toggleDropdown('{{ $application->id }}')">
                <span class="mr-2">Actions</span>
                <span class="px-2 py-1 text-xs rounded 
        {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
        {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
        {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
        {{ $application->status === 'adoption on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
        {{ $application->status === 'picked up' ? 'bg-green-100 text-green-700' : '' }}
        {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
        {{ $application->status === 'archived' ? 'bg-gray-100 text-gray-700' : '' }}">
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
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                  fill="currentColor" aria-hidden="true">
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

                @if($application->status === 'confirmed')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-100 hover:text-blue-900"
                  role="menuitem" data-action="move-to-schedule" data-id="{{ $application->id }}">
                  <i class="ph-fill ph-calendar-plus mr-2"></i> Move to Scheduling
                </button>
                @endif

                @if($application->status === 'adoption on-going')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900"
                  role="menuitem" onclick="showPickupModal('{{ $application->id }}')">
                  <i class="ph-fill ph-check-circle mr-2"></i> Mark as Adopted
                </button>
                @endif

                @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled', 'adoption
                on-going']))
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                  role="menuitem" onclick="showRejectModal('{{ $application->id }}')">
                  <i class="ph-fill ph-x-circle mr-2"></i> Reject Application
                </button>
                @endif

                @if($application->status === 'picked up' || $application->status === 'rejected')
                <form method="POST" action="/admin/adoption-applications/archive" class="w-full">
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="application_id" value="{{ $application->id }}">
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem">
                    <i class="ph-fill ph-archive mr-2"></i> Archive
                  </button>
                </form>
                @endif

                @if($application->status === 'archive')
                <form method="POST" action="/admin/adoption-applications/restore" class="w-full">
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="application_id" value="{{ $application->id }}">
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-100 hover:text-blue-900"
                    role="menuitem">
                    <i class="ph-fill ph-arrow-counter-clockwise mr-2"></i> Restore Application
                  </button>
                </form>
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
      {{ $adoptionApplications->links() }}
    </div>
    @endif
  </div>

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
      class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative overflow-y-auto scrollbar-hidden max-h-[90vh]">
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

  <div id="pickupModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closePickupModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Confirm Adoption Completion</h2>
      <p class="mb-4">Are you sure you want to mark this adoption as completed?</p>
      <p class="mb-4 text-green-500 text-sm">This will:
      <ul class="list-disc pl-5 text-sm">
        <li>Update the pet's status to adopted</li>
        <li>Send a congratulatory email to the adopter</li>
        <li>Notify other applicants that this pet has been adopted</li>
      </ul>
      </p>

      <form id="pickupForm" method="POST" action="/admin/adoption-applications/pickedup">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="pickupApplicationId">

        <div class="flex justify-end space-x-3 mt-4">
          <button type="button" id="cancelPickup" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-green-500 px-4 py-2 text-white hover:bg-green-400 rounded-md">
            Confirm Completion
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Reject Modal -->
  <div id="rejectModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeRejectModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Reject Adoption</h2>
      <p class="mb-2">Please provide a reason for rejecting this application:</p>
      <p class="my-2 text-red-500 text-sm">This will send an email notification to the user.</p>

      <form id="rejectForm" method="POST" action="/admin/adoption-applications/reject">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="rejectApplicationId">

        <label for="rejectReason" class="block font-medium text-gray-700">Reason:</label>
        <textarea id="rejectReason" name="reject_reason" class="w-full border p-2 rounded-md mb-4" required></textarea>
        <x-form-error name="reject_reason" />

        <button type="submit" class="bg-red-500 px-4 py-2 text-white hover:bg-red-400 rounded-md w-full">
          Reject Application
        </button>
      </form>
    </div>
  </div>

  <!-- Move to Schedule Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeScheduleModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Move to Scheduling</h2>
      <p class="mb-4">Are you sure you want to move this application to scheduling?</p>
      <p class="mb-4 text-blue-500 text-sm">This will send an email notification to the user with scheduling
        instructions.</p>

      <form id="scheduleForm" method="POST" action="/admin/adoption-applications/move-to-schedule">
        @csrf
        <input type="hidden" name="application_id" id="scheduleApplicationId">

        <div class="flex justify-end space-x-3">
          <button type="button" id="cancelSchedule"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 rounded-md">
            Confirm
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Improved toggle function for upward dropdown
    function toggleDropdown(id) {
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

    // Show reject modal
    function showRejectModal(id) {
      document.getElementById('rejectApplicationId').value = id;
      document.getElementById('rejectModal').classList.remove('hidden');
    }

    document.getElementById('closeRejectModal').addEventListener('click', function() {
      document.getElementById('rejectModal').classList.add('hidden');
    });

    // mark as adopted
    function showPickupModal(id) {
        document.getElementById('pickupApplicationId').value = id;
        document.getElementById('pickupModal').classList.remove('hidden');
    }

    document.getElementById('closePickupModal').addEventListener('click', function() {
        document.getElementById('pickupModal').classList.add('hidden');
    });

    document.getElementById('cancelPickup').addEventListener('click', function() {
        document.getElementById('pickupModal').classList.add('hidden');
    });
  </script>
</x-admin-layout>