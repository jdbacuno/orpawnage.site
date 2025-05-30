<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Missing Pet Reports</h1>

  <!-- Filters Section -->
  <div class="flex flex-wrap gap-2 my-4">
    <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4">
      <!-- Status Filter -->
      <select name="status"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[180px]"
        onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
        <option value="acknowledged" {{ request('status')==='acknowledged' ? 'selected' : '' }}>Acknowledged</option>
        <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Rejected</option>
      </select>

      <!-- Sort Direction -->
      <select name="direction"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
        onchange="this.form.submit()">
        <option value="desc" {{ request('direction', 'desc' )==='desc' ? 'selected' : '' }}>Newest First</option>
        <option value="asc" {{ request('direction')==='asc' ? 'selected' : '' }}>Oldest First</option>
      </select>
    </form>
  </div>

  @if($reports->isEmpty())
  <div class="flex items-center justify-center p-6 text-gray-500">
    <p class="text-lg">No reports found.</p>
  </div>
  @else
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mt-4">
    @foreach($reports as $report)
    <div
      class="bg-white rounded-lg shadow-md border border-gray-200 overflow-auto scrollbar-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
      <!-- Card Header -->
      <div class="p-3 border-b border-gray-200 flex items-start justify-between">
        <div class="flex items-center space-x-1">
          <div>
            <!-- Valid ID Photo -->
            <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-md overflow-hidden border border-gray-300">
              @if($report->valid_id_path)
              <button type="button" class="show-image-btn w-full h-full" data-image-title="Valid ID"
                data-image="{{ asset('storage/' . $report->valid_id_path) }}">
                <img src="{{ asset('storage/' . $report->valid_id_path) }}" alt="Reporter's ID"
                  class="w-full h-full object-cover">
              </button>
              @else
              <div class="w-full h-full flex items-center justify-center bg-gray-100">
                <i class="ph-fill ph-user text-xl text-gray-400"></i>
              </div>
              @endif
            </div>
          </div>

          <div>
            <h3 class="text-sm font-semibold flex items-center truncate">
              <i class="ph-fill ph-tag mr-1 text-sm"></i> {{ $report->report_number }}
            </h3>
            <p class="text-sm text-gray-500 truncate max-w-[120px]">
              {{ $report->owner_name }}
            </p>
          </div>
        </div>
      </div>

      <!-- Card Body -->
      <div class="p-3 flex-1">
        <!-- Basic Info -->
        <div class="grid grid-cols-2 gap-2 text-sm mb-2">
          <div>
            <p class="text-gray-500 font-medium">Pet Name</p>
            <p>{{ $report->pet_name }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Last Seen</p>
            <p>{{ \Carbon\Carbon::parse($report->last_seen_date)->format('M d, Y') }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Contact</p>
            <p>{{ $report->contact_no ?: 'Not provided' }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Last Seen Location</p>
            <p data-title="Last Seen Location" onclick="showTextModal(this, `{{ $report->last_seen_location }}`)"
              class="truncate cursor-pointer transition-color duration-100 ease-in hover:text-blue-500">
              {{ Str::limit($report->last_seen_location, 20) }}
            </p>
          </div>
        </div>

        <!-- Collapsible Sections -->
        <div class="space-y-2">
          <!-- Pet Description -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-note-pencil mr-2 text-sm"></i>
                Additional Info
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden text-sm text-gray-700 mt-1 px-1">
              @if($report->pet_description)
              {{ Str::limit($report->pet_description, 20) }}
              @if(strlen($report->pet_description) > 20)
              <button data-title="Additional Info"
                onclick="showTextModal(this, {{ json_encode($report->pet_description) }})"
                class="text-blue-500 hover:text-blue-700 text-xs ml-1">
                Read More
              </button>
              @endif
              @else
              No notes provided
              @endif
            </div>
          </div>

          <!-- Pet Photos -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-images mr-2 text-sm"></i>
                Pet Photos ({{ count(json_decode($report->pet_photos)) }})
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden mt-2">
              <div class="flex flex-wrap gap-1">
                @foreach(json_decode($report->pet_photos) as $photo)
                <button type="button" class="show-image-btn" data-image-title="Pet Photo"
                  data-image="{{ asset('storage/' . $photo) }}">
                  <img src="{{ asset('storage/' . $photo) }}" alt="Pet photo"
                    class="w-12 h-12 object-cover rounded border border-gray-300 hover:border-blue-500">
                </button>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Location Photos -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-map-pin mr-2 text-sm"></i>
                Location Photos ({{ count(json_decode($report->location_photos ?? '[]')) }})
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden mt-2">
              <div class="flex flex-wrap gap-1">
                @if($report->location_photos)
                @foreach(json_decode($report->location_photos) as $photo)
                <button type="button" class="show-image-btn" data-image-title="Location Photo"
                  data-image="{{ asset('storage/' . $photo) }}">
                  <img src="{{ asset('storage/' . $photo) }}" alt="Location photo"
                    class="w-12 h-12 object-cover rounded border border-gray-300 hover:border-blue-500">
                </button>
                @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Footer -->
      <div class="px-4 py-2 border-t border-gray-200 bg-gray-50 rounded-b-lg">
        <div class="flex justify-end items-center text-xs text-gray-500">
          <div class="relative inline-block text-left">
            <div>
              <button type="button"
                class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                id="options-menu-{{ $report->id }}" aria-expanded="true" aria-haspopup="true"
                onclick="toggleDropdown('{{ $report->id }}')">
                <span class="mr-2">Actions</span>
                <span class="px-2 py-1 text-xs rounded 
                  {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                  {{ $report->status === 'acknowledged' ? 'bg-green-100 text-green-700' : '' }}
                  {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                  @switch($report->status)
                  @case('pending') Pending @break
                  @case('acknowledged') Acknowledged @break
                  @case('rejected') Rejected @break
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
              id="dropdown-{{ $report->id }}">
              <div class="py-1" role="menu" aria-orientation="vertical"
                aria-labelledby="options-menu-{{ $report->id }}">
                @if($report->status === 'pending')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900"
                  role="menuitem" onclick="showAcknowledgeModal('{{ $report->id }}')">
                  <i class="ph-fill ph-check-circle mr-2"></i> Acknowledge
                </button>
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                  role="menuitem" onclick="showRejectModal('{{ $report->id }}')">
                  <i class="ph-fill ph-x-circle mr-2"></i> Reject Report
                </button>
                @elseif($report->status === 'acknowledged' || $report->status === 'rejected')
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                  role="menuitem" onclick="showArchiveModal('{{ $report->id }}')">
                  <i class="ph-fill ph-archive mr-2"></i> Archive
                </button>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  <!-- Pagination -->
  <div class="mt-6">
    {{ $reports->appends(request()->except('page'))->links() }}
  </div>

  <!-- Image Modal -->
  <div id="imageModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-h-[90vh] overflow-auto">
      <button id="closeImageModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800" id="imageModalTitle"></h2>
      <div class="w-full mt-2 flex justify-center items-center">
        <img id="modalImage" alt="" class="max-h-[70vh] max-w-full object-contain rounded-lg shadow-md">
      </div>
    </div>
  </div>

  <!-- Acknowledge Confirmation Modal -->
  <div id="acknowledgeModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeAcknowledgeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Acknowledge Report</h2>
      <p id="confirmationMessage" class="text-gray-700 mb-6">This will notify all registered users about this missing
        pet.</p>
      <div class="flex justify-end gap-3">
        <button id="cancelAcknowledge"
          class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
        <form id="actionForm" method="POST" action="{{ route('admin.missing-reports.acknowledge') }}"
          class="inline-block">
          @csrf
          @method('PATCH')
          <input type="hidden" name="report_id" id="acknowledgeReportId">
          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Notify
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Reject Confirmation Modal -->
  <div id="rejectModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeRejectModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Reject Report</h2>
      <p class="mb-2">Please provide a reason for rejecting this report:</p>
      <p class="my-2 text-red-500 text-sm">This will send an email notification to the reporter.</p>
      <form id="actionForm" method="POST" action="{{ route('admin.missing-reports.reject') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="report_id" id="rejectReportId">
        <label for="rejectReason" class="block font-medium text-gray-700">Reason:</label>
        <textarea id="rejectReason" name="reject_reason" class="w-full border p-2 rounded-md mb-4" required></textarea>
        <x-form-error name="reject_reason" />
        <div class="flex justify-end gap-3">
          <button type="button" id="cancelReject"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            Reject Report
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Location Modal -->
  <div id="textModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-lg w-full max-h-[90vh] overflow-auto">
      <button onclick="closeTextModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800" id="textTitle">Last Seen Location</h2>
      <div class="w-full mt-2 text-gray-700 whitespace-pre-wrap break-words" id="textModalContent"></div>
    </div>
  </div>

  <!-- Archive Confirmation Modal -->
  <div id="archiveModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeArchiveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 flex items-center"><i class="ph-fill ph-archive mr-2"></i>Confirm
        Archive</h2>
      <p class="mb-4">Are you sure you want to archive this missing pet report?</p>
      <p class="mb-4 text-gray-500 text-sm">Archived reports will be moved to a separate section and won't appear in the
        main list.</p>

      <form id="archiveForm" method="POST" action="{{ route('admin.missing-reports.archive') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="report_id" id="archiveReportId">

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

  <script>
    // location modal
    function showTextModal(el, text) {
      document.getElementById('textTitle').textContent = el.dataset.title;
      document.getElementById('textModalContent').textContent = text;
      document.getElementById('textModal').classList.remove('hidden');
    }

    function closeTextModal() {
      document.getElementById('textModal').classList.add('hidden');
    }

    // Toggle collapsible sections
    document.querySelectorAll('.toggle-section-btn').forEach(button => {
      button.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const icon = this.querySelector('.ph-caret-down');
        
        content.classList.toggle('hidden');
        icon.classList.toggle('ph-caret-down');
        icon.classList.toggle('ph-caret-up');
        
        // Close other open sections in this card
        const card = this.closest('.bg-white');
        card.querySelectorAll('.toggle-section-btn').forEach(otherBtn => {
          if (otherBtn !== this) {
            otherBtn.nextElementSibling.classList.add('hidden');
            otherBtn.querySelector('.ph-caret-down').classList.remove('ph-caret-up');
            otherBtn.querySelector('.ph-caret-down').classList.add('ph-caret-down');
          }
        });
      });
    });

    // Image modal
    document.querySelectorAll('.show-image-btn').forEach(button => {
      button.addEventListener('click', function() {
        document.getElementById('imageModalTitle').textContent = this.dataset.imageTitle;
        document.getElementById('modalImage').src = this.dataset.image;
        document.getElementById('modalImage').alt = this.dataset.imageTitle;
        document.getElementById('imageModal').classList.remove('hidden');
      });
    });

    document.getElementById('closeImageModal').addEventListener('click', function() {
      document.getElementById('imageModal').classList.add('hidden');
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

    // Show acknowledge modal
    function showAcknowledgeModal(id) {
      document.getElementById('acknowledgeReportId').value = id;
      document.getElementById('acknowledgeModal').classList.remove('hidden');
    }

    document.getElementById('closeAcknowledgeModal').addEventListener('click', function() {
      document.getElementById('acknowledgeModal').classList.add('hidden');
    });

    document.getElementById('cancelAcknowledge').addEventListener('click', function() {
      document.getElementById('acknowledgeModal').classList.add('hidden');
    });

    // Show reject modal
    function showRejectModal(id) {
      document.getElementById('rejectReportId').value = id;
      document.getElementById('rejectModal').classList.remove('hidden');
    }

    document.getElementById('closeRejectModal').addEventListener('click', function() {
      document.getElementById('rejectModal').classList.add('hidden');
    });

    document.getElementById('cancelReject').addEventListener('click', function() {
      document.getElementById('rejectModal').classList.add('hidden');
    });

    // Show archive modal
    function showArchiveModal(id) {
        document.getElementById('archiveReportId').value = id;
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
  </script>
</x-admin-layout>