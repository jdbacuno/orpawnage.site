<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Archives</h1>

  <div class="mt-4">
    {{-- Filter Section --}}
    <div class="flex flex-wrap gap-2 mb-4">
      <form method="GET" action="{{ route('archives') }}" class="flex flex-wrap gap-4">
        <!-- Type Filter -->
        <select name="type"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[200px]"
          onchange="this.form.submit()">
          <option value="pets" {{ request('type', 'pets' )==='pets' ? 'selected' : '' }}>Pets Profiles</option>
          <option value="adoption" {{ request('type')==='adoption' ? 'selected' : '' }}>Adoption Applications</option>
          <option value="surrender" {{ request('type')==='surrender' ? 'selected' : '' }}>Surrender Applications
          </option>
          <option value="missing" {{ request('type')==='missing' ? 'selected' : '' }}>Missing Pets Reports</option>
          <option value="abused" {{ request('type')==='abused' ? 'selected' : '' }}>Abused/Stray Reports</option>
        </select>
      </form>
    </div>

    @if($items->isEmpty())
    @php
    $typeLabels = [
    'pets' => 'archived pets',
    'adoption' => 'adoption applications',
    'surrender' => 'surrender applications',
    'missing' => 'missing pet reports',
    'abused' => 'abused/stray animal reports',
    ];
    $type = request('type', 'pets');
    $label = $typeLabels[$type] ?? 'archived items';
    @endphp

    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No {{ $label }} found.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      @foreach($items as $item)
      <div
        class="bg-white w-full rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
        <!-- Header with image and basic info -->
        <div class="p-4 border-b border-gray-200">
          <div class="flex items-start space-x-2">
            @if($type === 'pets')
            <!-- Pet Image -->
            <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
              <img src="{{ asset('storage/' . $item->image_path) }}"
                alt="{{ strtolower($item->pet_name) !== 'n/a' ? ucwords($item->pet_name) : 'Unnamed' }}"
                class="w-full h-full object-cover cursor-pointer" onclick="openPetPhotoModal(this)">
            </div>
            @endif

            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold flex items-center truncate">
                @if($type === 'pets')
                <i class="ph-fill ph-paw-print mr-2"></i>
                <a href="#" class="archive-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $item->id }}" data-type="{{ $type }}"
                  data-name="{{ strtolower($item->pet_name) !== 'n/a' ? ucwords($item->pet_name) : 'Unnamed' }}"
                  data-number="{{ $item->pet_number }}" data-species="{{ $item->species === 'feline' ? 'Cat' : 'Dog' }}"
                  data-age="{{ $item->age }} {{ $item->age_unit }}" data-sex="{{ ucfirst($item->sex) }}"
                  data-repro-status="{{ ucfirst($item->reproductive_status) }}" data-color="{{ ucfirst($item->color) }}"
                  data-source="{{ ucfirst($item->source) }}" data-image="{{ asset('storage/' . $item->image_path) }}"
                  data-reason="{{ $item->archive_reason === 'Other' ? $item->archive_notes : $item->archive_reason }}"
                  data-date="{{ $item->created_at->format('M d, Y') }}">
                  {{ strtolower($item->pet_name) !== 'n/a' ? ucwords($item->pet_name) : 'Unnamed' }}
                </a>
                @elseif($type === 'adoption')
                <i class="ph-fill ph-tag mr-2"></i>
                <a href="#" class="archive-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $item->id }}" data-type="{{ $type }}" data-number="{{ $item->transaction_number }}"
                  data-name="{{ $item->full_name }}" data-pet-name="{{ $item->pet->pet_name }}"
                  data-pet-number="{{ $item->pet->pet_number }}"
                  data-species="{{ $item->pet->species === 'feline' ? 'Cat' : 'Dog' }}" data-email="{{ $item->email }}"
                  data-phone="{{ $item->contact_number }}" data-date="{{ $item->created_at->format('M d, Y') }}"
                  data-reason="{{ $item->archive_reason ?? 'No reason provided' }}"
                  data-adoption-reason="{{ $item->reason_for_adoption }}">
                  {{ $item->transaction_number }}
                </a>
                @elseif($type === 'surrender')
                <i class="ph-fill ph-envelope-simple-open mr-2"></i>
                <a href="#" class="archive-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $item->id }}" data-type="{{ $type }}" data-number="{{ $item->transaction_number }}"
                  data-name="{{ $item->full_name }}" data-pet-name="{{ $item->pet_name }}"
                  data-species="{{ ucfirst($item->species) }}" data-email="{{ $item->email }}"
                  data-phone="{{ $item->contact_number }}"
                  data-date="{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}"
                  data-reason="{{ $item->reason ?? 'No reason provided' }}">
                  {{ $item->transaction_number }}
                </a>
                @elseif(in_array($type, ['missing', 'abused']))
                <i class="ph-fill ph-warning-circle mr-2"></i>
                <a href="#" class="archive-info-btn text-blue-500 hover:text-blue-600 hover:underline"
                  data-id="{{ $item->id }}" data-type="{{ $type }}" data-number="{{ $item->report_number }}"
                  data-name="{{ $item->full_name ?? 'Anonymous' }}"
                  data-date="{{ $type === 'missing' ? \Carbon\Carbon::parse($item->last_seen_date)->format('M d, Y') : \Carbon\Carbon::parse($item->incident_date)->format('M d, Y') }}"
                  data-reason="{{ $type === 'missing' ? $item->pet_description : $item->additional_notes }}"
                  data-location="{{ $type === 'missing' ? $item->last_seen_location : $item->incident_location }}"
                  data-status="{{ $item->status }}">
                  {{ $item->report_number }}
                </a>
                @endif
              </h3>

              @if($type === 'pets')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Species:</span>
                <span class="font-medium">{{ $item->species === 'feline' ? 'Cat' : 'Dog' }}#{{ $item->pet_number
                  }}</span>
              </p>
              @elseif($type === 'adoption')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Adopter:</span>
                <span class="font-medium">{{ $item->full_name }}</span>
              </p>
              @elseif($type === 'surrender')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Owner:</span>
                <span class="font-medium">{{ $item->full_name }}</span>
              </p>
              @elseif($type === 'missing')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Reported by:</span>
                <span class="font-medium">{{ $item->full_name ?? 'Anonymous' }}</span>
              </p>
              @elseif($type === 'abused')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Reported by:</span>
                <span class="font-medium">{{ $item->full_name ?? 'Anonymous' }}</span>
              </p>
              @endif

              <p class="text-sm">
                <span class="text-gray-500">Archived on:</span>
                <span class="font-medium">{{ \Carbon\Carbon::parse($item->deleted_at)->format('M d, Y') }}</span>
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
                id="options-menu-{{ $item->id }}" aria-expanded="true" aria-haspopup="true"
                onclick="toggleDropdown('{{ $item->id }}')">
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
              id="dropdown-{{ $item->id }}">
              <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-{{ $item->id }}">
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900"
                  role="menuitem" onclick="showUnarchiveModal('{{ $type }}', '{{ $item->id }}')">
                  <i class="ph-fill ph-arrow-counter-clockwise mr-2"></i> Unarchive
                </button>
                <button type="button"
                  class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                  role="menuitem" onclick="showDeleteModal('{{ $type }}', '{{ $item->id }}')">
                  <i class="ph-fill ph-trash mr-2"></i> Delete Permanently
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $items->links() }}
    </div>
    @endif
  </div>

  <!-- Archive Info Modal -->
  <div id="archiveInfoModal"
    class="fixed inset-0 px-2 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div
      class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl relative max-h-[90vh] overflow-y-auto scrollbar-hidden">
      <button id="closeArchiveInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 mb-4" id="archiveModalTitle">Archive Details</h2>

      <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="text-sm font-medium text-gray-600">Archive Reason</label>
            <div class="mt-1 text-sm text-gray-900" id="archiveReason"></div>
          </div>
        </div>
      </div>

      <!-- Dynamic content based on type -->
      <div id="archiveContent"></div>
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
        <div class="w-full h-full flex items-center justify-center">
          <img id="mainPetPhoto" alt="Pet Photo" class="max-h-[60vh] max-w-full object-contain rounded-lg shadow-md">
        </div>
      </div>
    </div>
  </div>

  <!-- Unarchive Confirmation Modal -->
  <div id="unarchiveModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeUnarchiveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Confirm Unarchive</h2>
      <p class="mb-4">Are you sure you want to unarchive this item?</p>
      <p class="mb-4 text-yellow-800 text-sm">This will restore the item to its previous status and make it visible in
        the main lists.</p>

      <form id="unarchiveForm" method="POST" action="">
        @csrf
        @method('PATCH')
        <input type="hidden" name="type" id="unarchiveType">
        <input type="hidden" name="id" id="unarchiveId">

        <div class="flex justify-end space-x-3 mt-4">
          <button type="button" id="cancelUnarchive"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-yellow-400 px-4 py-2 text-black hover:bg-yellow-500 rounded-md">
            Confirm Unarchive
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeDeleteModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
      <p class="mb-4">Are you sure you want to permanently delete this item?</p>
      <p class="mb-4 text-red-800 text-sm">This action cannot be undone. All data associated with this item will be
        permanently removed.</p>

      <form id="deleteForm" method="POST" action="">
        @csrf
        @method('DELETE')
        <input type="hidden" name="type" id="deleteType">
        <input type="hidden" name="id" id="deleteId">

        <div class="flex justify-end space-x-3 mt-4">
          <button type="button" id="cancelDelete" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-red-500 px-4 py-2 text-white hover:bg-red-600 rounded-md">
            Confirm Delete
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Archive Info Modal
    document.querySelectorAll('.archive-info-btn').forEach(button => {
      button.addEventListener('click', function() {
        const type = this.dataset.type;
        document.getElementById('archiveModalTitle').textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} Archive Details`;
        document.getElementById('archiveReason').textContent = this.dataset.reason || 'No reason provided';

        // Set up dynamic content based on type
        const contentDiv = document.getElementById('archiveContent');
        contentDiv.innerHTML = '';

        if (type === 'pets') {
          contentDiv.innerHTML = `
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
              <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-paw-print mr-2"></i>Pet Information
              </h3>
              <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md overflow-hidden">
                  <img id="petImagePreview" src="${this.dataset.image}" alt="Pet Image"
                    class="w-full h-full object-cover cursor-pointer" onclick="openPetPhotoModal(this)">
                </div>
                <div class="grid grid-cols-2 gap-4 flex-1">
                  <div>
                    <label class="text-sm font-medium text-gray-500">Name</label>
                    <div class="mt-1 text-sm text-gray-900">${this.dataset.name} (#${this.dataset.number})</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-500">Species</label>
                    <div class="mt-1 text-sm text-gray-900">${this.dataset.species}</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-500">Age</label>
                    <div class="mt-1 text-sm text-gray-900">${this.dataset.age}</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-500">Sex</label>
                    <div class="mt-1 text-sm text-gray-900">${this.dataset.sex}</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-500">Reproductive Status</label>
                    <div class="mt-1 text-sm text-gray-900">${this.dataset.reproStatus}</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-500">Source</label>
                    <div class="mt-1 text-sm text-gray-900">${this.dataset.source}</div>
                  </div>
                </div>
              </div>
            </div>
          `;
        } else if (type === 'adoption' || type === 'surrender') {
          contentDiv.innerHTML = `
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
              <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-user-circle mr-2"></i>${type === 'adoption' ? 'Adopter' : 'Owner'} Information
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-600">Name</label>
                  <input type="text" value="${this.dataset.name}" readonly
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Contact Number</label>
                  <input type="text" value="${this.dataset.phone || 'Not provided'}" readonly
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Email</label>
                  <input type="text" value="${this.dataset.email || 'Not provided'}" readonly
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
                </div>
              </div>
              ${type === 'adoption' ? `
              <div class="mt-4">
                <label class="text-sm font-medium text-gray-600">Pet</label>
                <input type="text" value="${this.dataset.petName} (${this.dataset.species}#${this.dataset.petNumber})" readonly
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
              </div>
              ` : ''}
              <div class="mt-4">
                <label class="text-sm font-medium text-gray-600">${type === 'adoption' ? 'Reason for Adoption' : 'Reason for Surrendering'}</label>
                <div class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
                  ${type === 'adoption' ? this.dataset.adoptionReason : this.dataset.reason}
                </div>
              </div>
            </div>
          `;
        } else if (type === 'missing' || type === 'abused') {
          contentDiv.innerHTML = `
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
              <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-warning-circle mr-2"></i>Report Details
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-600">Reported by</label>
                  <input type="text" value="${this.dataset.name}" readonly
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">${type === 'missing' ? 'Last Seen Date' : 'Incident Date'}</label>
                  <input type="text" value="${this.dataset.date}" readonly
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
                </div>
                <div class="md:col-span-2">
                  <label class="text-sm font-medium text-gray-600">${type === 'missing' ? 'Last Seen Location' : 'Incident Location'}</label>
                  <input type="text" value="${this.dataset.location || 'Not specified'}" readonly
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100">
                </div>
                <div class="md:col-span-2">
                  <label class="text-sm font-medium text-gray-600">${type === 'missing' ? 'Pet Description' : 'Additional Notes'}</label>
                  <div class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100 whitespace-pre-line">
                    ${this.dataset.reason || 'No details provided'}
                  </div>
                </div>
              </div>
            </div>
          `;
        }

        document.getElementById('archiveInfoModal').classList.remove('hidden');
      });
    });

    // Open pet photo modal
    function openPetPhotoModal(imgElement) {
      const petImageSrc = imgElement.src;
      if (!petImageSrc) return;

      document.getElementById('mainPetPhoto').src = petImageSrc;
      document.getElementById('petPhotoModal').classList.remove('hidden');
    }

    // Close modals
    document.getElementById('closeArchiveInfoModal').addEventListener('click', function() {
      document.getElementById('archiveInfoModal').classList.add('hidden');
    });

    document.getElementById('closePetPhotoModal').addEventListener('click', function() {
      document.getElementById('petPhotoModal').classList.add('hidden');
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

    // Show unarchive modal
    function showUnarchiveModal(type, id) {
      document.getElementById('unarchiveType').value = type;
      document.getElementById('unarchiveId').value = id;
      document.getElementById('unarchiveForm').action = `/admin/archives/${type}/${id}/restore`;
      document.getElementById('unarchiveModal').classList.remove('hidden');
    }

    // Close unarchive modal
    document.getElementById('closeUnarchiveModal').addEventListener('click', function() {
      document.getElementById('unarchiveModal').classList.add('hidden');
    });

    // Cancel unarchive
    document.getElementById('cancelUnarchive').addEventListener('click', function() {
      document.getElementById('unarchiveModal').classList.add('hidden');
    });

    // Show delete modal
    function showDeleteModal(type, id) {
      document.getElementById('deleteType').value = type;
      document.getElementById('deleteId').value = id;
      document.getElementById('deleteForm').action = `/admin/archives/${type}/${id}`;
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Close delete modal
    document.getElementById('closeDeleteModal').addEventListener('click', function() {
      document.getElementById('deleteModal').classList.add('hidden');
    });

    // Cancel delete
    document.getElementById('cancelDelete').addEventListener('click', function() {
      document.getElementById('deleteModal').classList.add('hidden');
    });
  </script>
</x-admin-layout>