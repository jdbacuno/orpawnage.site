<div class="space-y-6">
  <!-- User Info Section -->
  <div class="flex items-start space-x-4">
    <div class="flex-shrink-0 h-16 w-16">
      <img class="h-16 w-16 rounded-full" src="https://avatar.iran.liara.run/public" alt="Avatar">
    </div>
    <div class="flex-1">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">{{ $user->username ?? 'No Name' }}</h3>
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
          @if($user->is_banned) bg-red-100 text-red-800
          @elseif($user->email_verified_at) bg-green-100 text-green-800
          @else bg-yellow-100 text-yellow-800 @endif">
          @if($user->is_banned) Banned
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
    @elseif($user->email_verified_at)
    <button onclick="showBanModal('{{ $user->id }}')"
      class="bg-red-500 px-4 py-2 text-white hover:bg-red-400 rounded-md">
      <i class="ph-fill ph-prohibit mr-2"></i>Ban User
    </button>
    @endif
  </div>

  <!-- User Activity Sections -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Adoption Applications -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <h4 class="font-medium text-gray-900 mb-2">Adoption Applications</h4>
      @if($user->adoptionApplications->isEmpty())
      <p class="text-sm text-gray-500">No applications</p>
      @else
      <ul class="space-y-2">
        @foreach($user->adoptionApplications as $application)
        <li class="text-sm">
          <div class="font-medium">{{ $application->transaction_number }}</div>
          <div class="text-gray-500">{{ $application->status }}</div>
          <div class="text-xs text-gray-400">{{ $application->created_at->format('M d, Y') }}</div>
        </li>
        @endforeach
      </ul>
      <a href="{{ route('admin.adoption-applications', ['search' => $user->email]) }}"
        class="text-blue-500 text-sm mt-2 inline-block">View all</a>
      @endif
    </div>

    <!-- Abuse Reports -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <h4 class="font-medium text-gray-900 mb-2">Abuse Reports</h4>
      @if($user->animalAbuseReports->isEmpty())
      <p class="text-sm text-gray-500">No reports</p>
      @else
      <ul class="space-y-2">
        @foreach($user->animalAbuseReports as $report)
        <li class="text-sm">
          <div class="font-medium">{{ $report->report_number }}</div>
          <div class="text-gray-500">{{ $report->status }}</div>
          <div class="text-xs text-gray-400">{{ $report->created_at->format('M d, Y') }}</div>
        </li>
        @endforeach
      </ul>
      <a href="{{ route('admin.abused-stray-reports', ['search' => $user->email]) }}"
        class="text-blue-500 text-sm mt-2 inline-block">View all</a>
      @endif
    </div>

    <!-- Missing Pet Reports -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <h4 class="font-medium text-gray-900 mb-2">Missing Pet Reports</h4>
      @if($user->missingPetReports->isEmpty())
      <p class="text-sm text-gray-500">No reports</p>
      @else
      <ul class="space-y-2">
        @foreach($user->missingPetReports as $report)
        <li class="text-sm">
          <div class="font-medium">{{ $report->report_number }}</div>
          <div class="text-gray-500">{{ $report->status }}</div>
          <div class="text-xs text-gray-400">{{ $report->created_at->format('M d, Y') }}</div>
        </li>
        @endforeach
      </ul>
      <a href="{{ route('admin.missing-pet-reports', ['search' => $user->email]) }}"
        class="text-blue-500 text-sm mt-2 inline-block">View all</a>
      @endif
    </div>
  </div>
</div>

<script>
  function showBanModal(userId) {
    document.getElementById('banUserId').value = userId;
    document.getElementById('banForm').action = `/admin/users/${userId}/ban`;
    document.getElementById('banModal').classList.remove('hidden');
  }

  document.getElementById('closeBanModal').addEventListener('click', () => {
    document.getElementById('banModal').classList.add('hidden');
  });
</script>