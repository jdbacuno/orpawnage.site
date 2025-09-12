<x-transactions-layout>
  <div class="mb-6">
    <div class="rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-[1px]">
      <div class="rounded-xl bg-white">
        <div class="px-5 py-5 sm:px-6 sm:py-6 flex flex-col gap-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                <i class="ph-fill ph-map-pin"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-900">Missing Pet Reports</h1>
                <p class="text-sm text-gray-500">Review and manage reported missing pets</p>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap gap-2">
            <a href="/transactions/adoption-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Adoptions</a>
            <a href="/transactions/surrender-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Surrenders</a>
            <a href="/transactions/missing-status"
              class="px-3 py-1.5 text-sm rounded-full bg-indigo-600 text-white shadow-sm">Missing Pets</a>
            <a href="/transactions/abused-status"
              class="px-3 py-1.5 text-sm rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Abused/Stray</a>
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
        <option value="acknowledged" {{ request('status')==='acknowledged' ? 'selected' : '' }}>Acknowledged</option>
        <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </form>
  </div>

  @if ($missingReports->isEmpty())
  <div
    class="flex flex-col items-center justify-center p-10 text-center bg-white rounded-lg border border-gray-200 shadow-sm">
    <img src="{{ asset('images/missing.png') }}" class="h-20 w-20 opacity-70 mb-3 rounded-full" alt="Empty" />
    <p class="text-lg font-medium text-gray-700">No missing pet reports found</p>
    <p class="text-sm text-gray-500">Try changing filters or check back later.</p>
  </div>
  @else
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($missingReports as $report)
    @php
    $displayStatus = $report->previous_status ?? $report->status;
    @endphp
    <div
      class="bg-white w-full rounded-xl shadow-sm overflow-hidden border border-gray-200 hover:shadow-md hover:-translate-y-[2px] transition-all duration-200">
      <!-- Pet and Owner Info Header -->
      <div class="p-4 border-b border-gray-100">
        <div class="flex items-start space-x-2">
          <!-- Pet Image (first pet photo or placeholder) -->
          <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden ring-1 ring-gray-200">
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
              <span class="text-gray-500">Status:</span> <span class="px-2 py-1 text-xs rounded-md ring-1 ring-inset 
                {{ $displayStatus === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $displayStatus === 'acknowledged' ? 'bg-green-100 text-green-700' : '' }}
                {{ $displayStatus === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                @switch($displayStatus)
                @case('pending') Waiting for Review @break
                @case('acknowledged') Acknowledged @break
                @case('rejected') Rejected @break
                @endswitch
              </span>
            </p>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="bg-gray-50 px-4 py-3 flex justify-end">
        <form method="POST" action="/transactions/missing-status/{{ $report->id }}">
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
    {{ $missingReports->appends(request()->except('page'))->links() }}
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
          <div id="petPhotosContainer" class="flex items-center gap-2 mt-2">
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
          <img id="mainPhoto" alt="Photo" class="max-h-[60vh] max-w-full object-cover rounded-lg shadow-md">
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

    // Delete modal functions
    function showDeleteModal(reportId, reportNumber) {
      document.getElementById('deleteReportId').value = reportId;
      document.getElementById('reportNumberToDelete').textContent = reportNumber;
      document.getElementById('deleteForm').action = `/transactions/missing-status/${reportId}`;
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