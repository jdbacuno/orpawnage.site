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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
      @foreach($items as $item)
      <div
        class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
        <!-- Header with image and basic info -->
        <div class="p-4 border-b border-gray-200">
          <div class="flex items-start space-x-2">
            @if($type === 'pets')
            <!-- Pet Image -->
            <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
              <img src="{{ asset('storage/' . $item->image_path) }}"
                alt=" {{ strtolower($item->pet_name) !== 'n/a' ? ucwords($item->pet_name) : 'Unnamed' }}"
                class="w-full h-full object-cover">
            </div>
            @endif

            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold flex items-center truncate">
                @if($type === 'pets')
                <i class="ph-fill ph-paw-print mr-2"></i> {{ strtolower($item->pet_name) !== 'n/a' ?
                ucwords($item->pet_name) : 'Unnamed' }}
                @elseif($type === 'adoption')
                <i class="ph-fill ph-tag mr-2"></i> {{ $item->transaction_number }}
                @elseif($type === 'surrender')
                <i class="ph-fill ph-envelope-simple-open mr-2"></i> {{ $item->reference_number }}
                @elseif(in_array($type, ['missing', 'abused']))
                <i class="ph-fill ph-warning-circle mr-2"></i> {{ $item->report_number }}
                @endif
              </h3>

              @if($type === 'pets')
              <p class="text-sm font-medium text-gray-900 truncate">
                {{ ucfirst($item->species == 'feline' ? 'Cat' : 'Dog') }} #{{ $item->pet_number }}
              </p>
              @elseif($type === 'adoption')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Adopter:</span>
                <span class="font-medium">{{ $item->full_name }}</span>
              </p>
              @elseif($type === 'surrender')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Owner:</span>
                <span class="font-medium">{{ $item->owner_name }}</span>
              </p>
              @elseif($type === 'missing')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Reported by:</span>
                <span class="font-medium">{{ $item->full_name ?: 'Anonymous' }}</span>
              </p>
              @elseif($type === 'abused')
              <p class="text-sm mt-1 truncate">
                <span class="text-gray-500">Reported by:</span>
                <span class="font-medium">{{ $item->full_name ?: 'Anonymous' }}</span>
              </p>
              @endif
            </div>
          </div>
        </div>

        <!-- Details Section -->
        <div class="p-4 space-y-3">
          <!-- Type-Specific Information -->
          @if($type === 'pets')
          <!-- Pet Details -->
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Species</span>
              <span class="text-sm text-gray-900">{{ ucfirst($item->species) }}</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Age</span>
              <span class="text-sm text-gray-900">{{ $item->age }} {{ $item->age_unit }}</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Sex</span>
              <span class="text-sm text-gray-900">{{ ucfirst($item->sex) }}</span>
            </div>

            @if($item->archive_reason || $item->archive_notes)
            <div class="space-y-3 border-t border-gray-100">
              @if($item->archive_reason === 'Other')
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-500">Archive Reason</span>
                <p class="text-sm text-gray-900 truncate">{{ $item->archive_notes }}</p>
              </div>
              @else
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-500">Archive Reason</span>
                <span class="text-sm text-gray-900">{{ $item->archive_reason }}</span>
              </div>
              @endif
            </div>
            @endif
          </div>

          @elseif($type === 'adoption')
          <!-- Adoption Application Details -->
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Pet</span>
              <span class="text-sm text-gray-900">{{ $item->pet->pet_name }} ({{ ucfirst($item->species == 'feline' ?
                'Cat' : 'Dog') }}#{{ $item->pet->pet_number }})</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Applied On</span>
              <span class="text-sm text-gray-900">{{ $item->created_at->format('M d, Y') }}</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Contact</span>
              <span class="text-sm text-gray-900">{{ $item->contact_number }}</span>
            </div>
          </div>

          @elseif($type === 'surrender')
          <!-- Surrender Application Details -->
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Pet Name</span>
              <span class="text-sm text-gray-900">{{ $item->pet_name }}</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Pet Type</span>
              <span class="text-sm text-gray-900">{{ ucfirst($item->pet_type) }}</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Reason</span>
              <span class="text-sm text-gray-900">{{ Str::limit($item->surrender_reason, 20) }}</span>
            </div>
          </div>

          @elseif($type === 'missing')
          <!-- Missing Pet Report Details -->
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Additional Info</span>
              <span data-title="Additional Info" onclick="showTextModal(this, `{{ $item->pet_description }}`)"
                class="text-sm text-gray-900 truncate cursor-pointer transition-color duration-100 ease-in hover:text-blue-500">
                {{ Str::limit($item->pet_description, 20) }}
              </span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Last Seen Location</span>
              <span data-title="Last Seen Location" onclick="showTextModal(this, `{{ $item->last_seen_location }}`)"
                class="text-sm text-gray-900 truncate cursor-pointer transition-color duration-100 ease-in hover:text-blue-500">
                {{ Str::limit($item->last_seen_location, 20) }}
              </span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Last Seen Date</span>
              <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->last_seen_date)->format('M d, Y') }}
              </span>
            </div>
          </div>

          @elseif($type === 'abused')
          <!-- Animal Abuse Report Details -->
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Species</span>
              <span class="text-sm text-gray-900">{{ ucfirst($item->species) }}</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Incident</span>
              <span class="text-sm text-gray-900">{{ ucfirst($item->animal_condition) }}</span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Incident Location</span>
              <span data-title="Incident Location" onclick="showTextModal(this, `{{ $item->incident_location }}`)"
                class="text-sm text-gray-900 truncate cursor-pointer transition-color duration-100 ease-in hover:text-blue-500">
                {{ Str::limit($item->incident_location, 20) }}
              </span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Incident Date</span>
              <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->incident_date)->format('M d, Y') }}
              </span>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Additional Notes</span>

              <span data-title="Notes" onclick="showTextModal(this, `{{ $item->additional_notes }}`)"
                class="text-sm text-gray-900 truncate cursor-pointer transition-color duration-100 ease-in hover:text-blue-500">
                {{ Str::limit($item->additional_notes, 20) }}
              </span>
            </div>
          </div>
          @endif
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
                <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                  Archived
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

  {{-- TEXT MODAL --}}
  <div id="textModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-lg w-full max-h-[90vh] overflow-auto">
      <button onclick="closeTextModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800" id="textTitle">Incident Location</h2>
      <div class="w-full mt-2 text-gray-700 whitespace-pre-wrap break-words" id="textModalContent"></div>
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
    function showTextModal(el, text) {
      document.getElementById('textTitle').textContent = el.dataset.title;
      document.getElementById('textModalContent').textContent = text;
      document.getElementById('textModal').classList.remove('hidden');
    }

    function closeTextModal() {
      document.getElementById('textModal').classList.add('hidden');
    }

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