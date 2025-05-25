<x-transactions-layout>
  <h1 class="text-lg sm:text-2xl font-bold text-gray-900 mt-0 sm:mt-10">Abused/Stray Reports</h1>

  <!-- Filters Section -->
  <div class="flex flex-wrap gap-2 my-4">
    <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4">
      <!-- Status Filter -->
      <select name="status"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[180px]"
        onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
        <option value="action taken" {{ request('status')==='action taken' ? 'selected' : '' }}>Action Taken</option>
        <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </form>
  </div>

  @if ($abusedReports->isEmpty())
  <div class="flex items-center justify-center p-6 text-gray-500">
    <p class="text-lg">No abused/stray reports found.</p>
  </div>
  @else
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
    @foreach($abusedReports as $report)
    <div
      class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
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
            <h3 class="text-sm font-semibold flex items-center">
              <i class="ph-fill ph-tag mr-1 text-sm"></i> {{ $report->report_number }}
            </h3>
            <p class="text-sm text-gray-500 truncate max-w-[120px]">
              {{ $report->full_name ?: 'Anonymous' }}
            </p>
          </div>
        </div>

        @php
        $displayStatus = $report->status === 'archived' ? $report->previous_status : $report->status;

        $statusClasses = match ($displayStatus) {
        'pending' => 'bg-yellow-100 text-yellow-700',
        'action taken' => 'bg-green-100 text-green-700',
        'rejected' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
        };
        @endphp

        <!-- Status Badge -->
        <div class="text-right space-y-1">
          <span class="px-2 py-1 text-[10px] rounded {{ $statusClasses }}">
            {{ ucwords($displayStatus) }}
          </span>
          <span class="flex justify-end items-center text-[10px] text-gray-500">
            <i class="ph-fill ph-clock mr-1"></i> {{ $report->created_at->diffForHumans() }}
          </span>
        </div>
      </div>

      <!-- Card Body -->
      <div class="p-3 flex-1">
        <!-- Basic Info -->
        <div class="grid grid-cols-2 gap-2 text-sm mb-2">
          <div>
            <p class="text-gray-500 font-medium">Animal</p>
            <p>{{ ucfirst($report->species) }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">What</p>
            <p>{{ ucfirst($report->animal_condition) }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">When</p>
            <p>{{ \Carbon\Carbon::parse($report->incident_date)->format('M j, Y') }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Where</p>
            <!-- Trigger Text -->
            <p data-title="Incident Location" onclick="showTextModal(this, `{{ $report->incident_location }}`)"
              class="truncate cursor-pointer transition-color duration-100 ease-in hover:text-blue-500">
              {{ Str::limit($report->incident_location, 20) }}
            </p>
          </div>
        </div>

        <!-- Collapsible Sections -->
        <div class="space-y-2">
          <!-- Notes -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-note-pencil mr-2 text-sm"></i>
                Notes
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden text-sm text-gray-700 mt-1 px-1">
              @if($report->additional_notes)
              {{ Str::limit($report->additional_notes, 10) }}
              @if(strlen($report->additional_notes) > 10)
              <button onclick="showTextModal(this, {{ json_encode($report->additional_notes) }})"
                class="text-blue-500 hover:text-blue-700 text-xs ml-1" data-title="Notes">
                Read More
              </button>
              @endif
              @else
              No notes provided
              @endif
            </div>
          </div>

          <!-- Photos -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-images mr-2 text-sm"></i>
                Photos ({{ count(json_decode($report->incident_photos)) }})
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden mt-2">
              <div class="flex flex-wrap gap-1">
                @foreach(json_decode($report->incident_photos) as $photo)
                <button type="button" class="show-image-btn" data-image-title="Incident Photo"
                  data-image="{{ asset('storage/' . $photo) }}">
                  <img src="{{ asset('storage/' . $photo) }}" alt="Evidence photo"
                    class="w-12 h-12 object-cover rounded border border-gray-300 hover:border-blue-500">
                </button>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Reporter Info -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-user-circle mr-2 text-sm"></i>
                Reporter Info
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden text-sm mt-1">
              <div class="space-y-1 px-1">
                <p><span class="text-gray-500">Name:</span> {{ $report->full_name ?: 'Anonymous' }}</p>
                <p><span class="text-gray-500">Contact:</span> {{ $report->contact_no ?: 'Not provided' }}</p>
                <p><span class="text-gray-500">Email:</span> {{ $report->user->email ?? 'Not provided' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Footer -->
      <div class="p-2 border-t border-gray-200 bg-gray-50 rounded-b-lg">
        <div class="flex justify-end items-center text-sm text-gray-500">
          <button type="button" class="delete-btn px-2 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600"
            data-report-id="{{ $report->id }}" data-report-number="{{ $report->report_number }}">
            <i class="ph-fill ph-trash"></i>
          </button>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $abusedReports->appends(request()->except('page'))->links() }}
  </div>
  @endif

  <!-- Image Modal -->
  <div id="imageModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-3xl w-full max-h-[90vh] overflow-auto">
      <button id="closeImageModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800" id="imageModalTitle"></h2>
      <div class="w-full mt-2 flex justify-center items-center">
        <img id="modalImage" alt="" class="max-h-[70vh] max-w-full object-contain rounded-lg shadow-md">
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-sm relative">
      <button id="closeDeleteModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="font-semibold text-gray-800 mb-3">Confirm Deletion</h2>
      <p id="deleteMessage" class="text-gray-700 mb-4">
        Delete report <span id="reportNumberToDelete" class="font-semibold"></span>?
      </p>
      <div class="flex justify-end gap-2">
        <button id="cancelDelete" class="px-3 py-1 bg-gray-300 text-gray-800 rounded">Cancel</button>
        <form id="deleteForm" method="POST" class="inline-block">
          @csrf
          @method('DELETE')
          <input type="hidden" name="report_id" id="deleteReportId">
          <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Incident Location Modal -->
  <div id="textModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-lg w-full max-h-[90vh] overflow-auto">
      <button onclick="closeTextModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800" id="textTitle">Incident Location</h2>
      <div class="w-full mt-2 text-gray-700 whitespace-pre-wrap break-words" id="textModalContent"></div>
    </div>
  </div>

  <script>
    // incident location
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

     document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function() {
        document.getElementById('deleteReportId').value = this.dataset.reportId;
        document.getElementById('reportNumberToDelete').textContent = this.dataset.reportNumber;
        document.getElementById('deleteForm').action = `/transactions/abused-status/${this.dataset.reportId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
      });
    });

    document.getElementById('closeDeleteModal').addEventListener('click', function() {
      document.getElementById('deleteModal').classList.add('hidden');
    });

    document.getElementById('cancelDelete').addEventListener('click', function() {
      document.getElementById('deleteModal').classList.add('hidden');
    });
  </script>
</x-transactions-layout>