<x-admin-layout>
  <div class="max-w-[1600px] mx-auto">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Archives</h1>
      <p class="text-sm text-gray-600 mt-1">View and manage archived items. You can restore or permanently delete archived records.</p>
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

    <!-- Type Filter Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
      <div class="border-b border-gray-200">
        <nav class="flex overflow-x-auto scrollbar-hidden" aria-label="Tabs">
          <a href="{{ route('archives', ['type' => 'pets']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('type', 'pets') === 'pets' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-paw-print mr-2"></i>
            Pet Profiles
          </a>
          <a href="{{ route('archives', ['type' => 'adoption']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('type') === 'adoption' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-heart mr-2"></i>
            Adoption Applications
          </a>
          <a href="{{ route('archives', ['type' => 'surrender']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('type') === 'surrender' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-hand-heart mr-2"></i>
            Surrender Applications
          </a>
          <a href="{{ route('archives', ['type' => 'missing']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('type') === 'missing' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-magnifying-glass mr-2"></i>
            Missing Pet Reports
          </a>
          <a href="{{ route('archives', ['type' => 'abused']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('type') === 'abused' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-warning-circle mr-2"></i>
            Abuse/Stray Reports
          </a>
        </nav>
      </div>
    </div>

    @if($items->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
      <i class="ph-fill ph-archive text-6xl text-gray-300 mb-4"></i>
      <p class="text-lg text-gray-500">No archived items found in this category.</p>
    </div>
    @else
    <div class="space-y-6">
      @foreach($items as $item)
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
        <!-- Item Header -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 p-4 sm:p-6">
          <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
            @if($type === 'pets')
            <a href="{{ asset('storage/' . $item->image_path) }}" target="_blank"
              class="flex-shrink-0 w-20 h-20 sm:w-32 sm:h-32 bg-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow group mx-auto sm:mx-0">
              <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->pet_name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
            </a>
            @endif

            <div class="flex-1 min-w-0 w-full">
              <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-4">
                <div class="min-w-0 flex-1">
                  @if($type === 'pets')
                  <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                    {{ strtolower($item->pet_name) !== 'n/a' ? ucwords($item->pet_name) : 'Unnamed' }}
                    <span class="text-base sm:text-lg text-gray-500">#{{ $item->pet_number }}</span>
                  </h2>
                  <div class="flex flex-wrap gap-2 mb-3">
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      <i class="ph-fill ph-{{ $item->species === 'feline' ? 'cat' : 'dog' }} mr-1"></i>
                      {{ $item->species === 'feline' ? 'Cat' : 'Dog' }}
                    </span>
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      {{ ucfirst($item->sex) }}
                    </span>
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      {{ $item->formatted_age }} {{ $item->formatted_age == 1 ? Str::singular($item->age_unit) : Str::plural($item->age_unit) }}
                    </span>
                  </div>
                  @elseif($type === 'adoption')
                  <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                    {{ $item->transaction_number }}
                  </h2>
                  <div class="flex flex-wrap gap-2 mb-3">
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      <i class="ph-fill ph-user mr-1"></i>{{ $item->full_name }}
                    </span>
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      <i class="ph-fill ph-paw-print mr-1"></i>{{ $item->pet->pet_name }} #{{ $item->pet->pet_number }}
                    </span>
                  </div>
                  @elseif($type === 'surrender')
                  <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                    {{ $item->transaction_number }}
                  </h2>
                  <div class="flex flex-wrap gap-2 mb-3">
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      <i class="ph-fill ph-user mr-1"></i>{{ $item->full_name }}
                    </span>
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      <i class="ph-fill ph-paw-print mr-1"></i>{{ $item->pet_name }}
                    </span>
                  </div>
                  @else
                  <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                    {{ $item->report_number }}
                  </h2>
                  <div class="flex flex-wrap gap-2 mb-3">
                    <span class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700">
                      <i class="ph-fill ph-user mr-1"></i>{{ $item->full_name ?? 'Anonymous' }}
                    </span>
                  </div>
                  @endif

                  <div class="text-xs sm:text-sm text-gray-600">
                    <span><i class="ph-fill ph-calendar mr-1"></i>Archived: {{ \Carbon\Carbon::parse($item->updated_at)->format('M d, Y') }}</span>
                  </div>
                </div>

                <div class="flex gap-2">
                  <button onclick="openRestoreModal('{{ $type }}', '{{ $item->id }}')"
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm font-medium">
                    <i class="ph-fill ph-arrow-counter-clockwise mr-1"></i>Restore
                  </button>
                  @if($type !== 'adoption')
                  <button onclick="openDeleteModal('{{ $type }}', '{{ $item->id }}')"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium">
                    <i class="ph-fill ph-trash mr-1"></i>Delete
                  </button>
                  @endif
                </div>
              </div>

              <!-- Toggle Details Button -->
              <button onclick="toggleDetails('{{ $item->id }}')"
                class="w-full bg-white hover:bg-gray-50 border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-left transition-colors flex items-center justify-between group">
                <span class="font-medium text-sm sm:text-base text-gray-700 group-hover:text-gray-900 flex items-center gap-2 min-w-0 flex-1">
                  <i id="icon-{{ $item->id }}" class="ph-fill ph-caret-right text-gray-400 group-hover:text-blue-600 transition-transform duration-200 flex-shrink-0"></i>
                  <span class="truncate">View Details</span>
                </span>
              </button>
            </div>
          </div>
        </div>

        <!-- Details Section (Hidden by default) -->
        <div id="details-{{ $item->id }}" class="hidden border-t border-gray-200">
          <div class="p-6 bg-gray-50">
            @if($type === 'pets')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-600">Archive Reason</label>
                <p class="mt-1 text-sm text-gray-900">{{ $item->archive_reason === 'Other' ? $item->archive_notes : $item->archive_reason }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Color</label>
                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($item->color) }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Reproductive Status</label>
                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($item->reproductive_status) }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Source</label>
                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($item->source) }}</p>
              </div>
            </div>
            @elseif($type === 'adoption')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-600">Email</label>
                <p class="mt-1 text-sm text-gray-900">{{ $item->email }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Contact Number</label>
                <p class="mt-1 text-sm text-gray-900">{{ $item->contact_number }}</p>
              </div>
              <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-600">Reason for Adoption</label>
                <p class="mt-1 text-sm text-gray-900">{{ $item->reason_for_adoption }}</p>
              </div>
            </div>
            @elseif($type === 'surrender')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-600">Email</label>
                <p class="mt-1 text-sm text-gray-900">{{ $item->email }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Contact Number</label>
                <p class="mt-1 text-sm text-gray-900">{{ $item->contact_number }}</p>
              </div>
              <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-600">Reason for Surrender</label>
                <p class="mt-1 text-sm text-gray-900">{{ $item->reason }}</p>
              </div>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-sm font-medium text-gray-600">{{ $type === 'missing' ? 'Last Seen Date' : 'Incident Date' }}</label>
                <p class="mt-1 text-sm text-gray-900">{{ $type === 'missing' ? \Carbon\Carbon::parse($item->last_seen_date)->format('M d, Y') : \Carbon\Carbon::parse($item->incident_date)->format('M d, Y') }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Location</label>
                <p class="mt-1 text-sm text-gray-900">{{ $type === 'missing' ? $item->last_seen_location : $item->incident_location }}</p>
              </div>
              <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-600">Description</label>
                <p class="mt-1 text-sm text-gray-900">{{ $type === 'missing' ? $item->pet_description : $item->additional_notes }}</p>
              </div>
            </div>
            @endif
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

  <!-- Restore Modal -->
  <div id="restoreModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-xl font-semibold text-gray-900">Restore Item</h3>
            <p class="text-sm text-gray-600 mt-2">Are you sure you want to restore this item?</p>
          </div>
          <button onclick="closeRestoreModal()" class="text-gray-400 hover:text-gray-600">
            <i class="ph-fill ph-x text-2xl"></i>
          </button>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
          <p class="text-sm text-yellow-800">
            <i class="ph-fill ph-info mr-1"></i>
            This will restore the item to its previous status and make it visible again.
          </p>
        </div>

        <form id="restoreForm" method="POST" action="">
          @csrf
          @method('PATCH')
          <div class="flex gap-3">
            <button type="button" onclick="closeRestoreModal()"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              Cancel
            </button>
            <button type="submit"
              class="flex-1 bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-600 rounded-lg transition-colors">
              Restore Item
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-xl font-semibold text-gray-900">Delete Permanently</h3>
            <p class="text-sm text-gray-600 mt-2">Are you sure you want to permanently delete this item?</p>
          </div>
          <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
            <i class="ph-fill ph-x text-2xl"></i>
          </button>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
          <p class="text-sm text-red-800">
            <i class="ph-fill ph-warning mr-1"></i>
            This action cannot be undone. All data will be permanently removed.
          </p>
        </div>

        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              Cancel
            </button>
            <button type="submit"
              class="flex-1 bg-red-600 px-4 py-2 text-white hover:bg-red-700 rounded-lg transition-colors">
              Delete Permanently
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleDetails(id) {
      const details = document.getElementById('details-' + id);
      const icon = document.getElementById('icon-' + id);

      if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        icon.classList.add('rotate-90');
      } else {
        details.classList.add('hidden');
        icon.classList.remove('rotate-90');
      }
    }

    function openRestoreModal(type, id) {
      const modal = document.getElementById('restoreModal');
      const form = document.getElementById('restoreForm');
      form.action = `/admin/archives/${type}/${id}/restore`;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function closeRestoreModal() {
      const modal = document.getElementById('restoreModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = 'auto';
    }

    function openDeleteModal(type, id) {
      const modal = document.getElementById('deleteModal');
      const form = document.getElementById('deleteForm');
      form.action = `/admin/archives/${type}/${id}`;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
      const modal = document.getElementById('deleteModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = 'auto';
    }

    // Close modals when clicking outside
    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
      modal.addEventListener('click', function(e) {
        if (e.target === this) {
          if (this.id === 'restoreModal') closeRestoreModal();
          if (this.id === 'deleteModal') closeDeleteModal();
        }
      });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeRestoreModal();
        closeDeleteModal();
      }
    });
  </script>
</x-admin-layout>
