<x-admin-layout>
  <div class="max-w-[1600px] mx-auto">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Manage Surrender Applications</h1>
      <p class="text-sm text-gray-600 mt-1">Review and process pet surrender applications</p>
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
          <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'completed' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-check-square mr-2"></i>
            Completed
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

    @if($surrenderApplications->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
      <i class="ph-fill ph-file-search text-6xl text-gray-300 mb-4"></i>
      <p class="text-lg text-gray-500">No surrender applications found.</p>
    </div>
    @else

    <!-- Applications Grid -->
    <div class="space-y-6">
      @foreach($surrenderApplications as $application)
      <div
        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
        <!-- Application Header -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 p-4 sm:p-6">
          <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
            <!-- Pet Image -->
            <a href="{{ asset('storage/' . json_decode($application->animal_photos)[0]) }}" target="_blank"
              class="flex-shrink-0 w-20 h-20 sm:w-32 sm:h-32 bg-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow group mx-auto sm:mx-0">
              @if($application->animal_photos)
              <img src="{{ asset('storage/' . json_decode($application->animal_photos)[0]) }}"
                alt="{{ $application->pet_name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
              @else
              <div class="w-full h-full flex items-center justify-center bg-gray-100">
                <i class="ph-fill ph-paw-print text-2xl sm:text-4xl text-gray-400"></i>
              </div>
              @endif
            </a>

            <div class="flex-1 min-w-0 w-full">
              <div class="flex flex-col gap-4 mb-4">
                <div class="min-w-0 flex-1">
                  <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                    <a href="#" class="text-blue-500 hover:text-blue-600"
                      onclick="showApplicationDetails('{{ $application->id }}', event)">
                      {{ $application->transaction_number }}
                    </a>
                  </h2>
                  <div class="flex flex-wrap gap-2 mb-3">
                    <span
                      class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 inline-flex items-center">
                      <i class="ph-fill ph-paw-print mr-1 flex-shrink-0"></i>
                      <span class="truncate max-w-[120px] sm:max-w-none">{{ ucfirst($application->pet_name ??
                        'Unnamed') }}</span>
                    </span>
                    <span
                      class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                      <i class="ph-fill ph-gender-{{ strtolower($application->sex) }} mr-1"></i>
                      {{ ucfirst($application->sex) }}
                    </span>
                    <span class="px-2 sm:px-3 py-1
              {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
              {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
              {{ $application->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
              {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
              rounded-full text-xs sm:text-sm font-medium whitespace-nowrap">
                      @switch($application->status)
                      @case('to be confirmed')
                      <i class="ph-fill ph-clock mr-1"></i>Waiting Confirmation
                      @break
                      @case('confirmed')
                      <i class="ph-fill ph-check-circle mr-1"></i>Confirmed
                      @break
                      @case('completed')
                      <i class="ph-fill ph-check-square mr-1"></i>Completed
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
                      <span class="truncate">{{ ucwords(strtolower($application->full_name)) }}</span>
                    </span>
                    <span class="flex items-center whitespace-nowrap">
                      <i class="ph-fill ph-phone mr-1 flex-shrink-0"></i>
                      {{ $application->contact_number }}
                    </span>
                    <span class="flex items-center min-w-0">
                      <i class="ph-fill ph-at mr-1 flex-shrink-0"></i>
                      <span class="truncate">{{ $application->email }}</span>
                    </span>
                  </div>
                </div>
              </div>

              <!-- Toggle Button -->
              <button onclick="toggleApplicationDetails('{{ $application->id }}')"
                class="w-full bg-white hover:bg-gray-50 border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-left transition-colors flex items-center justify-between group">
                <span
                  class="font-medium text-sm sm:text-base text-gray-700 group-hover:text-gray-900 flex items-center gap-2 min-w-0 flex-1">
                  <i id="application-icon-{{ $application->id }}"
                    class="ph-fill ph-caret-right text-gray-400 group-hover:text-blue-600 transition-transform duration-200 flex-shrink-0"></i>
                  <span class="truncate">View Full Application Details</span>
                </span>
                <span class="text-xs sm:text-sm text-gray-500 ml-2 flex-shrink-0 whitespace-nowrap">
                  {{ $application->created_at->diffForHumans() }}
                </span>
              </button>
            </div>
          </div>
        </div>

        <!-- Application Details (Hidden by default) -->
        <div id="application-details-{{ $application->id }}" class="hidden divide-y divide-gray-200">
          <div class="p-6 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label class="text-sm font-medium text-gray-600">Pet Information</label>
                <div class="mt-2 space-y-2 text-sm">
                  <p><span class="font-medium">Species:</span> {{ ucfirst($application->species) }}</p>
                  <p><span class="font-medium">Breed:</span> {{ $application->breed ?? 'Unknown' }}</p>
                  <p><span class="font-medium">Sex:</span> {{ ucfirst($application->sex) }}</p>
                </div>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Owner Information</label>
                <div class="mt-2 space-y-2 text-sm">
                  <p><span class="font-medium">Age:</span> {{ $application->age }}</p>
                  <p><span class="font-medium">Civil Status:</span> {{ ucfirst($application->civil_status) }}</p>
                  <p><span class="font-medium">Address:</span> {{ $application->address }}</p>
                </div>
              </div>
            </div>

            <div class="mb-6">
              <label class="text-sm font-medium text-gray-600">Reason for Surrender</label>
              <p class="mt-2 text-gray-900 whitespace-pre-line">{{ $application->reason }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label class="text-sm font-medium text-gray-600">Valid ID</label>
                <div class="mt-2">
                  <a href="{{ asset('storage/' . $application->valid_id_path) }}" target="_blank"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm text-blue-600 hover:bg-blue-50 transition">
                    <i class="ph-fill ph-image mr-2"></i>
                    View Valid ID
                  </a>
                </div>
              </div>
            </div>

            @if($application->animal_photos)
            <div class="mb-6">
              <label class="text-sm font-medium text-gray-600 block mb-2">Animal Photos</label>
              <div class="flex flex-wrap gap-2">
                @foreach(json_decode($application->animal_photos) as $index => $photo)
                <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                  class="w-24 h-24 rounded-lg overflow-hidden border border-gray-300 hover:border-blue-500 transition">
                  <img src="{{ asset('storage/' . $photo) }}" alt="Animal photo {{ $index + 1 }}"
                    class="w-full h-full object-cover">
                </a>
                @endforeach
              </div>
            </div>
            @endif

            @if($application->status === 'confirmed')
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
              <div class="flex items-start gap-2">
                <i class="ph-fill ph-info text-blue-600 mt-0.5 flex-shrink-0"></i>
                <div>
                  <label class="text-sm font-medium text-blue-800 block mb-1">Next Steps</label>
                  <p class="text-sm text-blue-700">Contact the applicant to determine if they can bring the animal to the facility or if retrieval is needed. Once the surrender is complete, mark this application as completed.</p>
                </div>
              </div>
            </div>
            @endif

            @if($application->status === 'rejected' && $application->reject_reason)
            <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
              <label class="text-sm font-medium text-red-800 block mb-2">Rejection Reason</label>
              <p class="text-sm text-red-700">{{ $application->reject_reason }}</p>
            </div>
            @endif
          </div>

          <!-- Action Buttons -->
          <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
            @if($application->status === 'confirmed')
            <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
              onclick="showCompleteModal('{{ $application->id }}')">
              <i class="ph-fill ph-check-circle mr-2"></i>Mark as Completed
            </button>
            @endif

            @if(in_array($application->status, ['to be confirmed', 'confirmed']))
            <button type="button"
              class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition"
              onclick="showRejectModal('{{ $application->id }}')">
              <i class="ph-fill ph-x-circle mr-2"></i>Reject
            </button>
            @endif

            @if(in_array($application->status, ['completed', 'rejected']))
            <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition"
              onclick="showArchiveModal('{{ $application->id }}')">
              <i class="ph-fill ph-archive mr-2"></i>Archive
            </button>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $surrenderApplications->appends(request()->except('page'))->links() }}
    </div>
    @endif
  </div>

  <!-- Complete Modal -->
  <div id="completeModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeCompleteModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Mark as Completed</h2>
      <p class="text-gray-700 mb-6">Are you sure you want to mark this surrender as completed?</p>
      <div class="flex justify-end gap-3">
        <button id="cancelComplete"
          class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <form id="completeForm" method="POST" action="{{ route('surrender-applications.completed') }}"
          class="inline-block">
          @csrf
          @method('PATCH')
          <input type="hidden" name="application_id" id="completeApplicationId">
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            <i class="ph-fill ph-check-circle mr-2"></i>Confirm
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Reject Modal -->
  <div id="rejectModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeRejectModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Reject Application</h2>
      <p class="mb-2">Provide a reason for rejecting this application:</p>
      <p class="my-2 text-red-500 text-sm"><i class="ph-fill ph-warning mr-1"></i>An email will be sent to the
        applicant.</p>
      <form id="rejectForm" method="POST" action="{{ route('surrender-applications.reject') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="rejectApplicationId">
        <label for="rejectReason" class="block font-medium text-gray-700 mb-2">Reason <span
            class="text-red-600">*</span></label>
        <textarea id="rejectReason" name="reject_reason" rows="4" required maxlength="500"
          class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 mb-4"
          placeholder="Explain why this application is being rejected..."></textarea>
        <p class="text-xs text-gray-500 mb-4">Maximum 500 characters</p>
        <div class="flex justify-end gap-3">
          <button type="button" id="cancelReject"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
            Reject Application
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Archive Modal -->
  <div id="archiveModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeArchiveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="ph-fill ph-archive mr-2"></i>Confirm Archive
      </h2>
      <p class="mb-4">Are you sure you want to archive this application?</p>
      <p class="mb-4 text-gray-500 text-sm">Archived applications won't appear in the main list.</p>
      <form id="archiveForm" method="POST" action="{{ route('admin.surrender-applications.archive') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="archiveApplicationId">
        <div class="flex justify-end gap-3">
          <button type="button" id="cancelArchive"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
          <button type="submit"
            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 flex items-center">
            <i class="ph-fill ph-archive mr-2"></i>Archive
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function toggleApplicationDetails(id) {
      const details = document.getElementById('application-details-' + id);
      const icon = document.getElementById('application-icon-' + id);

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

    function showApplicationDetails(id, event) {
      event.preventDefault();
      toggleApplicationDetails(id);
    }

    function showCompleteModal(id) {
      document.getElementById('completeApplicationId').value = id;
      document.getElementById('completeModal').classList.remove('hidden');
    }

    function showRejectModal(id) {
      document.getElementById('rejectApplicationId').value = id;
      document.getElementById('rejectModal').classList.remove('hidden');
    }

    function showArchiveModal(id) {
      document.getElementById('archiveApplicationId').value = id;
      document.getElementById('archiveModal').classList.remove('hidden');
    }

    // Modal close handlers
    document.getElementById('closeCompleteModal').addEventListener('click', () => {
      document.getElementById('completeModal').classList.add('hidden');
    });

    document.getElementById('cancelComplete').addEventListener('click', () => {
      document.getElementById('completeModal').classList.add('hidden');
    });

    document.getElementById('closeRejectModal').addEventListener('click', () => {
      document.getElementById('rejectModal').classList.add('hidden');
    });

    document.getElementById('cancelReject').addEventListener('click', () => {
      document.getElementById('rejectModal').classList.add('hidden');
    });

    document.getElementById('closeArchiveModal').addEventListener('click', () => {
      document.getElementById('archiveModal').classList.add('hidden');
    });

    document.getElementById('cancelArchive').addEventListener('click', () => {
      document.getElementById('archiveModal').classList.add('hidden');
    });

    // Close modals with Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.getElementById('completeModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('archiveModal').classList.add('hidden');
      }
    });

    // Close when clicking outside
    document.getElementById('completeModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.classList.add('hidden');
      }
    });

    document.getElementById('rejectModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.classList.add('hidden');
      }
    });

    document.getElementById('archiveModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.classList.add('hidden');
      }
    });
  </script>
</x-admin-layout>
