<x-transactions-layout>
  <div class="mb-6">
    <div class="rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-[1px]">
      <div class="rounded-xl bg-white">
        <div class="px-5 py-5 sm:px-6 sm:py-6 flex flex-col gap-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i class="ph-fill ph-handshake"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-900">Adoption Applications</h1>
                <p class="text-sm text-gray-500">Track and manage your adoption requests</p>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap gap-2">
            <a href="/transactions/adoption-status"
              class="px-3 py-1.5 text-sm rounded-full bg-indigo-600 text-white shadow-sm">Adoptions</a>
            <a href="/transactions/surrender-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Surrenders</a>
            <a href="/transactions/missing-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Missing Pets</a>
            <a href="/transactions/abused-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Abused/Stray</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters Section -->
  <div class="mt-4">
    <div class="flex flex-wrap gap-4 mb-4 bg-white rounded-lg p-4 shadow-sm border border-gray-200">
      <form method="GET" action="{{ request()->url() }}" class="relative flex items-center mt-2 sm:mt-0">
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Transaction number, email, or name"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 pl-10 min-w-[280px] focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 transition shadow-inner" />
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
      <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4 items-center">
        <!-- Status Filter -->
        <select name="status"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 min-w-[180px] focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
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
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px] focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
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
    <div
      class="flex flex-col items-center justify-center p-10 text-center bg-white rounded-lg border border-gray-200 shadow-sm">
      <img src="{{ asset('images/login-img.jpg') }}" class="h-20 w-20 opacity-70 mb-3 rounded-full" alt="Empty" />
      <p class="text-lg font-medium text-gray-700">No adoption applications found</p>
      <p class="text-sm text-gray-500">Try changing filters or check back later.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      @foreach($adoptionApplications as $application)
      <div
        class="bg-white w-full rounded-xl shadow-sm overflow-hidden border border-gray-200 hover:shadow-md hover:-translate-y-[2px] transition-all duration-200">
        <!-- Pet and Adopter Info Header -->
        <div class="p-4 border-b border-gray-100">
          <div class="flex items-start space-x-2">
            <!-- Pet Image (placeholder if no image) -->
            <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden ring-1 ring-gray-200">
              <img src="{{ asset('storage/' . $application->pet->image_path) }}" alt="{{ $application->pet->pet_name }}"
                class="w-full h-full object-cover cursor-pointer" onclick="openPetPhotoModal(this)">
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
                  data-reason="{{ $application->reason_for_adoption }}"
                  data-visitvet="{{ $application->visit_veterinarian }}"
                  data-existingpets="{{ $application->existing_pets }}"
                  data-validid="{{ asset('storage/' . $application->valid_id) }}"
                  data-status="{{ $application->status }}"
                  data-pickup-date="{{ $application->pickup_date ? \Carbon\Carbon::parse($application->pickup_date)->format('M d, Y') : 'Not set' }}"
                  data-created-at="{{ $application->created_at->format('M d, Y') }}"
                  data-pet-number="{{ $application->pet->pet_number }}"
                  data-pet-name="{{ strtolower($application->pet->pet_name) !== 'n/a' ? ucwords($application->pet->pet_name) : 'Unnamed' }}"
                  data-pet-species="{{ $application->pet->species === 'feline' ? 'Cat' : 'Dog' }}"
                  data-pet-age="{{ $application->pet->age }}"
                  data-pet-age-unit="{{ $application->pet->age == 1 ? Str::singular($application->pet->age_unit) : Str::plural($application->pet->age_unit) }}"
                  data-pet-color="{{ ucfirst($application->pet->color) }}"
                  data-pet-sex="{{ ucfirst($application->pet->sex) }}"
                  data-pet-repro-status="{{ ucfirst($application->pet->reproductive_status) }}"
                  data-pet-source="{{ ucfirst($application->pet->source) }}"
                  data-pet-image-path="{{ $application->pet->image_path }}">{{ $application->transaction_number
                  }}</a>
              </h3>
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Adopter:</span>
                <span class="font-medium text-gray-900 truncate">{{ $application->full_name }}</span>
              </p>
              <p class="text-sm">
                <span class="text-gray-500">Status:</span> <span class="px-2 py-1 text-xs rounded-md ring-1 ring-inset 
    {{ ($application->previous_status ?? $application->status) === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'adoption on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'picked up' ? 'bg-green-100 text-green-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
    {{ ($application->previous_status ?? $application->status) === 'archived' ? 'bg-gray-100 text-gray-700' : '' }}">
                  @switch($application->previous_status ?? $application->status)
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
                  <i class="ph-fill ph-calendar mr-2"></i> Schedule Pickup
                </button>
                @endif

                @if(($application->previous_status ?? $application->status) === 'adoption on-going')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900"
                  role="menuitem"
                  onclick="openPickupModal('{{ \Carbon\Carbon::parse($application->pickup_date)->format('M d, Y') }}')">
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

                @if(($application->previous_status ?? $application->status) === 'picked up' ||
                ($application->previous_status ?? $application->status) === 'archived')
                <div class="block w-full text-left px-4 py-2 text-sm text-gray-500 italic">
                  <i class="ph-fill ph-check-circle mr-2"></i> Adoption Completed
                </div>
                @endif

                @if(($application->previous_status ?? $application->status) === 'rejected')
                <div class="block w-full text-left px-4 py-2 text-sm text-gray-500 italic">
                  <i class="ph-fill ph-x-circle mr-2"></i> Application Rejected
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
          <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md overflow-hidden" id="petInfoSection">
            <img class="w-full h-full object-cover cursor-pointer" onclick="openPetPhotoModal(this)">
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
              <label class="text-sm font-medium text-gray-500">Color</label>
              <div class="mt-1 text-sm text-gray-900" id="petColor"></div>
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
  @if (count($adoptionApplications) > 0)
  <div id="cancelModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Action</h2>
      <p class="text-sm text-gray-600">Are you sure you want to cancel this adoption request? This action will remove
        your application from our records.</p>

      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="deleteForm" method="POST" action="{{ url('/adoption-status/' . $application->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-400 text-white rounded-lg">Confirm</button>
        </form>
      </div>
    </div>
  </div>
  @endif

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

  <!-- Schedule Pickup Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-100">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Select Pickup Date</h2>
      <p class="text-sm text-gray-600 mb-4">Please select a weekday (Monday-Friday) within the next 7 business days.
      </p>

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
        document.getElementById('petColor').textContent = this.dataset.petColor;
        document.getElementById('petReproductive').textContent = this.dataset.petReproStatus;
        document.getElementById('petSource').textContent = this.dataset.petSource;

        // Set pet image for the modal
        const petImageSrc = "{{ asset('storage/') }}/" + this.dataset.petImagePath;
        document.querySelector('#petInfoSection img').src = petImageSrc;
        document.querySelector('#petInfoSection img').alt = this.dataset.petName;

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

    // Schedule Pickup Modal
    function openScheduleModal(appId) {
      document.getElementById('scheduleModal').classList.remove('hidden');
      document.getElementById('scheduleAppId').value = appId;

      const formAction = `/transactions/schedule-pickup/${appId}`;
      document.getElementById('scheduleForm').action = formAction;

      const allowedDates = getNext7BusinessDays();
      const input = document.getElementById('pickupDateInput');
      
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

    function openPickupModal(pickupDate) {
      document.getElementById('pickupModal').classList.remove('hidden');
      document.getElementById('pickupDateText').innerText = `Your scheduled pickup date is: ${pickupDate}`;
    }

    // Close the modal when the close button is clicked
    document.getElementById('closePickupModalBtn').addEventListener('click', function () {
      closePickupModal();
    });

    function closePickupModal() {
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
      document.getElementById('resendForm').action = `/transactions/${appId}/resend-email`;
    }

    function closeResendModal() {
      document.getElementById('resendModal').classList.add('hidden');
    }
  </script>
</x-transactions-layout>