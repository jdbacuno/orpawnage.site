<x-admin-layout>
  <div class="max-w-[1600px] mx-auto">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Manage Pet Adoption Applications</h1>
      <p class="text-sm text-gray-600 mt-1">Review and process adoption applications. Confirmed applications from
        Angeles City residents are prioritized.</p>
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

    <!-- Status Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
      <div class="border-b border-gray-200">
        <nav class="flex overflow-x-auto scrollbar-hidden" aria-label="Tabs">
          <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-files mr-2"></i>
            All Applications
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'to be confirmed']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'to be confirmed' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-clock mr-2"></i>
            Waiting Confirmation
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'confirmed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-check-circle mr-2"></i>
            Confirmed
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'to be scheduled']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'to be scheduled' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-calendar-dots mr-2"></i>
            To Be Scheduled
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'adoption on-going']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'adoption on-going' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-hourglass-medium mr-2"></i>
            On-going
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'picked up']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'picked up' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-check-square mr-2"></i>
            Adopted
          </a>
          <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}"
            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
              {{ request('status') === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <i class="ph-fill ph-x-circle mr-2"></i>
            Rejected
          </a>
        </nav>
      </div>

      <!-- Search and Sort -->
      <div class="p-4 bg-gray-50 border-b border-gray-200">
        <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4 items-center">
          <div class="flex-1 min-w-[250px]">
            <div class="relative">
              <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by transaction number, email, or name"
                class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 pl-10 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition" />
              <div class="absolute left-3 inset-y-0 flex items-center h-full pointer-events-none">
                <i class="ph-fill ph-magnifying-glass text-gray-500"></i>
              </div>
            </div>
          </div>

          <select name="direction"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
            onchange="this.form.submit()">
            <option value="desc" {{ request('direction', 'desc' )==='desc' ? 'selected' : '' }}>Newest First</option>
            <option value="asc" {{ request('direction')==='asc' ? 'selected' : '' }}>Oldest First</option>
          </select>

          <input type="hidden" name="status" value="{{ request('status') }}" />

          @if(request('search'))
          <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
            class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
            <i class="ph-fill ph-x mr-1"></i>Clear
          </a>
          @endif
        </form>
      </div>
    </div>

    @if($adoptionApplications->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
      <i class="ph-fill ph-file-search text-6xl text-gray-300 mb-4"></i>
      <p class="text-lg text-gray-500">No adoption applications found.</p>
    </div>
    @else

    <!-- Group applications by pet -->
    @php
    $groupedApplications = $adoptionApplications->groupBy('pet_id');
    @endphp

    @foreach($groupedApplications as $petId => $applications)
    @php
    $pet = $applications->first()->pet;
    $confirmedApps = $applications->where('status', 'confirmed')->sortByDesc(function($app) {
    return stripos($app->address, 'angeles') !== false ? 1 : 0;
    });
    $otherApps = $applications->whereNotIn('status', ['confirmed']);
    @endphp

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
      <!-- Pet Header -->
      <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
          <a href="{{ asset('storage/' . $pet->image_path) }}" target="_blank"
            class="flex-shrink-0 w-20 h-20 sm:w-32 sm:h-32 bg-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow group mx-auto sm:mx-0">
            <img src="{{ asset('storage/' . $pet->image_path) }}" alt="{{ $pet->pet_name }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
          </a>

          <div class="flex-1 min-w-0 w-full">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-4">
              <div class="min-w-0 flex-1">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 break-words">
                  {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
                  <span class="text-base sm:text-lg text-gray-500">#{{ $pet->pet_number }}</span>
                </h2>
                <div class="flex flex-wrap gap-2 mb-3">
                  <span
                    class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                    <i class="ph-fill ph-{{ $pet->species === 'feline' ? 'cat' : 'dog' }} mr-1"></i>
                    {{ $pet->species === 'feline' ? 'Cat' : 'Dog' }}
                  </span>
                  <span
                    class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                    {{ ucfirst($pet->sex) }}
                  </span>
                  <span
                    class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                    {{ $pet->formatted_age }} {{ $pet->formatted_age == 1 ? Str::singular($pet->age_unit) :
                    Str::plural($pet->age_unit) }}
                  </span>
                  <span
                    class="px-2 sm:px-3 py-1 bg-white border border-gray-300 rounded-full text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                    {{ ucfirst($pet->color) }}
                  </span>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                  <span class="whitespace-nowrap"><i class="ph-fill ph-syringe mr-1"></i> {{
                    ucfirst($pet->reproductive_status) }}</span>
                  <span class="whitespace-nowrap"><i class="ph-fill ph-map-pin mr-1"></i> {{ ucfirst($pet->source)
                    }}</span>
                  @if($pet->breed)
                  <span class="flex items-center min-w-0">
                    <i class="ph-fill ph-paw-print mr-1 flex-shrink-0"></i>
                    <span class="truncate">{{ $pet->breed }}</span>
                  </span>
                  @endif
                </div>
              </div>

              <div class="text-center sm:text-right">
                <div class="text-xs sm:text-sm text-gray-500 mb-1">Total Applications</div>
                <div class="text-2xl sm:text-3xl font-bold text-indigo-600">{{ $applications->count() }}</div>
              </div>
            </div>

            <!-- Toggle Button -->
            <button onclick="togglePetApplications('{{ $pet->id }}')"
              class="w-full bg-white hover:bg-gray-50 border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-left transition-colors flex items-center justify-between group">
              <span
                class="font-medium text-sm sm:text-base text-gray-700 group-hover:text-gray-900 flex items-center gap-2 min-w-0 flex-1">
                <i id="pet-icon-{{ $pet->id }}"
                  class="ph-fill ph-caret-right text-gray-400 group-hover:text-blue-600 transition-transform duration-200 flex-shrink-0"></i>
                <span class="truncate">View All Applicants ({{ $applications->count() }})</span>
              </span>
              <span class="text-xs sm:text-sm text-gray-500 ml-2 flex-shrink-0">
                @if($confirmedApps->count() > 0)
                <span class="text-blue-600 font-medium whitespace-nowrap">{{ $confirmedApps->count() }} Confirmed</span>
                @endif
              </span>
            </button>
          </div>
        </div>
      </div>

      <!-- Applications List (Hidden by default) -->
      <div id="pet-applications-{{ $pet->id }}" class="divide-y divide-gray-200 hidden">
        <!-- Confirmed Applications (Priority) -->
        @if($confirmedApps->count() > 0)
        <div class="bg-blue-50 px-6 py-3 border-b-2 border-blue-200">
          <h3 class="font-semibold text-blue-900 flex items-center">
            <i class="ph-fill ph-check-circle mr-2"></i>
            Confirmed Applications ({{ $confirmedApps->count() }})
            <span class="ml-2 text-sm text-blue-700">— Priority for Angeles City residents</span>
          </h3>
        </div>

        @foreach($confirmedApps as $application)
        @include('admin.partials.application-row', ['application' => $application, 'isPriority' =>
        stripos($application->address, 'angeles') !== false])
        @endforeach
        @endif

        <!-- Other Applications -->
        @if($otherApps->count() > 0)
        <div class="bg-gray-50 px-6 py-3">
          <h3 class="font-semibold text-gray-700 flex items-center">
            <i class="ph-fill ph-files mr-2"></i>
            Other Applications ({{ $otherApps->count() }})
          </h3>
        </div>

        @foreach($otherApps as $application)
        @include('admin.partials.application-row', ['application' => $application, 'isPriority' => false])
        @endforeach
        @endif
      </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-6">
      {{ $adoptionApplications->links() }}
    </div>
    @endif
  </div>

  <!-- Move to Schedule Modal -->
  <div id="moveToScheduleModal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-xl font-semibold text-gray-900">Move to Scheduling</h3>
            <p class="text-sm text-gray-600 mt-2">This will set the status to <span class="font-medium">To be
                scheduled</span> and email the applicant with scheduling instructions.</p>
          </div>
          <button onclick="closeModal('moveToScheduleModal')" class="text-gray-400 hover:text-gray-600">
            <i class="ph-fill ph-x text-2xl"></i>
          </button>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
          <p class="text-sm text-yellow-800">
            <i class="ph-fill ph-warning mr-1"></i>
            Other confirmed applications for this pet will be automatically rejected.
          </p>
        </div>

        <form id="moveToScheduleForm" method="POST" action="{{ route('adoption-applications.move-to-schedule') }}">
          @csrf
          <input type="hidden" name="application_id" id="moveToScheduleId">
          <div class="flex gap-3">
            <button type="button" onclick="closeModal('moveToScheduleModal')"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              Cancel
            </button>
            <button type="submit"
              class="flex-1 bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition-colors">
              Confirm Move
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Mark as Adopted Modal -->
  <div id="markAdoptedModal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-xl font-semibold text-gray-900">Confirm Adoption Completion</h3>
            <p class="text-sm text-gray-600 mt-2">Are you sure you want to mark this adoption as completed?</p>
          </div>
          <button onclick="closeModal('markAdoptedModal')" class="text-gray-400 hover:text-gray-600">
            <i class="ph-fill ph-x text-2xl"></i>
          </button>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
          <p class="text-sm text-green-800 font-medium mb-2">This will:</p>
          <ul class="list-disc list-inside text-sm text-green-700 space-y-1">
            <li>Update the pet's status to adopted</li>
            <li>Send a congratulatory email to the adopter</li>
            <li>Notify other users that this pet has been adopted</li>
          </ul>
        </div>

        <form id="markAdoptedForm" method="POST" action="/admin/adoption-applications/pickedup">
          @csrf
          @method('PATCH')
          <input type="hidden" name="application_id" id="markAdoptedId">
          <div class="flex gap-3">
            <button type="button" onclick="closeModal('markAdoptedModal')"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              Cancel
            </button>
            <button type="submit"
              class="flex-1 bg-green-600 px-4 py-2 text-white hover:bg-green-700 rounded-lg transition-colors">
              Confirm Completion
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Reject Modal -->
  <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-xl font-semibold text-gray-900">Reject Application</h3>
            <p class="text-sm text-gray-600 mt-2">Please provide a reason for rejecting this application.</p>
          </div>
          <button onclick="closeModal('rejectModal')" class="text-gray-400 hover:text-gray-600">
            <i class="ph-fill ph-x text-2xl"></i>
          </button>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
          <p class="text-sm text-red-800">
            <i class="ph-fill ph-warning mr-1"></i>
            An email notification will be sent to the applicant.
          </p>
        </div>

        <form id="rejectForm" method="POST" action="/admin/adoption-applications/reject">
          @csrf
          @method('PATCH')
          <input type="hidden" name="application_id" id="rejectId">

          <div class="mb-4">
            <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-2">
              Rejection Reason <span class="text-red-600">*</span>
            </label>
            <textarea id="rejectReason" name="reject_reason" rows="4" required maxlength="500"
              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500"
              placeholder="Explain why this application is being rejected..."></textarea>
            <p class="text-xs text-gray-500 mt-1">Maximum 500 characters</p>
          </div>

          <div class="flex gap-3">
            <button type="button" onclick="closeModal('rejectModal')"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              Cancel
            </button>
            <button type="submit"
              class="flex-1 bg-red-600 px-4 py-2 text-white hover:bg-red-700 rounded-lg transition-colors">
              Reject Application
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Archive Modal -->
  <div id="archiveModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <h3 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
              <i class="ph-fill ph-archive"></i>
              Confirm Archive
            </h3>
            <p class="text-sm text-gray-600 mt-2">Are you sure you want to archive this adoption application?</p>
          </div>
          <button onclick="closeModal('archiveModal')" class="text-gray-400 hover:text-gray-600">
            <i class="ph-fill ph-x text-2xl"></i>
          </button>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-4">
          <p class="text-sm text-gray-700">
            Archived applications will be moved to a separate section and won't appear in the main list.
          </p>
        </div>

        <form id="archiveForm" method="POST" action="{{ route('admin.adoption-applications.archive') }}">
          @csrf
          @method('PATCH')
          <input type="hidden" name="application_id" id="archiveId">
          <div class="flex gap-3">
            <button type="button" onclick="closeModal('archiveModal')"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              Cancel
            </button>
            <button type="submit"
              class="flex-1 bg-gray-600 px-4 py-2 text-white hover:bg-gray-700 rounded-lg transition-colors flex items-center justify-center gap-2">
              <i class="ph-fill ph-archive"></i>
              Confirm Archive
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function togglePetApplications(petId) {
      const applications = document.getElementById('pet-applications-' + petId);
      const icon = document.getElementById('pet-icon-' + petId);

      if (applications.classList.contains('hidden')) {
        applications.classList.remove('hidden');
        icon.classList.remove('ph-caret-right');
        icon.classList.add('ph-caret-down');
      } else {
        applications.classList.add('hidden');
        icon.classList.remove('ph-caret-down');
        icon.classList.add('ph-caret-right');
      }
    }

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

    function openModal(modalId, applicationId) {
      const modal = document.getElementById(modalId);
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';

      // Set the application ID in the appropriate form
      if (modalId === 'moveToScheduleModal') {
        document.getElementById('moveToScheduleId').value = applicationId;
      } else if (modalId === 'markAdoptedModal') {
        document.getElementById('markAdoptedId').value = applicationId;
      } else if (modalId === 'rejectModal') {
        document.getElementById('rejectId').value = applicationId;
      } else if (modalId === 'archiveModal') {
        document.getElementById('archiveId').value = applicationId;
      }
    }

    function closeModal(modalId) {
      const modal = document.getElementById(modalId);
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = 'auto';

      // Clear form if it's reject modal
      if (modalId === 'rejectModal') {
        document.getElementById('rejectReason').value = '';
      }
    }

    // Close modal when clicking outside
    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
      modal.addEventListener('click', function(e) {
        if (e.target === this) {
          closeModal(this.id);
        }
      });
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
          if (!modal.classList.contains('hidden')) {
            closeModal(modal.id);
          }
        });
      }
    });
  </script>
</x-admin-layout>
