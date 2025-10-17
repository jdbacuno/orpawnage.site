@php
$statusColors = [
'to be confirmed' => 'bg-orange-100 text-orange-700 border-orange-200',
'confirmed' => 'bg-blue-100 text-blue-700 border-blue-200',
'to be scheduled' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
'adoption on-going' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
'picked up' => 'bg-green-100 text-green-700 border-green-200',
'rejected' => 'bg-red-100 text-red-700 border-red-200',
];

$statusLabels = [
'to be confirmed' => 'Waiting Confirmation',
'confirmed' => 'Confirmed',
'to be scheduled' => 'To Be Scheduled',
'adoption on-going' => 'On-going',
'picked up' => 'Adopted',
'rejected' => 'Rejected',
];

$isAngelesResident = stripos($application->address, 'angeles') !== false;
@endphp

<div class="hover:bg-gray-50 transition-colors {{ $isPriority && $isAngelesResident ? 'bg-blue-50/30' : '' }}">
  <!-- Main Row -->
  <div class="px-4 sm:px-6 py-4">
    <div class="flex flex-col sm:flex-row items-start gap-4">
      <!-- Applicant Info -->
      <div class="flex-1 min-w-0 w-full">
        <div class="flex flex-col gap-3 mb-2">
          <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
            <div class="flex-1 min-w-0">
              <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-2">
                <button onclick="toggleDetails('{{ $application->id }}')"
                  class="flex items-center gap-2 hover:text-blue-600 transition-colors group text-left">
                  <i id="icon-{{ $application->id }}"
                    class="ph-fill ph-caret-right text-gray-400 group-hover:text-blue-600 transition-transform duration-200 flex-shrink-0"></i>
                  <h4 class="text-base sm:text-lg font-semibold text-gray-900 group-hover:text-blue-600 break-words">
                    {{ $application->full_name }}
                  </h4>
                </button>

                <div class="flex flex-wrap items-center gap-2">
                  <span class="px-2 py-1 bg-gray-100 border border-gray-300 rounded text-xs font-mono text-gray-700 whitespace-nowrap">
                    {{ $application->transaction_number }}
                  </span>

                  @if($isPriority && $isAngelesResident)
                  <span class="px-2 py-0.5 bg-blue-600 text-white text-xs rounded-full font-medium whitespace-nowrap">
                    <i class="ph-fill ph-star text-xs"></i> Priority
                  </span>
                  @endif
                </div>
              </div>

              <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2 sm:gap-x-4 sm:gap-y-1 text-xs sm:text-sm text-gray-600">
                <span class="flex items-center gap-1 min-w-0">
                  <i class="ph-fill ph-envelope flex-shrink-0"></i>
                  <span class="truncate">{{ $application->email }}</span>
                </span>
                <span class="flex items-center gap-1 whitespace-nowrap">
                  <i class="ph-fill ph-phone flex-shrink-0"></i>
                  {{ $application->contact_number }}
                </span>
                <span class="flex items-center gap-1 whitespace-nowrap">
                  <i class="ph-fill ph-calendar flex-shrink-0"></i>
                  Applied {{ $application->created_at->format('M d, Y') }}
                </span>
              </div>
            </div>

            <!-- Status Badge -->
            <span
              class="px-3 py-1 rounded-lg text-xs sm:text-sm font-medium border whitespace-nowrap w-fit {{ $statusColors[$application->status] ?? 'bg-gray-100 text-gray-700' }}">
              {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
            </span>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-2 mt-3">
          @if($application->status === 'confirmed')
          <button onclick="openModal('moveToScheduleModal', '{{ $application->id }}')"
            class="flex-1 sm:flex-none px-3 py-1.5 bg-blue-600 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-1 whitespace-nowrap">
            <i class="ph-fill ph-calendar-plus flex-shrink-0"></i>
            <span class="hidden sm:inline">Move to Scheduling</span>
            <span class="sm:hidden">Schedule</span>
          </button>
          @endif

          @if($application->status === 'adoption on-going')
          <button onclick="openModal('markAdoptedModal', '{{ $application->id }}')"
            class="flex-1 sm:flex-none px-3 py-1.5 bg-green-600 text-white text-xs sm:text-sm rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-1 whitespace-nowrap">
            <i class="ph-fill ph-check-circle flex-shrink-0"></i>
            <span class="hidden sm:inline">Mark as Adopted</span>
            <span class="sm:hidden">Adopted</span>
          </button>
          @endif

          @if(in_array($application->status, ['to be confirmed', 'confirmed', 'to be scheduled', 'adoption on-going']))
          <button onclick="openModal('rejectModal', '{{ $application->id }}')"
            class="flex-1 sm:flex-none px-3 py-1.5 bg-red-600 text-white text-xs sm:text-sm rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center gap-1 whitespace-nowrap">
            <i class="ph-fill ph-x-circle flex-shrink-0"></i>
            Reject
          </button>
          @endif

          @if(in_array($application->status, ['picked up', 'rejected']))
          <button onclick="openModal('archiveModal', '{{ $application->id }}')"
            class="flex-1 sm:flex-none px-3 py-1.5 bg-gray-600 text-white text-xs sm:text-sm rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center gap-1 whitespace-nowrap">
            <i class="ph-fill ph-archive flex-shrink-0"></i>
            Archive
          </button>
          @endif

          <button onclick="toggleDetails('{{ $application->id }}')"
            class="flex-1 sm:flex-none px-3 py-1.5 bg-gray-100 text-gray-700 text-xs sm:text-sm rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center gap-1 whitespace-nowrap">
            <i class="ph-fill ph-info flex-shrink-0"></i>
            <span class="hidden sm:inline">View Details</span>
            <span class="sm:hidden">Details</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Expandable Details -->
    <div id="details-{{ $application->id }}" class="hidden mt-4 pt-4 border-t border-gray-200">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Personal Information -->
        <div class="space-y-3">
          <h5 class="font-semibold text-sm sm:text-base text-gray-900 flex items-center gap-2 mb-3">
            <i class="ph-fill ph-user-circle text-blue-600"></i>
            Personal Information
          </h5>
          <div class="space-y-2 text-xs sm:text-sm">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
              <span class="text-gray-500">Age:</span>
              <span class="text-gray-900 font-medium">{{ $application->age }} years</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
              <span class="text-gray-500">Birthdate:</span>
              <span class="text-gray-900 font-medium">{{ $application->birthdate->format('M d, Y') }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
              <span class="text-gray-500">Civil Status:</span>
              <span class="text-gray-900 font-medium">{{ $application->civil_status }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
              <span class="text-gray-500">Citizenship:</span>
              <span class="text-gray-900 font-medium">{{ $application->citizenship }}</span>
            </div>
            <div class="flex flex-col gap-1">
              <span class="text-gray-500">Address:</span>
              <span class="text-gray-900 font-medium break-words">{{ $application->address }}</span>
              @if($isAngelesResident)
              <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded w-fit">Angeles City</span>
              @endif
            </div>
          </div>
        </div>

        <!-- Pet Care Information -->
        <div class="space-y-3">
          <h5 class="font-semibold text-sm sm:text-base text-gray-900 flex items-center gap-2 mb-3">
            <i class="ph-fill ph-paw-print text-blue-600"></i>
            Pet Care Experience
          </h5>
          <div class="space-y-2 text-xs sm:text-sm">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
              <span class="text-gray-500">Visits Veterinarian:</span>
              <span class="text-gray-900 font-medium">{{ $application->visit_veterinarian }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
              <span class="text-gray-500">Existing Pets:</span>
              <span class="text-gray-900 font-medium">{{ $application->existing_pets }}</span>
            </div>
            <div class="pt-2">
              <span class="text-gray-500 block mb-1">Reason for Adoption:</span>
              <p class="text-gray-900 text-xs sm:text-sm bg-gray-50 p-3 rounded border border-gray-200 whitespace-pre-line break-words">{{
                $application->reason_for_adoption }}</p>
            </div>
          </div>
        </div>

        <!-- Documents & Status -->
        <div class="space-y-3">
          <h5 class="font-semibold text-sm sm:text-base text-gray-900 flex items-center gap-2 mb-3">
            <i class="ph-fill ph-file-text text-blue-600"></i>
            Documents & Status
          </h5>
          <div class="space-y-2 text-xs sm:text-sm">
            <div>
              <a href="{{ asset('storage/' . $application->valid_id) }}" target="_blank"
                class="text-blue-600 hover:text-blue-700 underline flex items-center gap-1 break-words">
                <i class="ph-fill ph-image flex-shrink-0"></i>
                <span>View Valid ID (Opens in new tab)</span>
              </a>
            </div>
            @if($application->pickup_date)
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
              <span class="text-gray-500">Pickup Date:</span>
              <span class="text-gray-900 font-medium">{{ $application->pickup_date->format('M d, Y') }}</span>
            </div>
            @endif
            @if($application->reject_reason)
            <div class="pt-2">
              <span class="text-red-600 font-medium block mb-1">Rejection Reason:</span>
              <p class="text-gray-900 text-xs sm:text-sm bg-red-50 p-3 rounded border border-red-200 break-words">{{
                $application->reject_reason }}</p>
            </div>
            @endif
          </div>

          <!-- User Transaction History -->
          @if($application->user)
          <div class="pt-3 border-t border-gray-200">
            <h6 class="font-medium text-xs sm:text-sm text-gray-700 mb-2 flex items-center gap-1">
              <i class="ph-fill ph-clock-counter-clockwise flex-shrink-0"></i>
              Applicant History
            </h6>
            <div class="space-y-1 text-xs text-gray-600">
              <div class="flex justify-between gap-2">
                <span>Successful Adoptions:</span>
                <span class="font-medium">
                  {{ $application->user->adoptionApplications->filter(function($app) {
                  return $app->status === 'picked up' ||
                  ($app->status === 'archived' && $app->previous_status === 'picked up');
                  })->count() }}
                </span>
              </div>
              <div class="flex justify-between gap-2">
                <span>Successful Surrenders:</span>
                <span class="font-medium">
                  {{ $application->user->surrenderApplications->filter(function($app) {
                  return $app->status === 'completed' ||
                  ($app->status === 'archived' && $app->previous_status === 'completed');
                  })->count() }}
                </span>
              </div>
              <div class="flex justify-between gap-2">
                <span>Acknowledged Abuse Reports:</span>
                <span class="font-medium">
                  {{ $application->user->animalAbuseReports->filter(function($app) {
                  return $app->status === 'action taken' ||
                  ($app->status === 'archived' && $app->previous_status === 'action taken');
                  })->count() }}
                </span>
              </div>
              <div class="flex justify-between gap-2">
                <span>Posted Missing Pet Reports:</span>
                <span class="font-medium">
                  {{ $application->user->missingPetReports->filter(function($app) {
                  return $app->status === 'acknowledged' ||
                  ($app->status === 'archived' && $app->previous_status === 'acknowledged');
                  })->count() }}
                </span>
              </div>
              @if($application->user->adoptionApplications->count() > 0 ||
              $application->user->surrenderApplications->count() > 0 || $application->user->animalAbuseReports->count()
              > 0 || $application->user->missingPetReports->count() > 0)
              <a href="/admin/users?search={{ urlencode($application->user->email) }}" target="_blank"
                class="text-blue-600 hover:text-blue-700 underline block mt-2 break-words">
                View Full User Profile →
              </a>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
