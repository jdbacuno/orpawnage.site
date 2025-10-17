<x-transactions-layout>
  <div class="max-w-[1600px] mx-auto">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">My Adoption Applications</h1>
      <p class="text-sm text-gray-600 mt-1">Track and manage your adoption applications</p>
    </div>

    <!-- Global Alerts -->
    @if (session('success'))
    <div id="global-alert-success"
      class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 border-l-4 border-green-400" role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">{!! session('success') !!}</div>
      <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
        onclick="this.parentElement.remove()" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
      </button>
    </div>
    @endif

    @if (session('error'))
    <div id="global-alert-error"
      class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 border-l-4 border-red-400" role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
      <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
        onclick="this.parentElement.remove()" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
      </button>
    </div>
    @endif

    <!-- Status Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
      <div class="border-b border-gray-200">
        <nav class="flex overflow-x-auto scrollbar-hidden" aria-label="Tabs">
          <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-files mr-2"></i>
            All Applications
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'to be confirmed']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'to be confirmed' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-clock mr-2"></i>
            Waiting Confirmation
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'confirmed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-check-circle mr-2"></i>
            Confirmed
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'to be scheduled']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'to be scheduled' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-calendar mr-2"></i>
            To Be Scheduled
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'adoption on-going']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'adoption on-going' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-hourglass mr-2"></i>
            On-going
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'picked up']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'picked up' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-check-square mr-2"></i>
            Adopted
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-x-circle mr-2"></i>
            Rejected
          </a>
        </nav>
      </div>

      <!-- Search and Sort -->
      <div class="p-4 bg-gray-50 border-b border-gray-200">
        <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4 items-center">
          <div class="flex-1 min-w-[250px]">
            <div class="relative">
              <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by transaction number, email, or name"
                class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 pl-10 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition" />
              <div class="absolute left-3 inset-y-0 flex items-center h-full pointer-events-none">
                <i class="ph-fill ph-magnifying-glass text-gray-500"></i>
              </div>
            </div>
          </div>

          <select name="direction"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
            onchange="this.form.submit()">
            <option value="desc" {{ request('direction', 'desc' )==='desc' ? 'selected' : '' }}>Newest First</option>
            <option value="asc" {{ request('direction')==='asc' ? 'selected' : '' }}>Oldest First</option>
          </select>

          <input type="hidden" name="status" value="{{ request('status') }}" />

          @if(request('search'))
          <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
            class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
            <i class="ph-fill ph-x mr-1"></i>Clear
          </a>
          @endif
        </form>
      </div>
    </div>

    @if($adoptionApplications->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
      <i class="ph-fill ph-file-search text-6xl text-gray-300 mb-4"></i>
      <p class="text-lg text-gray-500">No adoption applications found.</p>
    </div>
    @else
    <!-- Applications Grid -->
    <div class="space-y-6">
      @foreach($adoptionApplications as $application)
      <div
        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
        <!-- Application Header -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 p-4 sm:p-6">
          <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
            <!-- Pet Image -->
            <a href="{{ asset('storage/' . $application->pet->image_path) }}" target="_blank"
              class="flex-shrink-0 w-20 h-20 sm:w-32 sm:h-32 bg-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow group mx-auto sm:mx-0">
              <img src="{{ asset('storage/' . $application->pet->image_path) }}" alt="{{ $application->pet->pet_name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
            </a>

            <div class="flex-1 min-w-0 w-full">
              <div class="flex flex-col gap-4 mb-4">
                <div class="min-w-0 flex-1">
                  <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                    {{ $application->transaction_number }}
                  </h2>
                  <div class="flex flex-wrap gap-2 mb-3">
                    <span
                      class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 inline-flex items-center">
                      <i class="ph-fill ph-paw-print mr-1 flex-shrink-0"></i>
                      <span class="truncate max-w-[120px] sm:max-w-none">{{ strtolower($application->pet->pet_name) !==
                        'n/a' ? ucwords($application->pet->pet_name) : 'Unnamed' }}</span>
                    </span>
                    <span
                      class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                      <i class="ph-fill ph-calendar mr-1"></i>
                      {{ $application->created_at->format('M d, Y') }}
                    </span>
                    <span class="px-2 sm:px-3 py-1 
              {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
              {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
              {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
              {{ $application->status === 'adoption on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
              {{ $application->status === 'picked up' ? 'bg-green-100 text-green-700' : '' }}
              {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
              rounded-full text-xs sm:text-sm font-medium whitespace-nowrap">
                      @switch($application->status)
                      @case('to be confirmed')
                      <i class="ph-fill ph-clock mr-1"></i>Waiting Confirmation
                      @break
                      @case('confirmed')
                      <i class="ph-fill ph-check-circle mr-1"></i>Confirmed
                      @break
                      @case('to be scheduled')
                      <i class="ph-fill ph-calendar mr-1"></i>To Be Scheduled
                      @break
                      @case('adoption on-going')
                      <i class="ph-fill ph-hourglass mr-1"></i>On-going
                      @break
                      @case('picked up')
                      <i class="ph-fill ph-check-square mr-1"></i>Adopted
                      @break
                      @case('rejected')
                      <i class="ph-fill ph-x-circle mr-1"></i>Rejected
                      @break
                      @endswitch
                    </span>
                  </div>
                  <div
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                    <span class="flex items-center min-w-0">
                      <i class="ph-fill ph-user mr-1 flex-shrink-0"></i>
                      <span class="truncate">{{ $application->full_name }}</span>
                    </span>
                    <span class="flex items-center min-w-0">
                      <i class="ph-fill ph-envelope mr-1 flex-shrink-0"></i>
                      <span class="truncate">{{ $application->email }}</span>
                    </span>
                    <span class="flex items-center whitespace-nowrap">
                      <i class="ph-fill ph-phone mr-1 flex-shrink-0"></i>
                      {{ $application->contact_number }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Toggle Button -->
              <button onclick="toggleApplicationDetails('{{ $application->id }}')"
                class="w-full bg-white hover:bg-gray-50 border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-left transition-colors flex items-center justify-between group">
                <span
                  class="font-medium text-sm sm:text-base text-gray-700 group-hover:text-gray-900 flex items-center gap-2 min-w-0 flex-1">
                  <i id="app-icon-{{ $application->id }}"
                    class="ph-fill ph-caret-right text-gray-400 group-hover:text-blue-600 transition-transform duration-200 flex-shrink-0"></i>
                  <span class="truncate">View Application Details</span>
                </span>
                <span class="text-xs sm:text-sm text-gray-500 ml-2 flex-shrink-0 whitespace-nowrap">
                  {{ $application->created_at->diffForHumans() }}
                </span>
              </button>
            </div>
          </div>
        </div>

        <!-- Application Details (Hidden by default) -->
        <div id="app-details-{{ $application->id }}" class="hidden divide-y divide-gray-200">
          <div class="p-6 bg-gray-50">
            <!-- Pet Information -->
            <div class="mb-6">
              <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-paw-print mr-2"></i>Pet Information
              </h3>
              <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-600">Pet Number</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->pet->pet_number }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Species</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->pet->species === 'feline' ? 'Cat' : 'Dog' }}
                  </p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Age</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->pet->formatted_age }} {{ $application->pet->age
                    == 1 ? Str::singular($application->pet->age_unit) : Str::plural($application->pet->age_unit) }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Sex</label>
                  <p class="mt-1 text-sm text-gray-900">{{ ucfirst($application->pet->sex) }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Color</label>
                  <p class="mt-1 text-sm text-gray-900">{{ ucfirst($application->pet->color) }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Reproductive Status</label>
                  <p class="mt-1 text-sm text-gray-900">{{ ucfirst($application->pet->reproductive_status) }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Source</label>
                  <p class="mt-1 text-sm text-gray-900">{{ ucfirst($application->pet->source) }}</p>
                </div>
              </div>
            </div>

            <!-- Applicant Information -->
            <div class="mb-6">
              <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-user-circle mr-2"></i>Applicant Information
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-600">Age</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->age }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Birthdate</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->birthdate ?
                    \Carbon\Carbon::parse($application->birthdate)->format('M d, Y') : 'Not set' }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Address</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->address }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Civil Status</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->civil_status }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Citizenship</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->citizenship }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Visits Veterinarian</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->visit_veterinarian }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Existing Pets</label>
                  <p class="mt-1 text-sm text-gray-900">{{ $application->existing_pets }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Valid ID</label>
                  <div class="mt-1">
                    <a href="{{ asset('storage/' . $application->valid_id) }}" target="_blank"
                      class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-blue-600 hover:bg-blue-50 transition">
                      <i class="ph-fill ph-image mr-2"></i>View ID
                    </a>
                  </div>
                </div>
              </div>
              <div class="mt-4">
                <label class="text-sm font-medium text-gray-600">Reason for Adoption</label>
                <p class="mt-2 text-sm text-gray-900 whitespace-pre-line">{{ $application->reason_for_adoption }}</p>
              </div>
            </div>

            @if($application->pickup_date)
            <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
              <label class="text-sm font-medium text-indigo-800 block mb-2">
                <i class="ph-fill ph-calendar-check mr-1"></i>Scheduled Visitation Date
              </label>
              <p class="text-sm text-indigo-700">{{ \Carbon\Carbon::parse($application->pickup_date)->format('M d, Y')
                }}</p>
              <p class="text-xs text-indigo-600 mt-1">Please make sure to visit our office on the scheduled date for visitation.</p>
            </div>
            @endif

            @if($application->status === 'rejected' && $application->reject_reason)
            <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
              <label class="text-sm font-medium text-red-800 block mb-2">Rejection Reason</label>
              <p class="text-sm text-red-700">{{ $application->reject_reason }}</p>
            </div>
            @endif
          </div>

          <!-- Action Buttons -->
          <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
            @if($application->status === 'to be confirmed')
            <form method="POST" action="{{ url('/transactions/' . $application->id . '/resend-email') }}">
              @csrf
              <button type="submit"
                class="px-4 py-2 border border-orange-300 text-orange-600 rounded-lg hover:bg-orange-50 transition">
                <i class="ph-fill ph-envelope-simple-open mr-2"></i>Resend Confirmation
              </button>
            </form>
            @endif

            @if($application->status === 'to be scheduled')
            <button type="button" onclick="openScheduleModal('{{ $application->id }}')"
              class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
              <i class="ph-fill ph-calendar mr-2"></i>Schedule a Visit
            </button>
            @endif

            @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled']))
            <button type="button" onclick="openCancelModal('{{ $application->id }}')"
              class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition">
              <i class="ph-fill ph-x-circle mr-2"></i>Cancel Application
            </button>
            @endif

            @if($application->status === 'picked up')
            <div class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
              <i class="ph-fill ph-check-circle mr-2"></i>Adoption Completed
            </div>
            @endif
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

  <!-- Cancel Confirmation Modal -->
  <div id="cancelModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeCancelModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Cancel Application</h2>
      <p class="text-gray-700 mb-6">Are you sure you want to cancel this adoption application? This action will remove
        your application from our records.</p>
      <div class="flex justify-end gap-3">
        <button id="cancelCancelBtn"
          class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <form id="cancelForm" method="POST" action="" class="inline-block">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            Confirm Cancel
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Schedule Pickup Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeScheduleModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Schedule a Visit</h2>
      <p class="text-sm text-gray-600 mb-4">Please select a weekday (Monday-Friday) within the next 7 business days.</p>
      <form id="scheduleForm" method="POST" action="{{ url('/transactions/schedule-pickup') }}">
        @csrf
        <input type="hidden" name="application_id" id="scheduleAppId">
        <div class="mb-4">
          <label class="text-sm font-medium text-gray-600 block mb-2">Visit on <span
              class="text-red-600">*</span></label>
          <input type="date" name="pickup_date" id="pickupDateInput"
            class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
            required min="" max="">
        </div>
        <div class="flex justify-end gap-3">
          <button type="button" id="cancelScheduleBtn"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
            <i class="ph-fill ph-calendar mr-2"></i>Submit
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function toggleApplicationDetails(id) {
      const details = document.getElementById('app-details-' + id);
      const icon = document.getElementById('app-icon-' + id);

      if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        icon.classList.remove('ph-caret-right');
        icon.classList.add('ph-caret-down');
      } else {
        details.classList.add('hidden');
        icon.classList.remove('ph-caret-down');
        icon.classList.add('ph-caret-right');
      }
    }

    function openCancelModal(appId) {
      document.getElementById('cancelForm').action = `/transactions/adoption-status/${appId}`;
      document.getElementById('cancelModal').classList.remove('hidden');
    }

    function openScheduleModal(appId) {
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

      document.getElementById('scheduleModal').classList.remove('hidden');
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

    // Close modals
    document.getElementById('closeCancelModal').addEventListener('click', () => {
      document.getElementById('cancelModal').classList.add('hidden');
    });

    document.getElementById('cancelCancelBtn').addEventListener('click', () => {
      document.getElementById('cancelModal').classList.add('hidden');
    });

    document.getElementById('closeScheduleModal').addEventListener('click', () => {
      document.getElementById('scheduleModal').classList.add('hidden');
    });

    document.getElementById('cancelScheduleBtn').addEventListener('click', () => {
      document.getElementById('scheduleModal').classList.add('hidden');
    });

    // Close modals with Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.getElementById('cancelModal').classList.add('hidden');
        document.getElementById('scheduleModal').classList.add('hidden');
      }
    });

    // Close when clicking outside
    document.getElementById('cancelModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.classList.add('hidden');
      }
    });

    document.getElementById('scheduleModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.classList.add('hidden');
      }
    });
  </script>
</x-transactions-layout>
