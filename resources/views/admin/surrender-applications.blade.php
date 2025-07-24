<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Surrender Applications</h1>

  <div class="mt-4">
    {{-- Filter Section --}}
    <div class="flex flex-wrap gap-2 mb-4 items-center">
      <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4 items-center w-full">
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
        <div class="relative ml-auto">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by transaction number, email, or name" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 pl-10 min-w-[250px] focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition" />
          <div class="absolute left-3 inset-y-0 flex items-center h-full pointer-events-none">
            <i class="ph-fill ph-magnifying-glass text-gray-500"></i>
          </div>
        </div>
        @foreach(request()->except(['search', 'page', 'status', 'direction']) as $key => $value)
          <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
        @endforeach
        @if(request('search'))
          <a href="{{ request()->url() }}?{{ http_build_query(request()->except(['search', 'page'])) }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Clear</a>
        @endif
      </form>
    </div>

    @if($surrenderApplications->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No surrender applications found.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      @foreach($surrenderApplications as $application)
      <div
        class="bg-white w-full rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
        <!-- Pet and Owner Info Header -->
        <div class="p-4 border-b border-gray-200">
          <div class="flex items-start space-x-2">
            <!-- Pet Image (placeholder if no image) -->
            <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
              @if($application->animal_photos)
              <img src="{{ asset('storage/' . json_decode($application->animal_photos)[0]) }}"
                alt="{{ $application->pet_name }}" class="w-full h-full object-cover cursor-pointer"
                onclick="openAnimalPhotosModal('{{ $application->id }}', 'pet', 0)">
              @else
              <div class="w-full h-full flex items-center justify-center bg-gray-100">
                <i class="ph-fill ph-paw-print text-2xl text-gray-400"></i>
              </div>
              @endif
            </div>

            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold flex items-center truncate">
                <i class="ph-fill ph-tag mr-2"></i><a href="#"
                  class="owner-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $application->id }}" data-name="{{ $application->full_name }}"
                  data-email="{{ $application->email }}" data-age="{{ $application->age }}"
                  data-birthdate="{{ $application->birthdate->format('M d, Y') }}"
                  data-address="{{ $application->address }}" data-phone="{{ $application->contact_number }}"
                  data-civil="{{ $application->civil_status }}" data-citizenship="{{ $application->citizenship }}"
                  data-reason="{{ $application->reason }}"
                  data-species="{{ ucwords(strtolower($application->species)) }}"
                  data-pet-name="{{ $application->pet_name ? ucwords(strtolower($application->pet_name)) : 'Unnamed' }}"
                  data-breed="{{ $application->breed ? ucwords(strtolower($application->breed)) : 'Unknown' }}"
                  data-validid="{{ asset('storage/' . $application->valid_id_path) }}"
                  data-photos="{{ $application->animal_photos }}" data-id="{{ $application->id }}"
                  data-status="{{ $application->status }}"
                  data-surrender-date="{{ $application->surrender_date ? $application->surrender_date->format('M d, Y') : 'Not set' }}"
                  data-created-at="{{ $application->created_at->format('M d, Y') }}">{{
                  $application->transaction_number
                  }}</a>
                </a>
              </h3>
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Submitted by:</span>
                <span class="font-medium text-gray-900 truncate">{{ ucwords(strtolower($application->full_name))
                  }}</span>
              </p>
              <p class="text-sm">
                <span class="text-gray-500">Status:</span> <span class="px-2 py-1 text-xs rounded 
                  {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
                  {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                  {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
                  {{ $application->status === 'surrender on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
                  {{ $application->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                  {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                  {{ $application->status === 'archived' ? 'bg-gray-100 text-gray-700' : '' }}">
                  @switch($application->status)
                  @case('to be confirmed') Waiting for Confirmation @break
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

        <!-- Action Buttons Dropdown - Admin Side -->
        <div class="bg-gray-50 px-4 py-3 flex justify-end relative z-10">
          <div class="relative inline-block text-left">
            <div>
              <button type="button"
                class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                id="options-menu-{{ $application->id }}" aria-expanded="true" aria-haspopup="true"
                onclick="toggleDropdown('{{ $application->id }}')">
                <span class="mr-2">Actions</span>
                {{-- <span class="px-2 py-1 text-xs rounded 
                  {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
                  {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                  {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
                  {{ $application->status === 'surrender on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
                  {{ $application->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                  {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                  {{ $application->status === 'archived' ? 'bg-gray-100 text-gray-700' : '' }}">
                  @switch($application->status)
                  @case('to be confirmed') Waiting @break
                  @case('confirmed') Confirmed @break
                  @case('to be scheduled') To be Scheduled @break
                  @case('surrender on-going') On-going @break
                  @case('completed') Completed @break
                  @case('rejected') Rejected @break
                  @case('archive') Archived @break
                  @endswitch
                </span> --}}
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
                  <i class="ph-fill ph-calendar-check mr-2"></i> Schedule Surrender
                </button>
                @endif

                @if($application->status === 'surrender on-going')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900"
                  role="menuitem" onclick="showCompleteModal('{{ $application->id }}')">
                  <i class="ph-fill ph-check-circle mr-2"></i> Mark as Completed
                </button>
                @endif

                @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled', 'surrender
                on-going']))
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                  role="menuitem" onclick="showRejectModal('{{ $application->id }}')">
                  <i class="ph-fill ph-x-circle mr-2"></i> Reject Application
                </button>
                @endif

                @if($application->status === 'completed' || $application->status === 'rejected')
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
      {{ $surrenderApplications->links() }}
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

      <h2 class="text-xl font-semibold text-gray-800 mb-4">Details</h2>

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

      <!-- Animal Photos Section -->
      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <label class="text-md font-medium text-gray-600"><i class="ph-fill ph-image mr-2"></i>Photos</label>
        <div id="animalPhotosContainer" class="flex items-center gap-2 mt-2">
          <!-- Photos will be inserted here by JavaScript -->
        </div>
      </div>

      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h4 class="text-md font-medium text-gray-700 mb-2 flex items-center">
          <i class="ph-fill ph-paw-print mr-2"></i>Animal Information
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Pet or Animal Name</label>
            <input type="text" id="petName" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Species</label>
            <input type="text" id="species" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Breed</label>
            <input type="text" id="breed" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>
      </div>

      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h4 class="text-md font-medium text-gray-700 mb-2 flex items-center">
          <i class="ph-fill ph-user-circle mr-2"></i>Surrenderer Information
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
          <label class="text-sm font-medium text-gray-600">Reason for Surrendering</label>
          <div id="surrenderReason" disabled
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Animal Photos Modal -->
  <div id="animalPhotosModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-h-[90vh] flex flex-col">
      <button id="closeAnimalPhotosModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Photos</h2>

      <div class="flex-1 overflow-hidden relative">
        <!-- Main Image Display -->
        <div class="w-full h-full flex items-center justify-center">
          <img id="mainAnimalPhoto" alt="Pet Photo" class="max-h-[60vh] max-w-full object-contain rounded-lg shadow-md">
        </div>

        <!-- Navigation Arrows -->
        <button id="prevPhoto"
          class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
          <i class="ph-fill ph-caret-left"></i>
        </button>
        <button id="nextPhoto"
          class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
          <i class="ph-fill ph-caret-right"></i>
        </button>
      </div>

      <!-- Thumbnail Strip -->
      <div id="photoThumbnails" class="flex gap-2 mt-4 overflow-x-auto py-2">
        <!-- Thumbnails will be inserted here by JavaScript -->
      </div>
    </div>
  </div>

  <!-- Complete Surrender Modal -->
  <div id="completeModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeCompleteModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Confirm Surrender Completion</h2>
      <p class="mb-4">Are you sure you want to mark this surrender as completed?</p>
      <p class="mb-4 text-green-500 text-sm">This will:
      <ul class="list-disc pl-5 text-sm">
        <li>Update the application status to completed</li>
        <li>Send a confirmation email to the owner</li>
      </ul>
      </p>

      <form id="completeForm" method="POST" action="/admin/surrender-applications/completed">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="completeApplicationId">

        <div class="flex justify-end space-x-3 mt-4">
          <button type="button" id="cancelComplete"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
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

      <h2 class="text-xl font-semibold text-gray-800">Reject Surrender</h2>
      <p class="mb-2">Please provide a reason for rejecting this application:</p>
      <p class="my-2 text-red-500 text-sm">This will send an email notification to the user.</p>

      <form id="rejectForm" method="POST" action="/admin/surrender-applications/reject">
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

  <!-- Schedule Surrender Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeScheduleModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Schedule Surrender</h2>
      <p class="mb-4">Please select a date for the surrender:</p>
      <p class="mb-4 text-blue-500 text-sm">Note: Date must be a weekday within 7 business days.</p>

      <form id="scheduleForm" method="POST" action="/admin/surrender-applications/schedule">
        @csrf
        <input type="hidden" name="application_id" id="scheduleApplicationId">

        <div class="mb-4">
          <label for="surrenderDate" class="block text-sm font-medium text-gray-700 mb-1">Surrender Date</label>
          <input type="date" id="surrenderDate" name="surrender_date" required
            class="w-full border border-gray-300 rounded-md p-2" min="{{ now()->format('Y-m-d') }}"
            max="{{ now()->addDays(10)->format('Y-m-d') }}">
          <x-form-error name="surrender_date" />
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
      <p class="mb-4">Are you sure you want to archive this surrender application?</p>
      <p class="mb-4 text-gray-500 text-sm">Archived applications will be moved to a separate section and won't appear
        in the main list.</p>

      <form id="archiveForm" method="POST" action="{{ route('admin.surrender-applications.archive') }}">
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
    document.querySelectorAll('.owner-info-btn').forEach(button => {
      button.addEventListener('click', function() {
        const applicationId = this.dataset.id;
        document.getElementById('ownerName').value = this.dataset.name;
        document.getElementById('ownerEmail').value = this.dataset.email;
        document.getElementById('ownerAge').value = this.dataset.age;
        document.getElementById('ownerBirthdate').value = this.dataset.birthdate;
        document.getElementById('ownerPhone').value = this.dataset.phone;
        document.getElementById('ownerAddress').value = this.dataset.address;
        document.getElementById('ownerCivilStatus').value = this.dataset.civil;
        document.getElementById('ownerCitizenship').value = this.dataset.citizenship;
        document.getElementById('surrenderReason').textContent = this.dataset.reason;
        document.getElementById('petName').value = this.dataset.petName;
        document.getElementById('species').value = this.dataset.species;
        document.getElementById('breed').value = this.dataset.breed;
        
        // Set transaction info
        const status = this.dataset.status;
        const surrenderDate = this.dataset.surrenderDate || 'Not set';
        const createdAt = this.dataset.createdAt;

        console.log('STATUS:',status);
        
        document.getElementById('transactionStatusBadge').textContent = formatStatus(status);
        document.getElementById('transactionStatusBadge').className = `px-2 py-1 text-xs rounded ${getStatusClass(status)}`;
        document.getElementById('transactionSurrenderDate').textContent = surrenderDate;
        document.getElementById('transactionCreatedAt').textContent = createdAt;
        
        // Set up the valid ID view button
        document.getElementById('viewValidId').onclick = function() {
          document.getElementById('modalImage').src = button.dataset.validid;
          document.getElementById('imageModal').classList.remove('hidden');
        };
        
        // Load animal photos
        const photosContainer = document.getElementById('animalPhotosContainer');
        photosContainer.innerHTML = '';
        
        // Get photos from data attribute (assuming it's stored as JSON in the button)
        try {
          const photos = JSON.parse(button.dataset.photos || '[]');
          
          if (photos.length === 0) {
            photosContainer.innerHTML = '<p class="text-gray-500 text-sm">No photos uploaded</p>';
          } else {
            photos.forEach((photo, index) => {
              const photoUrl = "{{ asset('storage/') }}/" + photo;
              const photoElement = document.createElement('div');
              photoElement.className = 'cursor-pointer hover:opacity-80 transition-opacity';
              photoElement.innerHTML = `
                <img src="${photoUrl}" alt="Pet photo ${index + 1}" 
                     class="w-24 h-24 object-cover rounded-md border border-gray-200"
                     onclick="openAnimalPhotosModal(${applicationId}, ${index})">
              `;
              photosContainer.appendChild(photoElement);
            });
          }
        } catch (e) {
          photosContainer.innerHTML = '<p class="text-gray-500 text-sm col-span-3">Error loading photos</p>';
        }
        
        document.getElementById('ownerInfoModal').classList.remove('hidden');
      });
    });

    // Function to open animal photos modal
    function openAnimalPhotosModal(applicationId, startIndex = 0) {
      const button = document.querySelector(`.owner-info-btn[data-id="${applicationId}"]`);
      if (!button) return;
      
      try {
        const photos = JSON.parse(button.dataset.photos || '[]');
        if (photos.length === 0) return;
        
        const modal = document.getElementById('animalPhotosModal');
        const mainImg = document.getElementById('mainAnimalPhoto');
        const thumbnailsContainer = document.getElementById('photoThumbnails');
        
        // Clear previous thumbnails
        thumbnailsContainer.innerHTML = '';
        
        // Set initial image
        let currentIndex = startIndex >= 0 && startIndex < photos.length ? startIndex : 0;
        mainImg.src = "{{ asset('storage/') }}/" + photos[currentIndex];
        
        // Create thumbnails
        photos.forEach((photo, index) => {
          const thumbnail = document.createElement('div');
          thumbnail.className = `flex-shrink-0 w-16 h-16 cursor-pointer border-2 rounded-md overflow-hidden ${index === currentIndex ? 'border-blue-500' : 'border-transparent'}`;
          thumbnail.innerHTML = `<img src="{{ asset('storage/') }}/${photo}" alt="Thumbnail ${index + 1}" class="w-full h-full object-cover">`;
          thumbnail.addEventListener('click', () => {
            currentIndex = index;
            mainImg.src = "{{ asset('storage/') }}/" + photos[currentIndex];
            // Update active thumbnail
            document.querySelectorAll('#photoThumbnails div').forEach((thumb, i) => {
              thumb.className = `flex-shrink-0 w-16 h-16 cursor-pointer border-2 rounded-md overflow-hidden ${i === currentIndex ? 'border-blue-500' : 'border-transparent'}`;
            });
          });
          thumbnailsContainer.appendChild(thumbnail);
        });
        
        // Navigation handlers
        document.getElementById('prevPhoto').onclick = () => {
          currentIndex = (currentIndex - 1 + photos.length) % photos.length;
          mainImg.src = "{{ asset('storage/') }}/" + photos[currentIndex];
          // Update active thumbnail
          document.querySelectorAll('#photoThumbnails div').forEach((thumb, i) => {
            thumb.className = `flex-shrink-0 w-16 h-16 cursor-pointer border-2 rounded-md overflow-hidden ${i === currentIndex ? 'border-blue-500' : 'border-transparent'}`;
          });
        };
        
        document.getElementById('nextPhoto').onclick = () => {
          currentIndex = (currentIndex + 1) % photos.length;
          mainImg.src = "{{ asset('storage/') }}/" + photos[currentIndex];
          // Update active thumbnail
          document.querySelectorAll('#photoThumbnails div').forEach((thumb, i) => {
            thumb.className = `flex-shrink-0 w-16 h-16 cursor-pointer border-2 rounded-md overflow-hidden ${i === currentIndex ? 'border-blue-500' : 'border-transparent'}`;
          });
        };
        
        modal.classList.remove('hidden');
      } catch (e) {
        console.error('Error loading animal photos:', e);
      }
    }

    // Close owner info modal
    document.getElementById('closeOwnerInfoModal').addEventListener('click', function() {
      document.getElementById('ownerInfoModal').classList.add('hidden');
    });

    // Animal photos modal close handler
    document.getElementById('closeAnimalPhotosModal').addEventListener('click', function() {
      document.getElementById('animalPhotosModal').classList.add('hidden');
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

    // Show complete modal
    function showCompleteModal(id) {
      document.getElementById('completeApplicationId').value = id;
      document.getElementById('completeModal').classList.remove('hidden');
    }

    // Close complete modal
    document.getElementById('closeCompleteModal').addEventListener('click', function() {
      document.getElementById('completeModal').classList.add('hidden');
    });

    // Cancel complete
    document.getElementById('cancelComplete').addEventListener('click', function() {
      document.getElementById('completeModal').classList.add('hidden');
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