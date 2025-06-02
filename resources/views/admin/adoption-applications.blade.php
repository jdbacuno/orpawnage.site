<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Pet Adoption Applications</h1>

  <div class="mt-4">
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
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      @foreach($adoptionApplications as $application)
      <div
        class="bg-white w-full rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
        <!-- Pet and Adopter Info Header -->
        <div class="p-4 border-b border-gray-200">
          <div class="flex items-start space-x-2">
            <!-- Pet Image (placeholder if no image) -->
            <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
              <img src="{{ asset('storage/' . $application->pet->image_path) }}" alt="{{ $application->pet->pet_name }}"
                class="w-full h-full object-cover cursor-pointer" onclick="openPetPhotoModal(this)">
            </div>

            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold flex items-center truncate">
                <i class="ph-fill ph-tag mr-2"></i><a href="#"
                  class="transaction-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $application->id }}" data-name="{{ $application->full_name }}"
                  data-email="{{ $application->email }}" data-age="{{ $application->age }}"
                  data-birthdate="{{ $application->birthdate->format('M d, Y') }}"
                  data-address="{{ $application->address }}" data-phone="{{ $application->contact_number }}"
                  data-civil="{{ $application->civil_status }}" data-citizenship="{{ $application->citizenship }}"
                  data-reason="{{ $application->reason_for_adoption }}"
                  data-visitvet="{{ $application->visit_veterinarian }}"
                  data-existingpets="{{ $application->existing_pets }}"
                  data-validid="{{ asset('storage/' . $application->valid_id) }}"
                  data-status="{{ $application->status }}"
                  data-pickup-date="{{ $application->pickup_date ? $application->pickup_date->format('M d, Y') : 'Not set' }}"
                  data-created-at="{{ $application->created_at->format('M d, Y') }}"
                  data-pet-number="{{ $application->pet->pet_number }}"
                  data-pet-name="{{ strtolower($application->pet->pet_name) !== 'n/a' ? ucwords($application->pet->pet_name) : 'Unnamed' }}"
                  data-pet-species="{{ $application->pet->species === 'feline' ? 'Cat' : 'Dog' }}"
                  data-pet-age="{{ $application->pet->age }}"
                  data-pet-age-unit="{{ $application->pet->age == 1 ? Str::singular($application->pet->age_unit) : Str::plural($application->pet->age_unit) }}"
                  data-pet-color="{{ ucfirst($application->pet->color) }}"
                  data-pet-sex="{{ ucfirst($application->pet->sex) }}"
                  data-pet-repro-status="{{ ucfirst($application->pet->reproductive_status) }}"
                  data-pet-source="{{ ucfirst($application->pet->source) }}">{{ $application->transaction_number
                  }}</a>
              </h3>
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Adopter:</span>
                <span class="font-medium text-gray-900 truncate">{{ $application->full_name }}</span>
              </p>
              <p class="text-sm">
                <span class="text-gray-500">Status:</span> <span class="px-2 py-1 text-xs rounded 
                  {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
                  {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                  {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
                  {{ $application->status === 'adoption on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
                  {{ $application->status === 'picked up' ? 'bg-green-100 text-green-700' : '' }}
                  {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                  {{ $application->status === 'archived' ? 'bg-gray-100 text-gray-700' : '' }}">
                  @switch($application->status)
                  @case('to be confirmed') Waiting Confirmation @break
                  @case('confirmed') Confirmed @break
                  @case('to be scheduled') To be Scheduled @break
                  @case('adoption on-going') On-going @break
                  @case('picked up') Adopted @break
                  @case('rejected') Rejected @break
                  @case('archive') Archived @break
                  @endswitch
                </span>
              </p>
            </div>
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

                @if($application->status === 'to be scheduled')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900"
                  role="menuitem" onclick="showScheduleModal('{{ $application->id }}')">
                  <i class="ph-fill ph-calendar-check mr-2"></i> Schedule Adoption
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
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                  role="menuitem" onclick="showArchiveModal('{{ $application->id }}')">
                  <i class="ph-fill ph-archive mr-2"></i> Archive
                </button>
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

  <!-- Adopter Info Modal -->
  <div id="adopterInfoModal"
    class="fixed inset-0 px-2 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative max-h-[90vh] overflow-y-auto scrollbar-hidden">
      <!-- Close Button -->
      <button id="closeAdopterInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 mb-4">Adoption Application Details</h2>

      <!-- Transaction Info Section -->
      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
          <i class="ph-fill ph-receipt mr-2"></i>Transaction Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Status</label>
            <div class="mt-1">
              <span id="transactionStatusBadge" class="px-2 py-1 text-xs rounded"></span>
            </div>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Pickup Date</label>
            <div class="mt-1 text-sm text-gray-900" id="transactionPickupDate"></div>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Date Applied</label>
            <div class="mt-1 text-sm text-gray-900" id="transactionCreatedAt"></div>
          </div>
          <div class="flex gap-x-2 items-center">
            <label class="text-sm font-medium text-gray-600">Valid ID</label>
            <div>
              <button id="viewValidId" class="text-blue-500 hover:underline text-sm hover:text-blue-600 cursor-pointer">
                View Uploaded ID
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Pet Info Section -->
      @if (count($adoptionApplications) > 0)
      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
          <i class="ph-fill ph-paw-print mr-2"></i>Pet Information
        </h3>
        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md overflow-hidden">
            <img id="petImagePreview" src="{{ asset('storage/' . $application->pet->image_path) }}" alt="Pet Image"
              class="w-full h-full object-cover cursor-pointer" onclick="openPetPhotoModal(this)">
          </div>

          <div class="grid grid-cols-2 gap-4 flex-1">
            <div>
              <label class="text-sm font-medium text-gray-500">Name</label>
              <div class="mt-1 text-sm text-gray-900" id="petName"></div>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Species</label>
              <div class="mt-1 text-sm text-gray-900" id="petSpecies"></div>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Age</label>
              <div class="mt-1 text-sm text-gray-900" id="petAge"></div>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Sex</label>
              <div class="mt-1 text-sm text-gray-900" id="petSex"></div>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Reproductive Status</label>
              <div class="mt-1 text-sm text-gray-900" id="petReproductive"></div>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Source</label>
              <div class="mt-1 text-sm text-gray-900" id="petSource"></div>
            </div>
          </div>
        </div>
      </div>
      @endif

      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h4 class="text-md font-medium text-gray-700 mb-2 flex items-center">
          <i class="ph-fill ph-user-circle mr-2"></i>Adopter Information
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
          <div id="adopterReason" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pet Photo Modal -->
  <div id="petPhotoModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-h-[90vh] flex flex-col">
      <button id="closePetPhotoModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Pet Photo</h2>

      <div class="flex-1 overflow-hidden relative">
        <!-- Main Image Display -->
        <div class="w-full h-full flex items-center justify-center">
          <img id="mainPetPhoto" alt="Pet Photo" class="max-h-[60vh] max-w-full object-contain rounded-lg shadow-md">
        </div>
      </div>
    </div>
  </div>

  <!-- Mark as Adopted Modal -->
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

  <!-- Schedule Adoption Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeScheduleModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Schedule Adoption</h2>
      <p class="mb-4">Please select a date for the adoption:</p>
      <p class="mb-4 text-blue-500 text-sm">Note: Date must be a weekday within 7 business days.</p>

      <form id="scheduleForm" method="POST" action="/admin/adoption-applications/schedule">
        @csrf
        <input type="hidden" name="application_id" id="scheduleApplicationId">

        <div class="mb-4">
          <label for="pickupDate" class="block text-sm font-medium text-gray-700 mb-1">Adoption Date</label>
          <input type="date" id="pickupDate" name="pickup_date" required
            class="w-full border border-gray-300 rounded-md p-2" min="{{ now()->format('Y-m-d') }}"
            max="{{ now()->addDays(10)->format('Y-m-d') }}">
          <x-form-error name="pickup_date" />
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" id="cancelSchedule"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 rounded-md">
            Schedule
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Archive Confirmation Modal -->
  <div id="archiveModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeArchiveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 flex items-center"> <i class="ph-fill ph-archive mr-2"></i>Confirm
        Archive</h2>
      <p class="mb-4">Are you sure you want to archive this adoption application?</p>
      <p class="mb-4 text-gray-500 text-sm">Archived applications will be moved to a separate section and won't appear
        in the main list.</p>

      <form id="archiveForm" method="POST" action="{{ route('admin.adoption-applications.archive') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="archiveApplicationId">

        <div class="flex justify-end space-x-3 mt-4">
          <button type="button" id="cancelArchive" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-gray-600 px-4 py-2 text-white hover:bg-gray-500 rounded-md flex items-center">
            <i class="ph-fill ph-archive mr-2"></i>Confirm Archive
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Image Modal -->
  <div id="imageModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-h-[90vh] overflow-auto">
      <button id="closeImageModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800">Uploaded ID</h2>
      <div class="w-full mt-2 flex justify-center items-center">
        <img id="modalImage" alt="Uploaded ID" class="max-h-[70vh] max-w-full object-contain rounded-lg shadow-md">
      </div>
    </div>
  </div>

  <script>
    // Helper function to get status class
    function getStatusClass(status) {
      switch(status) {
        case 'to be confirmed': return 'bg-orange-100 text-orange-700';
        case 'confirmed': return 'bg-blue-100 text-blue-700';
        case 'to be scheduled': return 'bg-yellow-100 text-yellow-700';
        case 'adoption on-going': return 'bg-indigo-100 text-indigo-700';
        case 'picked up': return 'bg-green-100 text-green-700';
        case 'rejected': return 'bg-red-100 text-red-700';
        case 'archive': return 'bg-gray-100 text-gray-700';
        default: return '';
      }
    }

    // Helper function to format status text
    function formatStatus(status) {
      switch(status) {
        case 'to be confirmed': return 'Waiting Confirmation';
        case 'picked up': return 'Adopted';
        default: return status.charAt(0).toUpperCase() + status.slice(1);
      }
    }

    // Adopter Info Modal with new features
    document.querySelectorAll('.transaction-info-btn').forEach(button => {
      button.addEventListener('click', function() {
        document.getElementById('adopterName').value = this.dataset.name;
        document.getElementById('adopterEmail').value = this.dataset.email;
        document.getElementById('adopterAge').value = this.dataset.age;
        document.getElementById('adopterBirthdate').value = this.dataset.birthdate;
        document.getElementById('adopterPhone').value = this.dataset.phone;
        document.getElementById('adopterAddress').value = this.dataset.address;
        document.getElementById('adopterCivilStatus').value = this.dataset.civil;
        document.getElementById('adopterCitizenship').value = this.dataset.citizenship;
        document.getElementById('adopterVisitVet').value = this.dataset.visitvet;
        document.getElementById('adopterExistingPets').value = this.dataset.existingpets;
        document.getElementById('adopterReason').textContent = this.dataset.reason;

        document.getElementById('petName').textContent = this.dataset.petName + ` (#${this.dataset.petNumber})`;
        document.getElementById('petAge').textContent = this.dataset.petAge + ' ' + this.dataset.petAgeUnit;
        document.getElementById('petSpecies').textContent = this.dataset.petSpecies;
        document.getElementById('petSex').textContent = this.dataset.petSex;
        document.getElementById('petReproductive').textContent = this.dataset.petReproStatus;
        document.getElementById('petSource').textContent = this.dataset.petSource;

        // Set transaction info
        const status = this.dataset.status;
        const pickupDate = this.dataset.pickupDate || 'Not set';
        const createdAt = this.dataset.createdAt;
        
        document.getElementById('transactionStatusBadge').textContent = formatStatus(status);
        document.getElementById('transactionStatusBadge').className = `px-2 py-1 text-xs rounded ${getStatusClass(status)}`;
        document.getElementById('transactionPickupDate').textContent = pickupDate;
        document.getElementById('transactionCreatedAt').textContent = createdAt;
        
        // Set up the valid ID view button
        document.getElementById('viewValidId').onclick = function() {
          document.getElementById('modalImage').src = button.dataset.validid;
          document.getElementById('imageModal').classList.remove('hidden');
        };

        document.getElementById('adopterInfoModal').classList.remove('hidden');
      });
    });

    // Open pet photo modal
    function openPetPhotoModal(imgElement) {
      const petImageSrc = imgElement.src;
      if (!petImageSrc) return;

      document.getElementById('mainPetPhoto').src = petImageSrc;
      document.getElementById('petPhotoModal').classList.remove('hidden');
    }

    // Close adopter info modal
    document.getElementById('closeAdopterInfoModal').addEventListener('click', function() {
      document.getElementById('adopterInfoModal').classList.add('hidden');
    });

    // Close pet photo modal
    document.getElementById('closePetPhotoModal').addEventListener('click', function() {
      document.getElementById('petPhotoModal').classList.add('hidden');
    });

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

    // Show pickup modal
    function showPickupModal(id) {
      document.getElementById('pickupApplicationId').value = id;
      document.getElementById('pickupModal').classList.remove('hidden');
    }

    // Close pickup modal
    document.getElementById('closePickupModal').addEventListener('click', function() {
      document.getElementById('pickupModal').classList.add('hidden');
    });

    // Cancel pickup
    document.getElementById('cancelPickup').addEventListener('click', function() {
      document.getElementById('pickupModal').classList.add('hidden');
    });

    // Show reject modal
    function showRejectModal(id) {
      document.getElementById('rejectApplicationId').value = id;
      document.getElementById('rejectModal').classList.remove('hidden');
    }

    document.getElementById('closeRejectModal').addEventListener('click', function() {
      document.getElementById('rejectModal').classList.add('hidden');
    });

    // Show schedule modal
    function showScheduleModal(id) {
      document.getElementById('scheduleApplicationId').value = id;
      document.getElementById('scheduleModal').classList.remove('hidden');
    }

    document.getElementById('closeScheduleModal').addEventListener('click', function() {
      document.getElementById('scheduleModal').classList.add('hidden');
    });

    document.getElementById('cancelSchedule').addEventListener('click', function() {
      document.getElementById('scheduleModal').classList.add('hidden');
    });

    // Show archive modal
    function showArchiveModal(id) {
      document.getElementById('archiveApplicationId').value = id;
      document.getElementById('archiveModal').classList.remove('hidden');
    }

    // Close archive modal
    document.getElementById('closeArchiveModal').addEventListener('click', function() {
      document.getElementById('archiveModal').classList.add('hidden');
    });

    // Cancel archive
    document.getElementById('cancelArchive').addEventListener('click', function() {
      document.getElementById('archiveModal').classList.add('hidden');
    });

    // Close image modal
    document.getElementById('closeImageModal').addEventListener('click', function() {
      document.getElementById('imageModal').classList.add('hidden');
    });
  </script>
</x-admin-layout>