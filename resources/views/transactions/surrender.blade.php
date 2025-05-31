<x-transactions-layout>
  <h1 class="text-lg sm:text-2xl font-bold text-gray-900">Surrender Applications</h1>

  <!-- Filters Section -->
  <div class="flex flex-wrap gap-2 my-4">
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
    </form>
  </div>

  @if($applications->isEmpty())
  <div class="flex items-center justify-center p-6 text-gray-500">
    <p class="text-lg">No surrender applications found.</p>
  </div>
  @else
  <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mt-4">
    @foreach($applications as $application)
    <div
      class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-300 flex flex-col h-full overflow-x-auto scrollbar-hidden">
      <!-- Card Header -->
      <div class="p-3 border-b border-gray-200 flex items-start justify-between">
        <div class="flex items-center space-x-1">
          <div>
            <!-- Valid ID Photo -->
            <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-md overflow-hidden border border-gray-300">
              @if($application->valid_id_path)
              <button type="button" class="show-image-btn w-full h-full" data-image-title="Valid ID"
                data-image="{{ asset('storage/' . $application->valid_id_path) }}">
                <img src="{{ asset('storage/' . $application->valid_id_path) }}" alt="Owner's ID"
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
              {{ $application->full_name }}
            </p>
          </div>
        </div>

        @php
        $displayStatus = $application->status === 'archived' ? $application->previous_status : $application->status;
        $statusClasses = match ($displayStatus) {
        'to be confirmed' => 'bg-orange-100 text-orange-600',
        'confirmed' => 'bg-blue-100 text-blue-700',
        'to be scheduled' => 'bg-yellow-100 text-yellow-700',
        'surrender on-going' => 'bg-indigo-100 text-indigo-700',
        'completed' => 'bg-green-100 text-green-700',
        'rejected' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
        };
        @endphp
      </div>

      <!-- Card Body -->
      <div class="p-3 flex-1">
        <!-- Basic Info -->
        <div class="grid grid-cols-2 gap-2 text-sm mb-2">
          <div>
            <p class="text-gray-500 font-medium">Pet Name</p>
            <p>{{ $application->pet_name ?? 'Unnamed' }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Species</p>
            <p>{{ $application->species === 'feline' ? 'Cat' : 'Dog' }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Breed</p>
            <p>{{ $application->breed ?? 'Unknown' }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Sex</p>
            <p>{{ $application->sex }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Surrender Date</p>
            <p>{{ $application->surrender_date ? $application->surrender_date->format('M d, Y') : 'Not set' }}</p>
          </div>
          <div>
            <p class="text-gray-500 font-medium">Date Applied</p>
            <p>{{ $application->created_at->format('M d, Y') }}</p>
          </div>
        </div>

        <!-- Collapsible Sections -->
        <div class="space-y-2">
          <!-- Owner Information -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-user-circle mr-2 text-sm"></i>
                Owner Information
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden text-sm text-gray-700 mt-1 px-1 space-y-1">
              <div><span class="font-medium">Name:</span> {{ $application->full_name }}</div>
              <div><span class="font-medium">Email:</span> {{ $application->email }}</div>
              <div><span class="font-medium">Age:</span> {{ $application->age }} years old</div>
              <div><span class="font-medium">Birthdate:</span> {{ $application->birthdate->format('M d, Y') }}</div>
              <div><span class="font-medium">Contact:</span> {{ $application->contact_number }}</div>
              <div><span class="font-medium">Address:</span> {{ $application->address }}</div>
              <div><span class="font-medium">Civil Status:</span> {{ $application->civil_status }}</div>
              <div><span class="font-medium">Citizenship:</span> {{ $application->citizenship }}</div>
            </div>
          </div>

          <!-- Reason for Surrender -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-note-pencil mr-2 text-sm"></i>
                Reason for Surrender
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden text-sm text-gray-700 mt-1 px-1">
              @if($application->reason)
              {{ Str::limit($application->reason, 100) }}
              @if(strlen($application->reason) > 100)
              <button data-title="Reason for Surrender"
                onclick="showTextModal(this, {{ json_encode($application->reason) }})"
                class="text-blue-500 hover:text-blue-700 text-xs ml-1">
                Read More
              </button>
              @endif
              @else
              No reason provided
              @endif
            </div>
          </div>

          <!-- Pet Photos -->
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-images mr-2 text-sm"></i>
                Pet Photos ({{ count(json_decode($application->animal_photos)) }})
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden mt-2">
              <div class="flex flex-wrap gap-1">
                @foreach(json_decode($application->animal_photos) as $photo)
                <button type="button" class="show-image-btn" data-image-title="Pet Photo"
                  data-image="{{ asset('storage/' . $photo) }}">
                  <img src="{{ asset('storage/' . $photo) }}" alt="Pet photo"
                    class="w-12 h-12 object-cover rounded border border-gray-300 hover:border-blue-500">
                </button>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Reject Reason (if rejected) -->
          @if($application->status === 'rejected' && $application->reject_reason)
          <div>
            <button
              class="toggle-section-btn w-full text-left flex items-center justify-between text-sm text-gray-500 hover:text-gray-700 py-1">
              <span class="flex items-center">
                <i class="ph-fill ph-warning-circle mr-2 text-sm"></i>
                Rejection Reason
              </span>
              <i class="ph-fill ph-caret-down text-sm"></i>
            </button>
            <div class="hidden text-sm text-gray-700 mt-1 px-1">
              {{ $application->reject_reason }}
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Card Footer -->
      <div class="p-2 border-t border-gray-200 bg-gray-50 rounded-b-lg flex justify-between items-center">
        <span class="flex items-center text-[10px] text-gray-500">
          <i class="ph-fill ph-clock mr-1"></i> {{ $application->created_at->diffForHumans() }}
        </span>

        <!-- Status Badge -->
        <span class="px-2 py-1 text-[10px] rounded {{ $statusClasses }}">
          @switch($displayStatus)
          @case('to be confirmed') Waiting Confirmation @break
          @case('completed') Completed @break
          @default {{ ucfirst($displayStatus) }}
          @endswitch
        </span>

        <!-- Action Buttons -->
        <div class="relative inline-block text-left">
          <div>
            <button type="button"
              class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-2 py-1 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
              id="options-menu-{{ $application->id }}" aria-expanded="true" aria-haspopup="true"
              onclick="toggleDropdownMenu('{{ $application->id }}')">
              Actions
              <svg class="-mr-1 ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </button>
          </div>

          <!-- Dropdown menu -->
          <div
            class="origin-bottom-right absolute right-0 bottom-full mb-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50"
            id="dropdown-{{ $application->id }}">
            <div class="py-1" role="menu" aria-orientation="vertical"
              aria-labelledby="options-menu-{{ $application->id }}">

              @if($application->status === 'to be scheduled')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900"
                role="menuitem" onclick="openScheduleModal({{ $application->id }})">
                <i class="ph-fill ph-calendar mr-2"></i> Schedule Surrender
              </button>
              @endif

              @if($application->status === 'surrender on-going')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900"
                role="menuitem"
                onclick="openSurrenderModal('{{ \Carbon\Carbon::parse($application->surrender_date)->format('M d, Y') }}')">
                <i class="ph-fill ph-calendar-check mr-2"></i> View Schedule
              </button>
              @endif

              @if($application->status === 'to be confirmed')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-orange-700 hover:bg-orange-100 hover:text-orange-900"
                role="menuitem" onclick="openResendModal({{ $application->id }})">
                <i class="ph-fill ph-envelope-simple-open mr-2"></i> Resend Confirmation
              </button>
              @endif

              @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled', 'surrender
              on-going']))
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                role="menuitem" onclick="openCancelModal({{ $application->id }})">
                <i class="ph-fill ph-x-circle mr-2"></i> Cancel Application
              </button>
              @endif

              @if($application->status === 'rejected')
              <button type="button"
                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900"
                role="menuitem" onclick="openCancelModal({{ $application->id }})">
                <i class="ph-fill ph-trash mr-2"></i> Delete Application
              </button>
              @endif

              @if($application->status === 'completed' || $application->status === 'archived')
              <div class="block w-full text-left px-4 py-2 text-sm text-gray-500 italic">
                <i class="ph-fill ph-check-circle mr-2"></i> Surrender Completed
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $applications->appends(request()->except('page'))->links() }}
  </div>
  @endif

  <!-- Cancel Confirmation Modal -->
  <div id="cancelModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Action</h2>
      <p class="text-sm text-gray-600">Are you sure you want to cancel this surrender request?</p>

      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="deleteForm" method="POST" action="{{ url('/transactions/surrender-status/' . $application->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-400 text-white rounded-lg">Confirm</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Schedule Surrender Modal -->
  <div id="scheduleModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-100">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Select Surrender Date</h2>
      <p class="text-sm text-gray-600 mb-4">Please select a weekday (Monday-Friday) within the next 7 business days.</p>

      <form id="scheduleForm" method="POST" action="{{ url('/transactions/schedule-surrender') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="application_id" id="scheduleAppId">

        <input type="date" name="surrender_date" id="surrenderDateInput" class="w-full border px-3 py-2 rounded"
          required min="" max="">

        <div class="mt-4 flex justify-end gap-2">
          <button type="button" onclick="closeScheduleModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Surrender Date Modal -->
  <div id="surrenderModal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-1">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full space-y-4 relative">
      <!-- Close Button -->
      <button id="closeSurrenderModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold">Scheduled Surrender Date</h2>
      <p id="surrenderDateText" class="text-lg font-medium text-gray-700"></p>
      <p class="text-sm text-gray-600">Failure to visit after 3 business days from your scheduled date will cancel the
        surrender.</p>
    </div>
  </div>

  <!-- Resend Confirmation Modal -->
  <div id="resendModal"
    class="fixed inset-0 px-1 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Resend</h2>
      <p class="text-sm text-gray-600">Are you sure you want to resend the confirmation email?</p>
      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeResendModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="resendForm" method="POST" action="">
          @csrf
          <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-400">Resend</button>
        </form>
      </div>
    </div>
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

  <!-- Text Modal -->
  <div id="textModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-lg w-full max-h-[90vh] overflow-auto">
      <button onclick="closeTextModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10">
        <i class="ph-fill ph-x"></i>
      </button>
      <h2 class="text-md font-semibold text-gray-800" id="textTitle"></h2>
      <div class="w-full mt-2 text-gray-700 whitespace-pre-wrap break-words" id="textModalContent"></div>
    </div>
  </div>

  <script>
    // Improved toggle function for upward dropdown
    function toggleDropdownMenu(id) {
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

    // Text modal
    function showTextModal(el, text) {
      document.getElementById('textTitle').textContent = el.dataset.title;
      document.getElementById('textModalContent').textContent = text;
      document.getElementById('textModal').classList.remove('hidden');
    }

    function closeTextModal() {
      document.getElementById('textModal').classList.add('hidden');
    }

    // Close image modal
    document.getElementById('closeImageModal').addEventListener('click', function() {
      document.getElementById('imageModal').classList.add('hidden');
    });

    function openScheduleModal(appId) {
      document.getElementById('scheduleModal').classList.remove('hidden');
      document.getElementById('scheduleAppId').value = appId;

      const formAction = `/transactions/schedule-surrender/${appId}`;
      document.getElementById('scheduleForm').action = formAction;

      const allowedDates = getNext7BusinessDays();
      const input = document.getElementById('surrenderDateInput');
      
      input.min = allowedDates[0];
      input.max = allowedDates[allowedDates.length - 1];
      input.value = '';
      
      input.addEventListener('input', function() {
        const selectedDate = new Date(this.value);
        if (isWeekend(selectedDate)) {
          alert('Weekends are not allowed. Please select a weekday (Monday-Friday).');
          this.value = '';
        }
      });
    }

    function isWeekend(date) {
      const day = date.getDay();
      return (day === 0 || day === 6);
    }

    function getNext7BusinessDays() {
      const days = [];
      let date = new Date();
      let daysAdded = 0;
      
      while (daysAdded < 7) {
        if (!isWeekend(date)) {
          days.push(formatDate(date));
          daysAdded++;
        }
        date.setDate(date.getDate() + 1);
      }
      
      return days;
    }

    function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }

    function closeScheduleModal() {
      document.getElementById('scheduleModal').classList.add('hidden');
    }

    function openSurrenderModal(surrenderDate) {
      document.getElementById('surrenderModal').classList.remove('hidden');
      document.getElementById('surrenderDateText').innerText = `Your scheduled surrender date is: ${surrenderDate}`;
    }

    document.getElementById('closeSurrenderModalBtn').addEventListener('click', function () {
      closeSurrenderModal();
    });

    function closeSurrenderModal() {
      document.getElementById('surrenderModal').classList.add('hidden');
    }

    function openCancelModal(appId) {
      document.getElementById('cancelModal').classList.remove('hidden');
      document.getElementById('deleteForm').action = `/transactions/surrender-status/${appId}`;
    }

    function closeCancelModal() {
      document.getElementById('cancelModal').classList.add('hidden');
    }

    function openResendModal(appId) {
      document.getElementById('resendModal').classList.remove('hidden');
      document.getElementById('resendForm').action = `/transactions/${appId}/resend-surrender-email`;
    }

    function closeResendModal() {
      document.getElementById('resendModal').classList.add('hidden');
    }
  </script>
</x-transactions-layout>