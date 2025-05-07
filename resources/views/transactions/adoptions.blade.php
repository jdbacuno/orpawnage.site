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
                  data-age-unit="{{ $application->pet->age == 1 ? Str::singular($application->pet->age_unit) : Str::plural($application->pet->age_unit) }}"
                  data-color="{{ ucfirst($application->pet->color) }}" data-sex="{{ $application->pet->sex }}"
                  data-repro-status="{{ $application->pet->reproductive_status }}"
                  data-source="{{ ucfirst($application->pet->source) }}"
                  data-created-at="{{ $application->created_at }}">
                  {{ strtolower($application->pet->pet_name) !== 'n/a' ? ucwords($application->pet->pet_name) :
                  'Unnamed' }} ({{ $application->pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{
                  $application->pet->pet_number }})
                </a>
              </p>
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Adopter:</span> <a href="#"
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

        <!-- Button Section (Fixed at the Bottom) -->
        <div class="p-4 pt-0">
          @if ($application->status === 'to be scheduled')
          <div class="flex items-center gap-2 h-10">
            <button onclick="openScheduleModal({{ $application->id }})"
              class="flex-1 h-full bg-yellow-500 hover:bg-yellow-500 text-black px-2 py-2 rounded-md text-sm truncate">
              <i class="ph-fill ph-calendar mr-1"></i> Schedule
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="flex-1 h-full bg-red-500 text-white px-2 py-2 rounded-md text-sm truncate">
              Cancel
            </button>
          </div>
          @elseif ($application->status === 'adoption on-going')
          <div class="flex items-center gap-2 h-10">
            <button id="scheduledButton"
              class="flex-1 h-full bg-green-500 text-white px-2 py-2 rounded-md text-sm cursor-pointer truncate"
              onclick="openPickupModal('{{ \Carbon\Carbon::parse($application->pickup_date)->format('F j, Y') }}')">
              <i class="ph-fill ph-calendar mr-1"></i> Scheduled
            </button>

            <button onclick="openCancelModal({{ $application->id }})"
              class="flex-1 h-full bg-red-500 text-white px-2 py-2 rounded-md text-sm truncate">
              Cancel
            </button>
          </div>
          @elseif ($application->status === 'rejected')
          <div class="flex items-center gap-2 h-10">
            <button
              class="flex-1 h-full bg-gray-500 text-white px-2 py-2 rounded-md text-sm opacity-75 cursor-not-allowed truncate">
              Rejected
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="flex-1 h-full bg-red-500 text-white px-2 py-2 rounded-md text-sm truncate">
              Delete
            </button>
          </div>
          @elseif ($application->status === 'picked up')
          <button
            class="w-full h-10 bg-gray-500 italic text-white px-2 py-2 rounded-md text-sm opacity-75 cursor-not-allowed truncate"
            disabled>
            Adopted
          </button>
          @elseif ($application->status === 'to be confirmed')
          <div class="flex items-center gap-2 h-10">
            <button onclick="openResendModal({{ $application->id }})"
              class="flex-1 h-full bg-orange-500 hover:bg-orange-600 font-semibold text-white px-2 py-2 rounded-md text-sm transition duration-150 truncate">
              Resend Confirmation
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="flex-1 h-full bg-red-500 text-white px-2 py-2 rounded-md text-sm truncate">
              Cancel
            </button>
          </div>
          @elseif ($application->status === 'confirmed')
          <div class="flex items-center gap-2 h-10">
            <button
              class="flex-1 h-full bg-blue-500 text-white px-2 py-2 rounded-md text-sm cursor-not-allowed truncate"
              disabled>
              Confirmed
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="flex-1 h-full bg-red-500 text-white px-2 py-2 rounded-md text-sm truncate">
              Cancel
            </button>
          </div>
          @elseif ($application->status === 'archive')
          <button class="w-full h-10 bg-gray-500 text-white px-2 py-2 rounded-md text-sm cursor-not-allowed truncate"
            disabled>
            Archived
          </button>
          @else
          <button
            class="w-full h-10 bg-gray-500 text-white px-2 py-2 rounded-md text-sm opacity-75 cursor-not-allowed truncate"
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
          <button type="submit"
            class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Resend</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Schedule Pickup Modal -->
  <div id="scheduleModal" class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Select Pickup Date</h2>
      <p class="text-sm text-gray-600">Please select a date within the next 7 business days (excluding weekends).
        Failure to schedule within 48 hours will result in automatic cancellation.</p>

      <form id="scheduleForm" method="POST" action="{{ url('/transactions/schedule-pickup') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="application_id" id="scheduleAppId">

        <input type="date" name="pickup_date" id="pickupDateInput" class="w-full border px-3 py-2 rounded" required>

        <div class="mt-4 flex justify-end gap-2">
          <button type="button" onclick="closeScheduleModal()"
            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg">Submit</button>
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

  <script>
    function openScheduleModal(appId) {
      // Show the schedule modal
      document.getElementById('scheduleModal').classList.remove('hidden');
      
      // Set the application ID in the hidden field
      document.getElementById('scheduleAppId').value = appId;

      // Dynamically set the action URL for the form
      const formAction = `/transactions/schedule-pickup/${appId}`;
      document.getElementById('scheduleForm').action = formAction;

      // Set the min and max dates for the pickup date input
      const input = document.getElementById('pickupDateInput');
      const allowedDates = getNext7BusinessDays();
      input.min = allowedDates[0];
      input.max = allowedDates[allowedDates.length - 1];
    }

    function closeScheduleModal() {
      // Hide the modal
      document.getElementById('scheduleModal').classList.add('hidden');
    }

    function isWeekend(date) {
      const day = date.getDay();
      return (day === 0 || day === 6);
    }

    function getNext7BusinessDays() {
      const days = [];
      let date = new Date();
      while (days.length < 7) {
        if (!isWeekend(date)) {
          days.push(date.toISOString().split('T')[0]);
        }
        date.setDate(date.getDate() + 1);
      }
      return days;
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
  </script>

</x-transactions-layout>