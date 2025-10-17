<x-transactions-layout>
  <div class="max-w-[1600px] mx-auto">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">My Missing Pet Reports</h1>
      <p class="text-sm text-gray-600 mt-1">Track and manage your missing pet reports</p>
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
            All Reports
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-clock mr-2"></i>
            Pending
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-check-circle mr-2"></i>
            Approved
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-x-circle mr-2"></i>
            Rejected
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'found']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'found' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-check-square mr-2"></i>
            Found
          </a>
        </nav>
      </div>

      <!-- Search and Sort -->
      <div class="p-4 bg-gray-50 border-b border-gray-200">
        <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4 items-center">
          <div class="flex-1 min-w-[250px]">
            <div class="relative">
              <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by report number, pet name, or contact"
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

          <input type="hidden" name="status" value="{{ is_array(request('status')) ? '' : request('status') }}" />

          @if(request('search'))
          <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
            class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
            <i class="ph-fill ph-x mr-1"></i>Clear
          </a>
          @endif
        </form>
      </div>
    </div>

    @if($missingReports->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
      <i class="ph-fill ph-file-search text-6xl text-gray-300 mb-4"></i>
      <p class="text-lg text-gray-500">No missing pet reports found.</p>
    </div>
    @else
    <!-- Reports Grid -->
    <div class="space-y-6">
      @foreach($missingReports as $report)
      <div
        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
        <!-- Report Header -->
        <div
          class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
          <!-- Report Header -->
          <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
              <!-- Pet Image -->
              <a href="{{ asset('storage/' . json_decode($report->pet_photos)[0]) }}" target="_blank"
                class="flex-shrink-0 w-20 h-20 sm:w-32 sm:h-32 bg-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow group mx-auto sm:mx-0">
                @if($report->pet_photos)
                <img src="{{ asset('storage/' . json_decode($report->pet_photos)[0]) }}" alt="{{ $report->pet_name }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                  <i class="ph-fill ph-paw-print text-2xl sm:text-4xl text-gray-400"></i>
                </div>
                @endif
              </a>

              <div class="flex-1 min-w-0 w-full">
                <div class="flex flex-col gap-3 mb-4">
                  <div class="min-w-0">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                      {{ $report->report_number }}
                    </h2>

                    <div class="flex flex-wrap gap-2 mb-3">
                      <span
                        class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 inline-flex items-center">
                        <i class="ph-fill ph-paw-print mr-1 flex-shrink-0"></i>
                        <span class="truncate max-w-[120px] sm:max-w-none">{{ ucfirst($report->pet_name) }}</span>
                      </span>
                      <span
                        class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                        <i class="ph-fill ph-calendar mr-1"></i>
                        {{ $report->last_seen_date->format('M d, Y') }}
                      </span>
                      <span class="px-2 sm:px-3 py-1
                {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $report->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                {{ $report->status === 'found' ? 'bg-blue-100 text-blue-700' : '' }}
                rounded-full text-xs sm:text-sm font-medium whitespace-nowrap">
                        @switch($report->status)
                        @case('pending')
                        <i class="ph-fill ph-clock mr-1"></i>Pending Review
                        @break
                        @case('approved')
                        <i class="ph-fill ph-check-circle mr-1"></i>Approved
                        @break
                        @case('rejected')
                        <i class="ph-fill ph-x-circle mr-1"></i>Rejected
                        @break
                        @case('found')
                        <i class="ph-fill ph-check-square mr-1"></i>Found
                        @break
                        @endswitch
                      </span>
                    </div>

                    <div
                      class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                      <span class="flex items-center min-w-0">
                        <i class="ph-fill ph-user mr-1 flex-shrink-0"></i>
                        <span class="truncate">{{ ucwords(strtolower($report->owner_name)) }}</span>
                      </span>
                      <span class="flex items-center whitespace-nowrap">
                        <i class="ph-fill ph-phone mr-1 flex-shrink-0"></i>
                        {{ $report->contact_no }}
                      </span>
                      <span class="flex items-center min-w-0">
                        <i class="ph-fill ph-map-pin mr-1 flex-shrink-0"></i>
                        <span class="truncate">{{ $report->last_seen_location }}</span>
                      </span>
                      <span class="flex items-center whitespace-nowrap">
                        <i class="ph-fill ph-calendar-blank mr-1 flex-shrink-0"></i>
                        Last Seen: {{ $report->last_seen_date->format('M d, Y') }}
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Toggle Button -->
                <button onclick="toggleReportDetails('{{ $report->id }}')"
                  class="w-full bg-white hover:bg-gray-50 border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-left transition-colors flex items-center justify-between group">
                  <span
                    class="font-medium text-sm sm:text-base text-gray-700 group-hover:text-gray-900 flex items-center gap-2 min-w-0 flex-1">
                    <i id="report-icon-{{ $report->id }}"
                      class="ph-fill ph-caret-right text-gray-400 group-hover:text-blue-600 transition-transform duration-200 flex-shrink-0"></i>
                    <span class="truncate">View Full Report Details</span>
                  </span>
                  <span class="text-xs sm:text-sm text-gray-500 ml-2 flex-shrink-0 whitespace-nowrap">
                    {{ $report->created_at->diffForHumans() }}
                  </span>
                </button>
              </div>
            </div>
          </div>

          <!-- Report Details (Hidden by default) -->
          <div id="report-details-{{ $report->id }}" class="hidden divide-y divide-gray-200">
            <div class="p-4 sm:p-6 bg-gray-50">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                <div>
                  <label class="text-xs sm:text-sm font-medium text-gray-600">Message/Description</label>
                  <p class="mt-2 text-sm text-gray-900 whitespace-pre-line break-words">{{ $report->pet_description }}
                  </p>
                </div>
                <div>
                  <label class="text-xs sm:text-sm font-medium text-gray-600">Valid ID</label>
                  <div class="mt-2">
                    <a href="{{ asset('storage/' . $report->valid_id_path) }}" target="_blank"
                      class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-xs sm:text-sm text-blue-600 hover:bg-blue-50 transition">
                      <i class="ph-fill ph-image mr-2 flex-shrink-0"></i>
                      View Valid ID
                    </a>
                  </div>
                </div>
              </div>

              @if($report->pet_photos)
              <div class="mb-4 sm:mb-6">
                <label class="text-xs sm:text-sm font-medium text-gray-600 block mb-2">Pet Photos</label>
                <div class="flex flex-wrap gap-2">
                  @foreach(json_decode($report->pet_photos) as $index => $photo)
                  <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden border border-gray-300 hover:border-blue-500 transition">
                    <img src="{{ asset('storage/' . $photo) }}" alt="Pet photo {{ $index + 1 }}"
                      class="w-full h-full object-cover">
                  </a>
                  @endforeach
                </div>
              </div>
              @endif

              @if($report->location_photos)
              <div class="mb-4 sm:mb-6">
                <label class="text-xs sm:text-sm font-medium text-gray-600 block mb-2">Location Photos</label>
                <div class="flex flex-wrap gap-2">
                  @foreach(json_decode($report->location_photos) as $index => $photo)
                  <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden border border-gray-300 hover:border-blue-500 transition">
                    <img src="{{ asset('storage/' . $photo) }}" alt="Location photo {{ $index + 1 }}"
                      class="w-full h-full object-cover">
                  </a>
                  @endforeach
                </div>
              </div>
              @endif

              @if($report->status === 'rejected' && $report->reject_reason)
              <div class="p-3 sm:p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start gap-2">
                  <i class="ph-fill ph-warning text-red-600 mt-0.5 flex-shrink-0"></i>
                  <div class="min-w-0">
                    <label class="text-xs sm:text-sm font-medium text-red-800 block mb-1">Rejection Reason</label>
                    <p class="text-xs sm:text-sm text-red-700 break-words">{{ $report->reject_reason }}</p>
                  </div>
                </div>
              </div>
              @endif
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 flex flex-wrap justify-end gap-2 sm:gap-3">
              @if($report->status === 'approved')
              @php
              $lastReposted = $report->last_reposted_at ?? $report->created_at;
              $daysSince = now()->diffInDays($lastReposted);
              $daysRemaining = max(0, 5 - (int)$daysSince); // Cast to integer and ensure non-negative
              $canRepost = $daysSince >= 5;
              @endphp
              <form method="POST" action="{{ route('missing.mark-found') }}" class="flex-1 sm:flex-none">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">
                <button type="button" onclick="showFoundModal('{{ $report->id }}', '{{ $report->report_number }}')"
                  class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-blue-600 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-700 transition whitespace-nowrap flex items-center justify-center gap-1">
                  <i class="ph-fill ph-check-square flex-shrink-0"></i>
                  <span class="hidden sm:inline">Mark as Found</span>
                  <span class="sm:hidden">Found</span>
                </button>
              </form>
              <form method="POST" action="{{ route('missing.repost') }}" class="flex-1 sm:flex-none">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">
                <button type="submit" {{ !$canRepost ? 'disabled' : '' }}
                  class="w-full sm:w-auto px-3 sm:px-4 py-2 text-xs sm:text-sm {{ $canRepost ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 cursor-not-allowed' }} text-white rounded-lg transition whitespace-nowrap flex items-center justify-center gap-1"
                  title="{{ !$canRepost ? 'Available in ' . $daysRemaining . ' day(s)' : 'Repost to top' }}">
                  <i class="ph-fill ph-arrow-clockwise flex-shrink-0"></i>
                  <span class="hidden sm:inline">Repost {{ !$canRepost ? '(' . $daysRemaining . 'd)' : '' }}</span>
                  <span class="sm:hidden">Repost</span>
                </button>
              </form>
              @endif
              <button type="button" onclick="showDeleteModal('{{ $report->id }}', '{{ $report->report_number }}')"
                class="flex-1 sm:flex-none px-3 sm:px-4 py-2 border border-red-300 text-red-600 text-xs sm:text-sm rounded-lg hover:bg-red-50 transition whitespace-nowrap flex items-center justify-center gap-1">
                <i class="ph-fill ph-trash flex-shrink-0"></i>
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $missingReports->appends(request()->except('page'))->links() }}
    </div>
    @endif
  </div>

  <!-- Mark as Found Modal -->
  <div id="foundModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeFoundModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Mark Pet as Found</h2>
      <p id="foundMessage" class="text-gray-700 mb-6"></p>
      <p class="text-sm text-gray-600 mb-4">Congratulations! This will update your report status to "Found".</p>
      <div class="flex justify-end gap-3">
        <button id="cancelFound" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <form id="foundForm" method="POST" action="{{ route('missing.mark-found') }}" class="inline-block">
          @csrf
          <input type="hidden" name="report_id" id="foundReportId">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            <i class="ph-fill ph-check-square mr-2"></i>Confirm Found
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeDeleteModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Delete Report</h2>
      <p id="deleteMessage" class="text-gray-700 mb-6">Are you sure you want to delete report <span
          id="reportNumberToDelete" class="font-semibold"></span>? This action will remove your report from our records.
      </p>
      <div class="flex justify-end gap-3">
        <button id="cancelDelete" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <form id="deleteForm" method="POST" action="" class="inline-block">
          @csrf
          @method('DELETE')
          <input type="hidden" name="report_id" id="deleteReportId">
          <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleReportDetails(id) {
      const details = document.getElementById('report-details-' + id);
      const icon = document.getElementById('report-icon-' + id);

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

    function showFoundModal(id, reportNumber) {
      document.getElementById('foundReportId').value = id;
      document.getElementById('foundMessage').textContent = `Mark report ${reportNumber} as found?`;
      document.getElementById('foundModal').classList.remove('hidden');
    }

    function showDeleteModal(reportId, reportNumber) {
      document.getElementById('deleteReportId').value = reportId;
      document.getElementById('reportNumberToDelete').textContent = reportNumber;
      document.getElementById('deleteForm').action = `/transactions/missing-status/${reportId}`;
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    document.getElementById('closeFoundModal').addEventListener('click', () => {
      document.getElementById('foundModal').classList.add('hidden');
    });

    document.getElementById('cancelFound').addEventListener('click', () => {
      document.getElementById('foundModal').classList.add('hidden');
    });

    document.getElementById('closeDeleteModal').addEventListener('click', () => {
      document.getElementById('deleteModal').classList.add('hidden');
    });

    document.getElementById('cancelDelete').addEventListener('click', () => {
      document.getElementById('deleteModal').classList.add('hidden');
    });

    // Close modals with Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.getElementById('foundModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.add('hidden');
      }
    });

    // Close when clicking outside
    document.getElementById('foundModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.classList.add('hidden');
      }
    });

    document.getElementById('deleteModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
        e.currentTarget.classList.add('hidden');
      }
    });
  </script>
</x-transactions-layout>
