<x-transactions-layout>
  <div class="mb-6">
    <div class="rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-[1px]">
      <div class="rounded-xl bg-white">
        <div class="px-5 py-5 sm:px-6 sm:py-6 flex flex-col gap-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                <i class="ph-fill ph-warning"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-900">Abused/Stray Reports</h1>
                <p class="text-sm text-gray-500">View and manage animal abuse/stray incidents</p>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap gap-2">
            <a href="/transactions/adoptions-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Adoptions</a>
            <a href="/transactions/surrender-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Surrenders</a>
            <a href="/transactions/missing-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Missing Pets</a>
            <a href="/transactions/abused-status"
              class="px-3 py-1.5 text-sm rounded-full bg-indigo-600 text-white shadow-sm">Abused/Stray</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters Section -->
  <div class="flex flex-wrap gap-4 my-4 bg-white rounded-lg p-4 shadow-sm border border-gray-200">
    <form method="GET" action="{{ request()->url() }}" class="relative flex items-center mt-2 sm:mt-0">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Report number/name, or contact"
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
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($abusedReports as $report)
    @php
    $displayStatus = $report->previous_status ?? $report->status;
    @endphp
    <div
      class="bg-white w-full rounded-xl shadow-sm overflow-hidden border border-gray-200 hover:shadow-md hover:-translate-y-[2px] transition-all duration-200">
      <!-- Report Info Header -->
      <div class="p-4 border-b border-gray-100">
        <div class="flex items-start space-x-2">
          <!-- Incident Photo (first photo or placeholder) -->
          <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden ring-1 ring-gray-200">
            @if($report->incident_photos)
            <img src="{{ asset('storage/' . json_decode($report->incident_photos)[0]) }}" alt="Incident photo"
              class="w-full h-full object-cover cursor-pointer"
              onclick="openPhotosModal('{{ $report->id }}', 'incident', 0)">
            @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100">
              <i class="ph-fill ph-image text-2xl text-gray-400"></i>
            </div>
            @endif
          </div>

          <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold flex items-center truncate">
              <i class="ph-fill ph-tag mr-2"></i>
              <a href="#" class="report-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                data-id="{{ $report->id }}" data-report-number="{{ $report->report_number }}"
                data-full-name="{{ $report->full_name }}" data-contact-no="{{ $report->contact_no }}"
                data-incident-location="{{ $report->incident_location }}"
                data-incident-date="{{ $report->incident_date->format('M d, Y') }}"
                data-species="{{ ucwords(strtolower($report->species)) }}"
                data-animal-condition="{{ $report->animal_condition }}"
                data-additional-notes="{{ $report->additional_notes }}"
                data-valid-id="{{ asset('storage/' . $report->valid_id_path) }}"
                data-incident-photos="{{ $report->incident_photos }}" data-status="{{ $displayStatus }}"
                data-reject-reason="{{ $report->reject_reason }}" data-user-email="{{ $report->user->email ?? '' }}">
                {{ $report->report_number }}
              </a>
            </h3>
            <p class="text-sm truncate">
              <span class="text-gray-500">Reporter:</span>
              <span class="font-medium text-gray-900 truncate">{{ ucwords(strtolower($report->full_name ?: 'Anonymous'))
                }}</span>
            </p>
            <p class="text-sm">
              <span class="text-gray-500">Status:</span> <span class="px-2 py-1 text-xs rounded-md ring-1 ring-inset 
                {{ $displayStatus === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $displayStatus === 'action taken' ? 'bg-green-100 text-green-700' : '' }}
                {{ $displayStatus === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                @switch($displayStatus)
                @case('pending') Waiting for Review @break
                @case('action taken') Action Taken @break
                @case('rejected') Rejected @break
                @endswitch
              </span>
            </p>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="bg-gray-50 px-4 py-3 flex justify-end">
        <form method="POST" action="/transactions/abused-status/{{ $report->id }}">
          @csrf
          @method('DELETE')
          <button type="button" onclick="showDeleteModal('{{ $report->id }}', '{{ $report->report_number }}')"
            class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 flex items-center">
            <i class="ph-fill ph-trash mr-1"></i> Delete
          </button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  <!-- Pagination -->
  <div class="mt-6">
    {{ $abusedReports->appends(request()->except('page'))->links() }}
  </div>

  <!-- Report Info Modal -->
  <div id="reportInfoModal"
    class="fixed inset-0 px-2 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative max-h-[90vh] overflow-y-auto scrollbar-hidden">
      <button id="closeReportInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 mb-4">Report Details</h2>

      <div class="mt-4">
        <div class="flex gap-x-2 items-center">
          <label class="text-sm font-medium text-gray-600">Valid ID</label>
          <div>
            <button id="viewValidId" class="text-blue-500 hover:underline text-sm hover:text-blue-600 cursor-pointer">
              View Uploaded ID
            </button>
          </div>
        </div>
      </div>

      <!-- Incident Photos Section -->
      <div class="mt-2 mb-6 p-4 bg-gray-50 rounded-lg">
        <div>
          <label class="text-sm font-medium text-gray-600">Incident Photos</label>
          <div id="incidentPhotosContainer" class="flex items-center gap-2 mt-2">
            <!-- Photos will be inserted here by JavaScript -->
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Reporter's Name</label>
            <input type="text" id="reporterName" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Contact Number</label>
            <input type="text" id="contactNumber" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Animal Species</label>
            <input type="text" id="animalSpecies" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Animal Condition</label>
            <input type="text" id="animalCondition" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Incident Date</label>
            <input type="text" id="incidentDate" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Reporter's Email</label>
            <input type="text" id="reporterEmail" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <div class="grid grid-cols-1 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Incident Location</label>
            <input type="text" id="incidentLocation" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <!-- Reject Reason (if rejected) -->
        <div id="rejectReasonContainer" class="mt-4 hidden">
          <label class="text-sm font-medium text-gray-600">Rejection Reason</label>
          <input type="text" id="rejectReason" readonly
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
        </div>

        <!-- Additional Notes Section -->
        <div class="mt-4">
          <label class="text-sm font-medium text-gray-600">Additional Notes</label>
          <div type="text" id="additionalNotes" readonly
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
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
  </div>

  <!-- Photos Modal -->
  <div id="photosModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-w-4xl max-h-[90vh] flex flex-col">
      <button id="closePhotosModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x text-xl"></i>
      </button>
      <h2 class="text-xl font-semibold text-gray-800 mb-4" id="photosModalTitle">Photos</h2>

      <div class="flex-1 overflow-hidden relative">
        <!-- Main Image Display -->
        <div class="w-full h-full flex items-center justify-center">
          <img id="mainPhoto" alt="Photo" class="max-h-[60vh] max-w-full object-contain rounded-lg shadow-md">
        </div>
      </div>

      <!-- Thumbnail Strip -->
      <div id="photoThumbnails" class="flex gap-2 mt-4 overflow-x-auto py-2">
        <!-- Thumbnails will be inserted here by JavaScript -->
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
    // Report Info Modal
    document.querySelectorAll('.report-info-btn').forEach(button => {
      button.addEventListener('click', function() {
        // Basic info
        document.getElementById('reporterName').value = this.dataset.fullName || 'Anonymous';
        document.getElementById('contactNumber').value = this.dataset.contactNo || 'Not provided';
        document.getElementById('reporterEmail').value = this.dataset.userEmail || 'Not provided';
        document.getElementById('animalSpecies').value = this.dataset.species;
        document.getElementById('animalCondition').value = this.dataset.animalCondition;
        document.getElementById('incidentLocation').value = this.dataset.incidentLocation;
        document.getElementById('incidentDate').value = this.dataset.incidentDate;
        document.getElementById('additionalNotes').textContent = this.dataset.additionalNotes || 'No additional notes provided';
        
        // Reject reason (if rejected)
        const rejectReasonContainer = document.getElementById('rejectReasonContainer');
        if (this.dataset.status === 'rejected' && this.dataset.rejectReason) {
          rejectReasonContainer.classList.remove('hidden');
          document.getElementById('rejectReason').value = this.dataset.rejectReason;
        } else {
          rejectReasonContainer.classList.add('hidden');
        }
        
        // Set up the valid ID view button
        document.getElementById('viewValidId').onclick = function() {
          document.getElementById('modalImage').src = button.dataset.validId;
          document.getElementById('imageModal').classList.remove('hidden');
        };
        
        // Load incident photos
        const incidentPhotosContainer = document.getElementById('incidentPhotosContainer');
        incidentPhotosContainer.innerHTML = '';
        
        try {
          const incidentPhotos = JSON.parse(button.dataset.incidentPhotos || '[]');
          
          if (incidentPhotos.length === 0) {
            incidentPhotosContainer.innerHTML = '<p class="text-gray-500 text-sm">No incident photos uploaded</p>';
          } else {
            incidentPhotos.forEach((photo, index) => {
              const photoUrl = "{{ asset('storage/') }}/" + photo;
              const photoElement = document.createElement('div');
              photoElement.className = 'cursor-pointer hover:opacity-80 transition-opacity';
              photoElement.innerHTML = `
                <img src="${photoUrl}" alt="Incident photo ${index + 1}" 
                    class="w-24 h-24 object-cover rounded-md border border-gray-200"
                    onclick="openPhotosModal('${button.dataset.id}', 'incident', ${index})">
              `;
              incidentPhotosContainer.appendChild(photoElement);
            });
          }
        } catch (e) {
          incidentPhotosContainer.innerHTML = '<p class="text-gray-500 text-sm">Error loading incident photos</p>';
        }
        
        document.getElementById('reportInfoModal').classList.remove('hidden');
      });
    });

    // Function to open photos modal for a specific report
    function openPhotosModal(reportId, type, startIndex = 0) {
      const button = document.querySelector(`.report-info-btn[data-id="${reportId}"]`);
      if (!button) return;
      
      try {
        const photos = JSON.parse(button.dataset.incidentPhotos || '[]');
        if (photos.length === 0) return;
        
        const modal = document.getElementById('photosModal');
        const mainImg = document.getElementById('mainPhoto');
        const thumbnailsContainer = document.getElementById('photoThumbnails');
        const modalTitle = document.getElementById('photosModalTitle');
        
        // Set modal title
        modalTitle.textContent = 'Incident Photos';
        
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
     
        modal.classList.remove('hidden');
      } catch (e) {
        console.error('Error loading photos:', e);
      }
    }

    // Close report info modal
    document.getElementById('closeReportInfoModal').addEventListener('click', function() {
      document.getElementById('reportInfoModal').classList.add('hidden');
    });

    // Photos modal close handler
    document.getElementById('closePhotosModal').addEventListener('click', function() {
      document.getElementById('photosModal').classList.add('hidden');
    });

    // Image modal close handler
    document.getElementById('closeImageModal').addEventListener('click', function() {
      document.getElementById('imageModal').classList.add('hidden');
    });

    // Delete modal functions
    function showDeleteModal(reportId, reportNumber) {
      document.getElementById('deleteReportId').value = reportId;
      document.getElementById('reportNumberToDelete').textContent = reportNumber;
      document.getElementById('deleteForm').action = `/transactions/abused-status/${reportId}`;
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    document.getElementById('closeDeleteModal').addEventListener('click', function() {
      document.getElementById('deleteModal').classList.add('hidden');
    });

    document.getElementById('cancelDelete').addEventListener('click', function() {
      document.getElementById('deleteModal').classList.add('hidden');
    });
  </script>
</x-transactions-layout>