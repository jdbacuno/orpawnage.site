<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Surrender Applications</h1>

  <div class="mt-4">
    {{-- Filter Section --}}
    <div class="flex flex-wrap gap-2 mb-4">
      <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4">
        <!-- Status Filter -->
        <select name="status"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[180px]"
          onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="to be confirmed" {{ request('status')==='to be confirmed' ? 'selected' : '' }}>
            Waiting Confirmation
          </option>
          <option value="confirmed" {{ request('status')==='confirmed' ? 'selected' : '' }}>
            Confirmed
          </option>
          <option value="to be scheduled" {{ request('status')==='to be scheduled' ? 'selected' : '' }}>
            To Be Scheduled
          </option>
          <option value="surrender on-going" {{ request('status')==='surrender on-going' ? 'selected' : '' }}>
            Surrender On-going
          </option>
          <option value="completed" {{ request('status')==='completed' ? 'selected' : '' }}>
            Completed
          </option>
          <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>
            Rejected
          </option>
        </select>

        <select name="direction"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
          onchange="this.form.submit()">
          <option value="desc" {{ request('direction', 'desc' )==='desc' ? 'selected' : '' }}>
            Newest First
          </option>
          <option value="asc" {{ request('direction')==='asc' ? 'selected' : '' }}>
            Oldest First
          </option>
        </select>
      </form>
    </div>

    @if($surrenderApplications->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No surrender applications found.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mt-4">
      @foreach($surrenderApplications as $application)
      <div
        class="bg-white rounded-lg shadow-md border border-gray-200 overflow-auto scrollbar-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
        <!-- Card Header -->
        <div class="p-3 border-b border-gray-200 flex items-start justify-between">
          <div class="flex items-center space-x-1">
            <div>
              <!-- Valid ID Photo -->
              <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-md overflow-hidden border border-gray-300">
                @if($application->valid_id_path)
                <button type="button" class="show-image-btn w-full h-full" data-image-title="Valid ID"
                  data-image="{{ asset('storage/' . $application->valid_id_path) }}">
                  <img src="{{ asset('storage/' . $application->valid_id_path) }}" alt="Applicant's ID"
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
                <i class="ph-fill ph-tag mr-1 text-sm"></i> {{ $application->transaction_number }}
              </h3>
              <p class="text-sm text-gray-500 truncate max-w-[120px]">
                {{ $application->pet_name ?: 'Unnamed' }}
              </p>
            </div>
          </div>
        </div>

        <!-- Card Body -->
        <div class="p-3 flex-1">
          <!-- Basic Info -->
          <div class="grid grid-cols-2 gap-2 text-sm mb-2">
            <div>
              <p class="text-gray-500 font-medium">Species</p>
              <p>{{ $application->species == 'feline' ? 'Cat' : 'Dog' }}</p>
            </div>
            <div>
              <p class="text-gray-500 font-medium">Breed</p>
              <p>{{ $application->breed ?: 'Unknown' }}</p>
            </div>
            <div>
              <p class="text-gray-500 font-medium">Sex</p>
              <p>{{ $application->sex }}</p>
            </div>
            <div>
              <p class="text-gray-500 font-medium">Status</p>
              <span class="px-1 py-0.5 text-xs rounded 
                {{ $application->status === 'to be confirmed' ? 'bg-orange-100 text-orange-700' : '' }}
                {{ $application->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $application->status === 'surrender on-going' ? 'bg-indigo-100 text-indigo-700' : '' }}
                {{ $application->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                @switch($application->status)
                @case('to be confirmed') Waiting @break
                @case('confirmed') Confirmed @break
                @case('to be scheduled') To Schedule @break
                @case('surrender on-going') On-going @break
                @case('completed') Completed @break
                @case('rejected') Rejected @break
                @endswitch
              </span>
            </div>
          </div>

          <!-- Collapsible Sections -->
          <div class="space-y-2">
            <!-- Owner Information -->
            <div>
              <button
                class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
                <span class="flex items-center">
                  <i class="ph-fill ph-user mr-2 text-sm"></i>
                  Owner Information
                </span>
                <i class="ph-fill ph-caret-down text-sm"></i>
              </button>
              <div class="hidden text-sm text-gray-700 mt-1 px-1 space-y-1">
                <p><span class="font-medium">Name:</span> {{ $application->full_name }}</p>
                <p><span class="font-medium">Contact:</span> {{ $application->contact_number }}</p>
                <p><span class="font-medium">Email:</span> {{ $application->email }}</p>
              </div>
            </div>

            <!-- Reason for Surrender -->
            <div>
              <button
                class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
                <span class="flex items-center">
                  <i class="ph-fill ph-note-pencil mr-2 text-sm"></i>
                  Surrender Reason
                </span>
                <i class="ph-fill ph-caret-down text-sm"></i>
              </button>
              <div class="hidden text-sm text-gray-700 mt-1 px-1">
                @if($application->reason)
                {{ Str::limit($application->reason, 20) }}
                @if(strlen($application->reason) > 20)
                <button data-title="Additional Info"
                  onclick="showTextModal(this, {{ json_encode($application->reason) }})"
                  class="text-blue-500 hover:text-blue-700 text-xs ml-1">
                  Read More
                </button>
                @endif
                @else
                No notes provided
                @endif
              </div>
            </div>

            <!-- Animal Photos -->
            <div>
              <button
                class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
                <span class="flex items-center">
                  <i class="ph-fill ph-images mr-2 text-sm"></i>
                  Animal Photos ({{ count(json_decode($application->animal_photos ?? '[]')) }})
                </span>
                <i class="ph-fill ph-caret-down text-sm"></i>
              </button>
              <div class="hidden mt-2">
                <div class="flex flex-wrap gap-1">
                  @if($application->animal_photos)
                  @foreach(json_decode($application->animal_photos) as $photo)
                  <button type="button" class="show-image-btn" data-image-title="Animal Photo"
                    data-image="{{ asset('storage/' . $photo) }}">
                    <img src="{{ asset('storage/' . $photo) }}" alt="Animal photo"
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
          <div class="flex justify-between items-center text-xs text-gray-500">
            <div>
              {{ $application->created_at->format('M d, Y') }}
            </div>
            <div class="relative inline-block text-left">
              <div>
                <button type="button"
                  class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                  id="options-menu-{{ $application->id }}" aria-expanded="true" aria-haspopup="true"
                  onclick="toggleDropdown('{{ $application->id }}')">
                  Actions
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
                id="dropdown-{{ $application->id }}">
                <div class="py-1" role="menu" aria-orientation="vertical"
                  aria-labelledby="options-menu-{{ $application->id }}">

                  @if($application->status === 'confirmed')
                  <button type="button"
                    class="block w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-100 hover:text-blue-900"
                    role="menuitem" data-action="move-to-schedule" data-id="{{ $application->id }}">
                    <i class="ph-fill ph-calendar-plus mr-2"></i> Move to Scheduling
                  </button>
                  @endif

                  @if($application->status === 'to be scheduled')
                  <button type="button"
                    class="block w-full text-left px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900"
                    role="menuitem" onclick="showScheduleModal('{{ $application->id }}')">
                    <i class="ph-fill ph-calendar-check mr-2"></i> Schedule Surrender
                  </button>
                  @endif

                  @if($application->status === 'surrender on-going')
                  <button type="button"
                    class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900"
                    role="menuitem" onclick="showCompleteModal('{{ $application->id }}')">
                    <i class="ph-fill ph-check-circle mr-2"></i> Mark as Completed
                  </button>
                  @endif

                  @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled', 'surrender
                  on-going']))
                  <button type="button"
                    class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                    role="menuitem" onclick="showRejectModal('{{ $application->id }}')">
                    <i class="ph-fill ph-x-circle mr-2"></i> Reject Application
                  </button>
                  @endif

                  @if($application->status === 'completed' || $application->status === 'rejected')
                  <button type="button"
                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem" onclick="showArchiveModal('{{ $application->id }}')">
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

    <!-- Pagination -->
    <div class="mt-6">
      {{ $surrenderApplications->links() }}
    </div>
    @endif
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

  <!-- Valid ID Modal -->
  <div id="validIdModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative w-auto max-h-[90vh] overflow-auto">
      <button id="closeValidIdModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800">Owner's Valid ID</h2>
      <div class="w-full mt-2 flex justify-center items-center">
        <img id="validIdImage" alt="Valid ID" class="max-h-[70vh] max-w-full object-contain rounded-lg shadow-md">
      </div>
    </div>
  </div>

  <!-- Complete Surrender Modal -->
  <div id="completeModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeCompleteModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Confirm Surrender Completion</h2>
      <p class="mb-4">Are you sure you want to mark this surrender as completed?</p>
      <p class="mb-4 text-green-500 text-sm">This will:
      <ul class="list-disc pl-5 text-sm">
        <li>Update the application status to completed</li>
        <li>Send a confirmation email to the owner</li>
      </ul>
      </p>

      <form id="completeForm" method="POST" action="/admin/surrender-applications/completed">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="completeApplicationId">

        <div class="flex justify-end space-x-3 mt-4">
          <button type="button" id="cancelComplete"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-green-500 px-4 py-2 text-white hover:bg-green-400 rounded-md">
            Confirm Completion
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Reject Modal -->
  <div id="rejectModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeRejectModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Reject Surrender</h2>
      <p class="mb-2">Please provide a reason for rejecting this application:</p>
      <p class="my-2 text-red-500 text-sm">This will send an email notification to the user.</p>

      <form id="rejectForm" method="POST" action="/admin/surrender-applications/reject">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="rejectApplicationId">

        <label for="rejectReason" class="block font-medium text-gray-700">Reason:</label>
        <textarea id="rejectReason" name="reject_reason" class="w-full border p-2 rounded-md mb-4" required></textarea>
        <x-form-error name="reject_reason" />

        <button type="submit" class="bg-red-500 px-4 py-2 text-white hover:bg-red-400 rounded-md w-full">
          Reject Application
        </button>
      </form>
    </div>
  </div>

  <!-- Schedule Surrender Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeScheduleModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Schedule Surrender</h2>
      <p class="mb-4">Please select a date for the surrender:</p>
      <p class="mb-4 text-blue-500 text-sm">Note: Date must be a weekday within 7 business days.</p>

      <form id="scheduleForm" method="POST" action="/transactions/schedule-surrender/{{ $application->id ?? '' }}">
        @csrf
        <input type="hidden" name="application_id" id="scheduleApplicationId">

        <div class="mb-4">
          <label for="surrenderDate" class="block text-sm font-medium text-gray-700 mb-1">Surrender Date</label>
          <input type="date" id="surrenderDate" name="surrender_date" required
            class="w-full border border-gray-300 rounded-md p-2" min="{{ now()->format('Y-m-d') }}"
            max="{{ now()->addDays(10)->format('Y-m-d') }}">
          <x-form-error name="surrender_date" />
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" id="cancelSchedule"
            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 rounded-md">
            Schedule
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

      <h2 class="text-xl font-semibold text-gray-800 flex items-center"> <i class="ph-fill ph-archive mr-2"></i>Confirm
        Archive</h2>
      <p class="mb-4">Are you sure you want to archive this surrender application?</p>
      <p class="mb-4 text-gray-500 text-sm">Archived applications will be moved to a separate section and won't appear
        in the main list.</p>

      <form id="archiveForm" method="POST" action="{{ route('admin.surrender-applications.archive') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="archiveApplicationId">

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

  <!-- Text modal -->
  <div id="textModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-lg w-full max-h-[90vh] overflow-auto">
      <button onclick="closeTextModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800" id="textTitle">Last Seen Location</h2>
      <div class="w-full mt-2 text-gray-700 whitespace-pre-wrap break-words" id="textModalContent"></div>
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

    // Valid ID modal
    function showValidIdModal(imageUrl) {
      document.getElementById('validIdImage').src = imageUrl;
      document.getElementById('validIdModal').classList.remove('hidden');
    }

    document.getElementById('closeValidIdModal').addEventListener('click', function() {
      document.getElementById('validIdModal').classList.add('hidden');
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

    // Show complete modal
    function showCompleteModal(id) {
      document.getElementById('completeApplicationId').value = id;
      document.getElementById('completeModal').classList.remove('hidden');
    }

    // Close complete modal
    document.getElementById('closeCompleteModal').addEventListener('click', function() {
      document.getElementById('completeModal').classList.add('hidden');
    });

    // Cancel complete
    document.getElementById('cancelComplete').addEventListener('click', function() {
      document.getElementById('completeModal').classList.add('hidden');
    });

    // Show reject modal
    function showRejectModal(id) {
      document.getElementById('rejectApplicationId').value = id;
      document.getElementById('rejectModal').classList.remove('hidden');
    }

    document.getElementById('closeRejectModal').addEventListener('click', function() {
      document.getElementById('rejectModal').classList.add('hidden');
    });

    // Show schedule modal
    function showScheduleModal(id) {
      document.getElementById('scheduleApplicationId').value = id;
      document.getElementById('scheduleModal').classList.remove('hidden');
    }

    document.getElementById('closeScheduleModal').addEventListener('click', function() {
      document.getElementById('scheduleModal').classList.add('hidden');
    });

    document.getElementById('cancelSchedule').addEventListener('click', function() {
      document.getElementById('scheduleModal').classList.add('hidden');
    });

    // Show archive modal
    function showArchiveModal(id) {
      document.getElementById('archiveApplicationId').value = id;
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