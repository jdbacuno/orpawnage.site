<div class="space-y-6">
  <!-- User Info Section -->
  <div class="flex items-start space-x-4">
    <div class="flex-shrink-0 h-16 w-16">
      <img class="h-16 w-16 rounded-full" src="{{ asset('images/profile_pic.png') }}" alt="Avatar">
    </div>
    <div class="flex-1">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">{{ $user->username ?? 'No Name' }}</h3>
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
          @if($user->is_banned) bg-red-100 text-red-800
          @elseif($user->is_temporarily_banned) bg-orange-100 text-orange-800
          @elseif($user->email_verified_at) bg-green-100 text-green-800
          @else bg-yellow-100 text-yellow-800 @endif">
          @if($user->is_banned) Banned
          @elseif($user->is_temporarily_banned) Temporarily Banned
          @elseif($user->email_verified_at) Active
          @else Unverified @endif
        </span>
      </div>
      <p class="text-sm text-gray-500">{{ $user->email }}</p>
      <p class="text-sm text-gray-500 mt-1">Joined: {{ $user->created_at->format('M d, Y') }}</p>

      @if($user->is_banned)
      <p class="text-sm text-red-600 mt-1">Ban Reason: {{ $user->ban_reason ?? 'No reason provided' }}</p>
      <p class="text-sm text-red-600">Banned On: {{ $user->banned_at->format('M d, Y') }}</p>
      @endif

      @if($user->is_temporarily_banned)
      <p class="text-sm text-orange-600 mt-1">Temporary Ban Reason: {{ $user->temporary_ban_reason ?? 'No reason provided' }}</p>
      <p class="text-sm text-orange-600">Temporarily Banned On: {{ $user->temporarily_banned_at->format('M d, Y') }}</p>
      <p class="text-sm text-orange-600">Expires On: {{ $user->temporary_ban_expires_at->format('M d, Y \a\t g:i A') }}</p>
      @endif
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="flex justify-end space-x-3 border-t border-b border-gray-200 py-4">
    @if($user->is_banned)
    <form method="POST" action="{{ route('admin.users.unban', $user) }}">
      @csrf
      @method('PATCH')
      <button type="submit" class="bg-green-500 px-4 py-2 text-white hover:bg-green-400 rounded-md">
        <i class="ph-fill ph-arrow-counter-clockwise mr-2"></i>Unban User
      </button>
    </form>
    @elseif($user->is_temporarily_banned)
    <form method="POST" action="{{ route('admin.users.unban', $user) }}">
      @csrf
      @method('PATCH')
      <button type="submit" class="bg-green-500 px-4 py-2 text-white hover:bg-green-400 rounded-md">
        <i class="ph-fill ph-arrow-counter-clockwise mr-2"></i>Lift Temporary Ban
      </button>
    </form>
    @elseif($user->email_verified_at)
    <div class="flex space-x-2">
      <button onclick="showBanModal('{{ $user->id }}')"
        class="bg-red-500 px-4 py-2 text-white hover:bg-red-400 rounded-md">
        <i class="ph-fill ph-prohibit mr-2"></i>Ban User
      </button>
      <button onclick="showTemporaryBanModal('{{ $user->id }}')"
        class="bg-orange-500 px-4 py-2 text-white hover:bg-orange-400 rounded-md">
        <i class="ph-fill ph-clock mr-2"></i>Temporary Ban
      </button>
    </div>
    @endif
  </div>

  <!-- User Activity Sections -->
  <div class="grid grid-cols-2 gap-4">
    <!-- Adoption Applications -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <h4 class="font-medium text-gray-900 mb-2">Adoption Applications</h4>
      @if($user->adoptionApplications->isEmpty())
      <p class="text-sm text-gray-500">No applications</p>
      @else
      <div class="text-sm">
        <div class="font-medium">{{ $user->adoptionApplications->first()->transaction_number }}</div>
        <div class="text-gray-500">{{ $user->adoptionApplications->first()->previous_status ?:
          $user->adoptionApplications->first()->status }}</div>
        <div class="text-xs text-gray-400">{{ $user->adoptionApplications->first()->created_at->format('M d, Y') }}
        </div>
      </div>
      <button onclick="showApplicationsModal('adoption', {{ json_encode($user->adoptionApplications) }})"
        class="text-blue-500 text-sm mt-2 inline-block">View all ({{ $user->adoptionApplications->count() }})</button>
      @endif
    </div>

    <!-- Surrender Applications -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <h4 class="font-medium text-gray-900 mb-2">Surrender Applications</h4>
      @if($user->surrenderApplications->isEmpty())
      <p class="text-sm text-gray-500">No applications</p>
      @else
      <div class="text-sm">
        <div class="font-medium">{{ $user->surrenderApplications->first()->transaction_number }}</div>
        <div class="text-gray-500">{{ $user->surrenderApplications->first()->previous_status ?:
          $user->surrenderApplications->first()->status }}</div>
        <div class="text-xs text-gray-400">{{ $user->surrenderApplications->first()->created_at->format('M d, Y') }}
        </div>
      </div>
      <button onclick="showApplicationsModal('surrender', {{ json_encode($user->surrenderApplications) }})"
        class="text-blue-500 text-sm mt-2 inline-block">View all ({{ $user->surrenderApplications->count() }})</button>
      @endif
    </div>

    <!-- Abuse Reports -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <h4 class="font-medium text-gray-900 mb-2">Abuse Reports</h4>
      @if($user->animalAbuseReports->isEmpty())
      <p class="text-sm text-gray-500">No reports</p>
      @else
      <div class="text-sm">
        <div class="font-medium">{{ $user->animalAbuseReports->first()->report_number }}</div>
        <div class="text-gray-500">{{ $user->animalAbuseReports->first()->previous_status ?:
          $user->animalAbuseReports->first()->previous_status }}</div>
        <div class="text-xs text-gray-400">{{ $user->animalAbuseReports->first()->created_at->format('M d, Y') }}</div>
      </div>
      <button onclick="showApplicationsModal('abuse', {{ json_encode($user->animalAbuseReports) }})"
        class="text-blue-500 text-sm mt-2 inline-block">View all ({{ $user->animalAbuseReports->count() }})</button>
      @endif
    </div>

    <!-- Missing Pet Reports -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <h4 class="font-medium text-gray-900 mb-2">Missing Pet Reports</h4>
      @if($user->missingPetReports->isEmpty())
      <p class="text-sm text-gray-500">No reports</p>
      @else
      <div class="text-sm">
        <div class="font-medium">{{ $user->missingPetReports->first()->report_number }}</div>
        <div class="text-gray-500">{{ $user->missingPetReports->first()->previous_status ?:
          $user->missingPetReports->first()->status }}</div>
        <div class="text-xs text-gray-400">{{ $user->missingPetReports->first()->created_at->format('M d, Y') }}</div>
      </div>
      <button onclick="showApplicationsModal('missing', {{ json_encode($user->missingPetReports) }})"
        class="text-blue-500 text-sm mt-2 inline-block">View all ({{ $user->missingPetReports->count() }})</button>
      @endif
    </div>
  </div>
</div>

<!-- Applications Modal -->

<div id="applicationsModal"
  class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl relative max-h-[90vh] overflow-y-auto">
    <div class="flex justify-between items-center mb-4">
      <h3 id="modalTitle" class="text-lg font-medium text-gray-900"></h3>
      <button onclick="closeApplicationsModal()" class="text-gray-500 hover:text-gray-700">
        <i class="ph ph-x"></i>
      </button>
    </div>
    <div id="modalContent" class="max-h-96 overflow-y-auto scrollbar-hidden">
      <!-- Content will be loaded here dynamically -->
    </div>
  </div>
</div>