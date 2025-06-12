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
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($reports as $report)
    <div
      class="bg-white w-full rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
      <!-- Pet and Owner Info Header -->
      <div class="p-4 border-b border-gray-200">
        <div class="flex items-start space-x-2">
          <!-- Pet Image (first pet photo or placeholder) -->
          <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
            @if($report->pet_photos)
            <img src="{{ asset('storage/' . json_decode($report->pet_photos)[0]) }}" alt="{{ $report->pet_name }}"
              class="w-full h-full object-cover cursor-pointer"
              onclick="openPhotosModal('{{ $report->id }}', 'pet', 0)">
            @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100">
              <i class="ph-fill ph-paw-print text-2xl text-gray-400"></i>
            </div>
            @endif
          </div>

          <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold flex items-center truncate">
              <i class="ph-fill ph-tag mr-2"></i><a href="#"
                class="owner-info-btn text-blue-500 hover:text-blue-600 hover:underline" data-id="{{ $report->id }}"
                data-name="{{ $report->owner_name }}" data-pet-name="{{ $report->pet_name }}"
                data-last-seen-date="{{ $report->last_seen_date->format('M d, Y') }}"
                data-contact="{{ $report->contact_no }}" data-validid="{{ asset('storage/' . $report->valid_id_path) }}"
                data-petphotos="{{ $report->pet_photos }}" data-locationphotos="{{ $report->location_photos }}"
                data-description="{{ $report->pet_description }}" data-location="{{ $report->last_seen_location }}">{{
                $report->report_number }}</a>
            </h3>
            <p class="text-sm truncate">
              <span class="text-gray-500">Owner:</span>
              <span class="font-medium text-gray-900 truncate">{{ ucwords(strtolower($report->owner_name)) }}</span>
            </p>
            <p class="text-sm">
              <span class="text-gray-500">Status:</span> <span class="px-2 py-1 text-xs rounded 
                {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $report->status === 'acknowledged' ? 'bg-green-100 text-green-700' : '' }}
                {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                @switch($report->status)
                @case('pending') Pending @break
                @case('acknowledged') Acknowledged @break
                @case('rejected') Rejected @break
                @endswitch
              </span>
            </p>
          </div>
        </div>
      </div>

      <!-- Action Buttons Dropdown -->
      <div class="bg-gray-50 px-4 py-3 flex justify-end relative z-10">
        <div class="relative inline-block text-left">
          <div>
            <button type="button"
              class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
              id="options-menu-{{ $report->id }}" aria-expanded="true" aria-haspopup="true"
              onclick="toggleDropdown('{{ $report->id }}')">
              <span class="mr-2">Actions</span>
              <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                aria-hidden="true">
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
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-{{ $report->id }}">
              @if($report->status === 'pending')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900"
                role="menuitem" onclick="showAcknowledgeModal('{{ $report->id }}')">
                <i class="ph-fill ph-share mr-2"></i> Acknowledge
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
    @endforeach
  </div>
  @endif

  <!-- Pagination -->
  <div class="mt-6">
    {{ $reports->appends(request()->except('page'))->links() }}
  </div>

  <!-- Owner Info Modal -->
  <div id="ownerInfoModal"
    class="fixed inset-0 px-2 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative max-h-[90vh] overflow-y-auto scrollbar-hidden">
      <button id="closeOwnerInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 mb-4">Owner's Information</h2>

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

      <!-- Pet Photos Section -->
      <div class="mt-2 mb-6 p-4 bg-gray-50 rounded-lg">
        <div>
          <label class="text-sm font-medium text-gray-600">Pet Photos</label>
          <div id="petPhotosContainer" class="flex flex-wrap items-center gap-2 mt-2">
            <!-- Photos will be inserted here by JavaScript -->
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Owner's Name</label>
            <input type="text" id="ownerName" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Contact Number</label>
            <input type="text" id="ownerContact" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Pet's Name</label>
            <input type="text" id="petName" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600">Last Seen On</label>
            <input type="text" id="lastSeenOn" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <div class="grid grid-cols-1 gap-4 mt-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Last Seen At</label>
            <input type="text" id="lastSeenAt" readonly
              class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
          </div>
        </div>

        <!-- Location Photos Section -->
        <div class="mt-4">
          <label class="text-sm font-medium text-gray-600">Locations of Last and/or Possible Sightings</label>
          <div id="locationPhotosContainer" class="flex items-center gap-2 mt-2">
            <!-- Photos will be inserted here by JavaScript -->
          </div>
        </div>

        <!-- Pet Description Section -->
        <div class="mt-4">
          <label class="text-sm font-medium text-gray-600">Additional Notes/Info</label>
          <div type="text" id="descriptionContent" readonly
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
          </div>
        </div>
      </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 px-2 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
      <div class="bg-white p-4 rounded-lg shadow-lg relative max-h-[90vh] overflow-auto">
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
            <i class="ph-fill ph-share mr-2"></i>Notify
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

  <!-- Archive Confirmation Modal -->
  <div id="archiveModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeArchiveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 flex items-center"><i class="ph-fill ph-archive mr-2"></i>Confirm
        Archive</h2>
      <p class="mb-4">Are you sure you want to archive this missing pet report?</p>
      <p class="mb-4 text-gray-500 text-sm">Archived reports will be moved to a separate section and won't appear in
        the
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
    // Owner Info Modal
    document.querySelectorAll('.owner-info-btn').forEach(button => {
      button.addEventListener('click', function() {
        document.getElementById('ownerName').value = this.dataset.name;
        document.getElementById('ownerContact').value = this.dataset.contact;

        document.getElementById('petName').value = this.dataset.petName;
        document.getElementById('lastSeenOn').value = this.dataset.lastSeenDate;
        document.getElementById('lastSeenAt').value = this.dataset.location;
        
        // Set up the valid ID view button
        document.getElementById('viewValidId').onclick = function() {
          document.getElementById('modalImage').src = button.dataset.validid;
          document.getElementById('imageModal').classList.remove('hidden');
        };
        
        document.getElementById('descriptionContent').textContent = this.dataset.description || 'No description provided';
        
        // Load pet photos
        const petPhotosContainer = document.getElementById('petPhotosContainer');
        petPhotosContainer.innerHTML = '';
        
        try {
          const petPhotos = JSON.parse(button.dataset.petphotos || '[]');
          
          if (petPhotos.length === 0) {
            petPhotosContainer.innerHTML = '<p class="text-gray-500 text-sm">No pet photos uploaded</p>';
          } else {
            petPhotos.forEach((photo, index) => {
              const photoUrl = "{{ asset('storage/') }}/" + photo;
              const photoElement = document.createElement('div');
              photoElement.className = 'cursor-pointer hover:opacity-80 transition-opacity';
              photoElement.innerHTML = `
                <img src="${photoUrl}" alt="Pet photo ${index + 1}" 
                    class="w-24 h-24 object-cover rounded-md border border-gray-200"
                    onclick="openPhotosModal('${button.dataset.id}', 'pet', ${index})">
              `;
              petPhotosContainer.appendChild(photoElement);
            });
          }
        } catch (e) {
          petPhotosContainer.innerHTML = '<p class="text-gray-500 text-sm">Error loading pet photos</p>';
        }
        
        // Load location photos
        const locationPhotosContainer = document.getElementById('locationPhotosContainer');
        locationPhotosContainer.innerHTML = '';
        
        try {
          const locationPhotos = JSON.parse(button.dataset.locationphotos || '[]');
          
          if (locationPhotos.length === 0) {
            locationPhotosContainer.innerHTML = '<p class="text-gray-500 text-sm">No location photos uploaded</p>';
          } else {
            locationPhotos.forEach((photo, index) => {
              const photoUrl = "{{ asset('storage/') }}/" + photo;
              const photoElement = document.createElement('div');
              photoElement.className = 'cursor-pointer hover:opacity-80 transition-opacity';
              photoElement.innerHTML = `
                <img src="${photoUrl}" alt="Location photo ${index + 1}" 
                     class="w-24 h-24 object-cover rounded-md border border-gray-200"
                     onclick="openPhotosModal('${button.dataset.id}', 'location', ${index})">
              `;
              locationPhotosContainer.appendChild(photoElement);
            });
          }
        } catch (e) {
          locationPhotosContainer.innerHTML = '<p class="text-gray-500 text-sm">Error loading location photos</p>';
        }
        
        document.getElementById('ownerInfoModal').classList.remove('hidden');
      });
    });

    // Function to open photos modal for a specific report
    function openPhotosModal(reportId, type, startIndex = 0) {
      const button = document.querySelector(`.owner-info-btn[data-id="${reportId}"]`);
      if (!button) return;
      
      try {
        const photos = JSON.parse(button.dataset[`${type}photos`] || '[]');
        if (photos.length === 0) return;
        
        const modal = document.getElementById('photosModal');
        const mainImg = document.getElementById('mainPhoto');
        const thumbnailsContainer = document.getElementById('photoThumbnails');
        const modalTitle = document.getElementById('photosModalTitle');
        
        // Set modal title
        modalTitle.textContent = type === 'pet' ? 'Pet Photos' : 'Location Photos';
        
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

    // Close owner info modal
    document.getElementById('closeOwnerInfoModal').addEventListener('click', function() {
      document.getElementById('ownerInfoModal').classList.add('hidden');
    });

    // Photos modal close handler
    document.getElementById('closePhotosModal').addEventListener('click', function() {
      document.getElementById('photosModal').classList.add('hidden');
    });

    // Image modal close handler
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