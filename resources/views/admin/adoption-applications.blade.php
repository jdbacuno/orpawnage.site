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
          <option value="archive" {{ request('status')==='archive' ? 'selected' : '' }}>
            Archived
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
                <!-- Pet Info Button -->
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
                <span class="text-gray-500">Applicant:</span>

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

        <!-- Action Buttons Dropdown - Shows upward -->
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
                {{ $application->status === 'archive' ? 'bg-gray-100 text-gray-700' : '' }}">
                  @switch($application->status)
                  @case('to be confirmed') Waiting @break
                  @case('confirmed') Confirmed @break
                  @case('to be scheduled') To Schedule @break
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
                @if($application->status === 'to be confirmed')
                <form method="POST" action="/admin/adoption-applications/resend-confirmation" class="w-full">
                  @csrf
                  <input type="hidden" name="application_id" value="{{ $application->id }}">
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-orange-700 hover:bg-orange-100 hover:text-orange-900"
                    role="menuitem">
                    Resend Confirmation Email
                  </button>
                </form>
                @endif

                @if($application->status === 'confirmed')
                <form method="POST" action="/admin/adoption-applications/move-to-schedule" class="w-full">
                  @csrf
                  <input type="hidden" name="application_id" value="{{ $application->id }}">
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-100 hover:text-blue-900"
                    role="menuitem">
                    Move to Scheduling
                  </button>
                </form>
                @endif

                @if($application->status === 'to be scheduled')
                <button
                  class="block w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900"
                  role="menuitem" onclick="showApproveModal('{{ $application->id }}')">
                  Send Schedule Link
                </button>
                @endif

                @if($application->status === 'adoption on-going')
                <form method="POST" action="/admin/adoption-applications/mark-picked-up" class="w-full">
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="application_id" value="{{ $application->id }}">
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900"
                    role="menuitem">
                    Mark as Adopted
                  </button>
                </form>
                @endif

                @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled', 'adoption
                on-going']))
                <button
                  class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                  role="menuitem" onclick="showRejectModal('{{ $application->id }}')">
                  Reject Application
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
                    Archive Application
                  </button>
                </form>
                @endif

                @if($application->status === 'rejected')
                <form method="POST" action="/admin/adoption-applications/delete" class="w-full">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="application_id" value="{{ $application->id }}">
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                    role="menuitem">
                    Delete Permanently
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
                    Restore Application
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
      class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative overflow-y-auto scrollbar-hidden max-h-[90vh]">
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

  <!-- Approve Modal -->
  <div id="approveModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeApproveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Send Schedule Link</h2>
      <p class="mb-4 text-green-500 text-sm">This will send an email to the user with a link to schedule pickup.</p>

      <form id="approveForm" method="POST" action="/admin/adoption-applications/send-schedule-link">
        @csrf
        <input type="hidden" name="application_id" id="applicationId">

        <div class="mb-4">
          <label for="pickupDate" class="block text-sm font-medium text-gray-700">Suggested Pickup Date</label>
          <input type="date" id="pickupDate" name="pickup_date"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <button type="submit" class="bg-green-500 px-4 py-2 text-white hover:bg-green-400 rounded-md w-full">
          Send Schedule Link
        </button>
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

    // Show approve modal
    function showApproveModal(id) {
      document.getElementById('applicationId').value = id;
      document.getElementById('approveModal').classList.remove('hidden');
    }

    // Show reject modal
    function showRejectModal(id) {
      document.getElementById('rejectApplicationId').value = id;
      document.getElementById('rejectModal').classList.remove('hidden');
    }

    // Close modals
    document.getElementById('closeApproveModal').addEventListener('click', function() {
      document.getElementById('approveModal').classList.add('hidden');
    });

    document.getElementById('closeRejectModal').addEventListener('click', function() {
      document.getElementById('rejectModal').classList.add('hidden');
    });
  </script>

  <script>
    // Pet and Adopter info modals (existing code)
    document.querySelectorAll('.pet-info-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const modal = document.getElementById('petInfoModal');
        document.getElementById('petImage').src = this.dataset.image;
        document.getElementById('petNumber').value = this.dataset.number;
        document.getElementById('petName').value = this.dataset.name;
        document.getElementById('petSpecies').value = this.dataset.species === 'feline' ? 'Cat' : 'Dog';
        document.getElementById('petAge').value = `${this.dataset.age} ${this.dataset.ageUnit}`;
        document.getElementById('petColor').value = this.dataset.color;
        document.getElementById('petSex').value = this.dataset.sex;
        document.getElementById('petReproStatus').value = this.dataset.reproStatus;
        document.getElementById('petSource').value = this.dataset.source;
        modal.classList.remove('hidden');
      });
    });

    document.getElementById('closePetInfoModal').addEventListener('click', function() {
      document.getElementById('petInfoModal').classList.add('hidden');
    });

    document.querySelectorAll('.adopter-info-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const modal = document.getElementById('adopterInfoModal');
        document.getElementById('adopterName').value = this.dataset.name;
        document.getElementById('adopterEmail').value = this.dataset.email;
        document.getElementById('adopterAge').value = this.dataset.age;
        document.getElementById('adopterBirthdate').value = this.dataset.birthdate;
        document.getElementById('adopterPhone').value = this.dataset.phone;
        document.getElementById('adopterAddress').value = this.dataset.address;
        document.getElementById('adopterCivilStatus').value = this.dataset.civil;
        document.getElementById('adopterCitizenship').value = this.dataset.citizenship;
        document.getElementById('adopterReason').value = this.dataset.reason;
        document.getElementById('adopterVisitVet').value = this.dataset.visitvet;
        document.getElementById('adopterExistingPets').value = this.dataset.existingpets;
        document.getElementById('adopterValidId').href = this.dataset.validid;
        modal.classList.remove('hidden');
      });
    });

    document.getElementById('closeAdopterInfoModal').addEventListener('click', function() {
      document.getElementById('adopterInfoModal').classList.add('hidden');
    });
  </script>
</x-admin-layout>