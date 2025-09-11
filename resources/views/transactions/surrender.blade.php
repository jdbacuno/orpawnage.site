<x-transactions-layout>
  <div class="flex flex-wrap items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Surrender Applications</h1>
  </div>

  <!-- Filters Section -->
  <div class="mt-4">
    <div class="flex flex-wrap gap-4 mb-4">
      <form method="GET" action="{{ request()->url() }}" class="relative flex items-center mt-2 sm:mt-0">
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Transaction number, email, or name"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 pl-10 min-w-[300px] focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition" />
        <div class="absolute left-3 inset-y-0 flex items-center h-full pointer-events-none">
          <i class="ph-fill ph-magnifying-glass text-gray-500"></i>
        </div>
        @foreach(request()->except(['search', 'page']) as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
        @endforeach
        @if(request('search'))
        <a href="{{ request()->url() }}?{{ http_build_query(request()->except(['search', 'page'])) }}"
          class="ml-2 px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Clear</a>
        @endif
      </form>
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
          <option value="surrender on-going" {{ request('status')==='surrender on-going' ? 'selected' : '' }}>
            Surrender On-going
          </option>
          <option value="completed" {{ request('status')==='completed' ? 'selected' : '' }}>
            Completed
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

    @if($applications->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No surrender applications found.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      @foreach($applications as $application)
      <div
        class="bg-white w-full rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
        <!-- Pet and Owner Info Header -->
        <div class="p-4 border-b border-gray-200">
          <div class="flex items-start space-x-2">
            <!-- First Photo -->
            <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
              @if($application->animal_photos)
              <img src="{{ asset('storage/' . json_decode($application->animal_photos)[0]) }}"
                alt="{{ $application->pet_name }}" class="w-full h-full object-cover cursor-pointer"
                onclick='openPhotosModal({{ json_encode(json_decode($application->animal_photos)) }}, 0)'>
              @else
              <div class=" w-full h-full flex items-center justify-center bg-gray-100">
                <i class="ph-fill ph-paw-print text-2xl text-gray-400"></i>
              </div>
              @endif
            </div>

            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold flex items-center truncate">
                <i class="ph-fill ph-tag mr-2"></i><a href="#"
                  class="transaction-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $application->id }}" data-name="{{ $application->full_name }}"
                  data-email="{{ $application->email }}" data-age="{{ $application->age }}"
                  data-birthdate="{{ $application->birthdate ? \Carbon\Carbon::parse($application->birthdate)->format('M d, Y') : 'Not set' }}"
                  data-address="{{ $application->address }}" data-phone="{{ $application->contact_number }}"
                  data-civil="{{ $application->civil_status }}" data-citizenship="{{ $application->citizenship }}"
                  data-reason="{{ $application->reason }}"
                  data-validid="{{ asset('storage/' . $application->valid_id_path) }}"
                  data-status="{{ $application->status }}"
                  data-surrender-date="{{ $application->surrender_date ? \Carbon\Carbon::parse($application->surrender_date)->format('M d, Y') : 'Not set' }}"
                  data-created-at="{{ $application->created_at ? \Carbon\Carbon::parse($application->created_at)->format('M d, Y') : 'Not set' }}"
                  data-transaction-number="{{ $application->transaction_number }}"
                  data-pet-name="{{ $application->pet_name ?? 'Unnamed' }}"
                  data-pet-species="{{ $application->species === 'feline' ? 'Cat' : 'Dog' }}"
                  data-pet-breed="{{ $application->breed ?? 'Unknown' }}"
                  data-pet-sex="{{ ucfirst($application->sex) }}" data-animal-photos="{{ $application->animal_photos }}"
                  data-reject-reason="{{ $application->reject_reason ?? '' }}">
                  {{ $application->transaction_number }}
                </a>
              </h3>
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Owner:</span>
                <span class="font-medium text-gray-900 truncate">{{ $application->full_name }}</span>
              </p>
              <p class="text-sm">
                <span class="text-gray-500">Status:</span> <span class="px-2 py-1 text-xs rounded 
    {{ ($application->previous_status ?? $application->status) === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'surrender on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'completed' ? 'bg-green-100 text-green-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'archived' ? 'bg-gray-100 text-gray-700' : '' }}">
                  @switch($application->previous_status ?? $application->status)
                  @case('to be confirmed') Waiting Confirmation @break
                  @case('confirmed') Confirmed @break
                  @case('to be scheduled') To be Scheduled @break
                  @case('surrender on-going') On-going @break
                  @case('completed') Completed @break
                  @case('rejected') Rejected @break
                  @case('archive') Archived @break
                  @endswitch
                </span>
              </p>
            </div>
          </div>
        </div>

        <!-- Action Buttons Dropdown - User Side -->
        <div class="bg-gray-50 px-4 py-3 flex justify-end relative">
          <div class="relative inline-block text-left">
            <div>
              <button type="button"
                class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                id="options-menu-{{ $application->id }}" aria-expanded="true" aria-haspopup="true"
                onclick="toggleDropdownMenu('{{ $application->id }}')">
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

                @if(($application->previous_status ?? $application->status) === 'to be scheduled')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900"
                  role="menuitem" onclick="openScheduleModal({{ $application->id }})">
                  <i class="ph-fill ph-calendar mr-2"></i> Schedule Surrender
                </button>
                @endif

                @if(($application->previous_status ?? $application->status) === 'surrender on-going')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900"
                  role="menuitem"
                  onclick="openSurrenderModal('{{ $application->surrender_date ? \Carbon\Carbon::parse($application->surrender_date)->format('M d, Y') : 'Not set' }}')">
                  <i class="ph-fill ph-calendar-check mr-2"></i> View Schedule
                </button>
                @endif

                @if(($application->previous_status ?? $application->status) === 'to be confirmed')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-orange-700 hover:bg-orange-100 hover:text-orange-900"
                  role="menuitem" onclick="openResendModal({{ $application->id }})">
                  <i class="ph-fill ph-envelope-simple-open mr-2"></i> Resend Confirmation
                </button>
                @endif

                @if(in_array(($application->previous_status ?? $application->status), ['to be confirmed', 'confirmed',
                'to be scheduled']))
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                  role="menuitem" onclick="openCancelModal({{ $application->id }})">
                  <i class="ph-fill ph-x-circle mr-2"></i> Cancel Application
                </button>
                @endif

                @if(($application->previous_status ?? $application->status) === 'rejected')
                <div class="block w-full text-left px-4 py-2 text-sm text-gray-500 italic">
                  <i class="ph-fill ph-x-circle mr-2"></i> Application Rejected
                </div>
                @endif

                @if(($application->previous_status ?? $application->status) === 'completed' ||
                ($application->previous_status ?? $application->status) === 'archived')
                <div class="block w-full text-left px-4 py-2 text-sm text-gray-500 italic">
                  <i class="ph-fill ph-check-circle mr-2"></i> Surrender Completed
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
      {{ $applications->appends(request()->except('page'))->links() }}
    </div>
    @endif
  </div>

  <!-- Owner Info Modal -->
  <div id="ownerInfoModal"
    class="fixed inset-0 px-2 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative max-h-[90vh] overflow-y-auto scrollbar-hidden">
      <!-- Close Button -->
      <button id="closeOwnerInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 mb-4">Surrender Application Details</h2>

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
            <label class="text-sm font-medium text-gray-600">Surrender Date</label>
            <div class="mt-1 text-sm text-gray-900" id="transactionSurrenderDate"></div>
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
      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
          <i class="ph-fill ph-paw-print mr-2"></i>Pet Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-medium text-gray-500">Name</label>
            <div class="mt-1 text-sm text-gray-900" id="petName"></div>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Species</label>
            <div class="mt-1 text-sm text-gray-900" id="petSpecies"></div>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Breed</label>
            <div class="mt-1 text-sm text-gray-900" id="petBreed"></div>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-500">Sex</label>
            <div class="mt-1 text-sm text-gray-900" id="petSex"></div>
          </div>
        </div>
      </div>

      <!-- Pet Photos Section -->
      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
          <i class="ph-fill ph-images mr-2"></i>Pet Photos
        </h3>
        <div class="flex flex-wrap gap-2" id="petPhotosContainer">
          <!-- Pet photos will be inserted here by JavaScript -->
        </div>
      </div>

      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h4 class="text-md font-medium text-gray-700 mb-2 flex items-center">
          <i class="ph-fill ph-user-circle mr-2"></i>Owner Information
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Name</label>
            <input type="text" id="ownerName" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Email</label>
            <input type="text" id="ownerEmail" disabled
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Age</label>
            <input type="text" id="ownerAge" disabled
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Birthdate</label>
            <input type="text" id="ownerBirthdate" disabled
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Contact Number</label>
            <input type="text" id="ownerPhone" disabled
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Address</label>
            <input type="text" id="ownerAddress" disabled
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Civil Status</label>
            <input type="text" id="ownerCivilStatus" disabled
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Citizenship</label>
            <input type="text" id="ownerCitizenship" disabled
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <div class="mt-4">
          <label class="text-sm font-medium text-gray-600">Reason for Surrender</label>
          <div id="ownerReason" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
          </div>
        </div>

        @if($application->reject_reason ?? false)
        <div class="mt-4">
          <label class="text-sm font-medium text-gray-600">Rejection Reason</label>
          <div id="rejectReason" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Valid ID Modal -->
  <div id="validIdModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-h-[90vh] flex flex-col">
      <button id="closeValidIdModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Owner's Valid ID</h2>

      <div class="flex-1 overflow-hidden relative">
        <!-- Main Image Display -->
        <div class="w-full h-full flex items-center justify-center">
          <img id="mainValidIdPhoto" alt="Valid ID" class="max-h-[60vh] max-w-full object-contain rounded-lg shadow-md">
        </div>
      </div>
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

  <!-- Cancel Confirmation Modal -->
  <div id="cancelModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Action</h2>
      <p class="text-sm text-gray-600">Are you sure you want to cancel this adoption request? This action will remove
        your application from our records.</p>

      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <input type="hidden" name="id" id="deleteId">
          <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-400 text-white rounded-lg">Confirm</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Resend Confirmation Modal -->
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

  <!-- Schedule Surrender Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-100">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Select Surrender Date</h2>
      <p class="text-sm text-gray-600 mb-4">Please select a weekday (Monday-Friday) within the next 7 business days.
      </p>

      <form id="scheduleForm" method="POST" action="{{ url('/transactions/schedule-surrender') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="application_id" id="scheduleAppId">

        <input type="date" name="surrender_date" id="surrenderDateInput" class="w-full border px-3 py-2 rounded"
          required min="" max="">

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

  <!-- Surrender Date Modal -->
  <div id="surrenderModal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-1">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full space-y-4 relative">
      <button id="closeSurrenderModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold">Scheduled Surrender Date</h2>
      <p id="surrenderDateText" class="text-lg font-medium text-gray-700"></p>
      <p class="text-sm text-gray-600">Failure to visit after 3 business days from your scheduled date will cancel the
        surrender.</p>
    </div>
  </div>

  <!-- Image Gallery Modal (NEW) -->
  <div id="photosModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-w-4xl max-h-[90vh] flex flex-col">
      <button id="closePhotosModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-xl font-semibold text-gray-800 mb-4" id="photosModalTitle">Pet Photos</h2>
      <div class="flex-1 overflow-hidden relative">
        <div class="w-full h-full flex items-center justify-center">
          <img id="mainPhoto" alt="Photo" class="max-h-[60vh] max-w-full object-cover rounded-lg shadow-md">
        </div>
      </div>
      <div id="photoThumbnails" class="flex gap-2 mt-4 overflow-x-auto py-2">
        <!-- Thumbnails will be inserted here by JavaScript -->
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
        case 'surrender on-going': return 'bg-indigo-100 text-indigo-700';
        case 'completed': return 'bg-green-100 text-green-700';
        case 'rejected': return 'bg-red-100 text-red-700';
        case 'archive': return 'bg-gray-100 text-gray-700';
        default: return '';
      }
    }

    // Helper function to format status text
    function formatStatus(status) {
      switch(status) {
        case 'to be confirmed': return 'Waiting Confirmation';
        case 'completed': return 'Completed';
        default: return status.charAt(0).toUpperCase() + status.slice(1);
      }
    }

    // Owner Info Modal with new features
    document.querySelectorAll('.transaction-info-btn').forEach(button => {
      button.addEventListener('click', function() {
        document.getElementById('ownerName').value = this.dataset.name;
        document.getElementById('ownerEmail').value = this.dataset.email;
        document.getElementById('ownerAge').value = this.dataset.age;
        document.getElementById('ownerBirthdate').value = this.dataset.birthdate;
        document.getElementById('ownerPhone').value = this.dataset.phone;
        document.getElementById('ownerAddress').value = this.dataset.address;
        document.getElementById('ownerCivilStatus').value = this.dataset.civil;
        document.getElementById('ownerCitizenship').value = this.dataset.citizenship;
        document.getElementById('ownerReason').textContent = this.dataset.reason;
        
        if (this.dataset.rejectReason) {
          document.getElementById('rejectReason').textContent = this.dataset.rejectReason;
        }

        document.getElementById('petName').textContent = this.dataset.petName;
        document.getElementById('petSpecies').textContent = this.dataset.petSpecies;
        document.getElementById('petBreed').textContent = this.dataset.petBreed;
        document.getElementById('petSex').textContent = this.dataset.petSex;

        // Set transaction info
        const status = this.dataset.status;
        const surrenderDate = this.dataset.surrenderDate || 'Not set';
        const createdAt = this.dataset.createdAt;
        
        document.getElementById('transactionStatusBadge').textContent = formatStatus(status);
        document.getElementById('transactionStatusBadge').className = `px-2 py-1 text-xs rounded ${getStatusClass(status)}`;
        document.getElementById('transactionSurrenderDate').textContent = surrenderDate;
        document.getElementById('transactionCreatedAt').textContent = createdAt;
        
        // Set up the valid ID view button
        document.getElementById('viewValidId').onclick = function() {
          document.getElementById('modalImage').src = button.dataset.validid;
          document.getElementById('imageModal').classList.remove('hidden');
        };

        // Load pet photos
        const petPhotosContainer = document.getElementById('petPhotosContainer');
        petPhotosContainer.innerHTML = '';
        const animalPhotos = JSON.parse(this.dataset.animalPhotos);
        
        animalPhotos.forEach((photo, idx) => {
          const imgBtn = document.createElement('button');
          imgBtn.className = 'show-image-btn';
          imgBtn.dataset.image = "{{ asset('storage/') }}/" + photo;
          imgBtn.dataset.index = idx;
          imgBtn.type = 'button';
          imgBtn.title = 'View in gallery';

          const img = document.createElement('img');
          img.src = "{{ asset('storage/') }}/" + photo;
          img.alt = 'Pet photo';
          img.className = 'w-16 h-16 object-cover rounded border border-gray-300 hover:border-blue-500';

          imgBtn.appendChild(img);
          imgBtn.addEventListener('click', function(e) {
            openPhotosModal(animalPhotos, idx);
          });

          petPhotosContainer.appendChild(imgBtn);
        });

        document.getElementById('ownerInfoModal').classList.remove('hidden');
      });
    });

    // Open valid ID modal
    function openValidIdModal(imgElement) {
      const validIdSrc = imgElement.src;
      if (!validIdSrc) return;

      document.getElementById('mainValidIdPhoto').src = validIdSrc;
      document.getElementById('validIdModal').classList.remove('hidden');
    }

    // Close owner info modal
    document.getElementById('closeOwnerInfoModal').addEventListener('click', function() {
      document.getElementById('ownerInfoModal').classList.add('hidden');
    });

    // Close valid ID modal
    document.getElementById('closeValidIdModal').addEventListener('click', function() {
      document.getElementById('validIdModal').classList.add('hidden');
    });

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

    // Close image modal
    document.getElementById('closeImageModal').addEventListener('click', function() {
      document.getElementById('imageModal').classList.add('hidden');
    });

    // Schedule Surrender Modal
    function openScheduleModal(appId) {
      document.getElementById('scheduleModal').classList.remove('hidden');
      document.getElementById('scheduleAppId').value = appId;

      const formAction = `/transactions/schedule-surrender/${appId}`;
      document.getElementById('scheduleForm').action = formAction;

      const allowedDates = getNext7BusinessDays();
      const input = document.getElementById('surrenderDateInput');
      
      input.min = allowedDates[0];
      input.max = allowedDates[allowedDates.length - 1];
      input.value = '';
      
      input.addEventListener('input', function() {
        const selectedDate = new Date(this.value);
        if (isWeekend(selectedDate)) {
          alert('Weekends are not allowed. Please select a weekday (Monday-Friday).');
          this.value = '';
        }
      });
    }

    function isWeekend(date) {
      const day = date.getDay();
      return (day === 0 || day === 6);
    }

    function getNext7BusinessDays() {
      const days = [];
      let date = new Date();
      let daysAdded = 0;
      
      while (daysAdded < 7) {
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
      document.getElementById('scheduleModal').classList.add('hidden');
    }

    function openSurrenderModal(surrenderDate) {
      document.getElementById('surrenderModal').classList.remove('hidden');
      document.getElementById('surrenderDateText').innerText = `Your scheduled surrender date is: ${surrenderDate}`;
    }

    // Close the modal when the close button is clicked
    document.getElementById('closeSurrenderModalBtn').addEventListener('click', function () {
      closeSurrenderModal();
    });

    function closeSurrenderModal() {
      document.getElementById('surrenderModal').classList.add('hidden');
    }

    function openCancelModal(appId) {
      document.getElementById('cancelModal').classList.remove('hidden');
      document.getElementById('deleteForm').action = `/transactions/surrender-status/${appId}`;
    }

    function closeCancelModal() {
      document.getElementById('cancelModal').classList.add('hidden');
    }

    function openResendModal(appId) {
      document.getElementById('resendModal').classList.remove('hidden');
      document.getElementById('resendForm').action = `/transactions/${appId}/resend-surrender-email`;
    }

    function closeResendModal() {
      document.getElementById('resendModal').classList.add('hidden');
    }

    // Image Gallery Modal logic (copied/adapted from missing.blade.php)
    function openPhotosModal(photos, startIndex = 0) {
      if (!photos || photos.length === 0) return;
      const modal = document.getElementById('photosModal');
      const mainImg = document.getElementById('mainPhoto');
      const thumbnailsContainer = document.getElementById('photoThumbnails');
      const modalTitle = document.getElementById('photosModalTitle');
      modalTitle.textContent = 'Pet Photos';
      thumbnailsContainer.innerHTML = '';
      let currentIndex = startIndex >= 0 && startIndex < photos.length ? startIndex : 0;
      mainImg.src = "{{ asset('storage/') }}/" + photos[currentIndex];
      photos.forEach((photo, index) => {
        const thumbnail = document.createElement('div');
        thumbnail.className = `flex-shrink-0 w-16 h-16 cursor-pointer border-2 rounded-md overflow-hidden ${index === currentIndex ? 'border-blue-500' : 'border-transparent'}`;
        thumbnail.innerHTML = `<img src=\"{{ asset('storage/') }}/${photo}\" alt=\"Thumbnail ${index + 1}\" class=\"w-full h-full object-cover\">`;
        thumbnail.addEventListener('click', () => {
          currentIndex = index;
          mainImg.src = "{{ asset('storage/') }}/" + photos[currentIndex];
          document.querySelectorAll('#photoThumbnails div').forEach((thumb, i) => {
            thumb.className = `flex-shrink-0 w-16 h-16 cursor-pointer border-2 rounded-md overflow-hidden ${i === currentIndex ? 'border-blue-500' : 'border-transparent'}`;
          });
        });
        thumbnailsContainer.appendChild(thumbnail);
      });
      modal.classList.remove('hidden');
    }

    document.getElementById('closePhotosModal').addEventListener('click', function() {
      document.getElementById('photosModal').classList.add('hidden');
    });
  </script>
</x-transactions-layout>