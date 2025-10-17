{{-- This partial can be included in the users page to show user details inline --}}
{{-- Usage: @include('admin.partials.inline-user-details', ['user' => $user]) --}}

@if(isset($user))
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
  <div class="flex items-start justify-between mb-6">
    <div class="flex items-start gap-4">
      <div class="flex-shrink-0 h-20 w-20">
        <img class="h-20 w-20 rounded-full border-2 border-gray-200" 
          src="{{ asset('images/profile_pic.png') }}" 
          alt="Avatar">
      </div>
      <div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $user->username ?? 'No Name' }}</h3>
        <p class="text-gray-600 mt-1">{{ $user->email }}</p>
        <p class="text-sm text-gray-500 mt-1">Member since {{ $user->created_at->format('M d, Y') }}</p>
      </div>
    </div>

    <span class="px-3 py-1 text-sm font-semibold rounded-full border
      @if($user->is_banned) bg-red-100 text-red-800 border-red-200
      @elseif($user->is_temporarily_banned) bg-orange-100 text-orange-800 border-orange-200
      @elseif($user->email_verified_at) bg-green-100 text-green-800 border-green-200
      @else bg-yellow-100 text-yellow-800 border-yellow-200 @endif">
      @if($user->is_banned) Permanently Banned
      @elseif($user->is_temporarily_banned) Temporarily Banned
      @elseif($user->email_verified_at) Active
      @else Unverified @endif
    </span>
  </div>

  @if($user->is_banned || $user->is_temporarily_banned)
  <div class="mb-6 p-4 rounded-lg border-l-4 
    {{ $user->is_banned ? 'bg-red-50 border-red-400' : 'bg-orange-50 border-orange-400' }}">
    <h4 class="font-semibold {{ $user->is_banned ? 'text-red-900' : 'text-orange-900' }} mb-2">
      Ban Information
    </h4>
    <div class="space-y-1 text-sm {{ $user->is_banned ? 'text-red-800' : 'text-orange-800' }}">
      <p><strong>Reason:</strong> {{ $user->is_banned ? $user->ban_reason : $user->temporary_ban_reason ?? 'No reason provided' }}</p>
      <p><strong>Banned On:</strong> {{ ($user->is_banned ? $user->banned_at : $user->temporarily_banned_at)->format('M d, Y \a\t g:i A') }}</p>
      @if($user->is_temporarily_banned && $user->temporary_ban_expires_at)
      <p><strong>Expires On:</strong> {{ $user->temporary_ban_expires_at->format('M d, Y \a\t g:i A') }}</p>
      @endif
    </div>
  </div>
  @endif

  <!-- Action Buttons -->
  <div class="flex flex-wrap gap-3 pb-6 border-b border-gray-200">
    @if($user->is_banned)
    <form method="POST" action="{{ route('admin.users.unban', $user) }}">
      @csrf
      @method('PATCH')
      <button type="submit"
        class="bg-green-600 px-4 py-2 text-white hover:bg-green-700 rounded-lg transition-colors flex items-center gap-2"
        onclick="this.disabled=true; this.innerHTML='<i class=\'ph-fill ph-spinner ph-spin\'></i> Processing...'; this.form.submit();">
        <i class="ph-fill ph-arrow-counter-clockwise"></i>
        Unban User
      </button>
    </form>
    @elseif($user->is_temporarily_banned)
    <form method="POST" action="{{ route('admin.users.unban', $user) }}">
      @csrf
      @method('PATCH')
      <button type="submit" 
        class="bg-green-600 px-4 py-2 text-white hover:bg-green-700 rounded-lg transition-colors flex items-center gap-2">
        <i class="ph-fill ph-arrow-counter-clockwise"></i>
        Lift Temporary Ban
      </button>
    </form>
    @elseif($user->email_verified_at)
    <button onclick="showBanForm('{{ $user->id }}')"
      class="bg-red-600 px-4 py-2 text-white hover:bg-red-700 rounded-lg transition-colors flex items-center gap-2">
      <i class="ph-fill ph-prohibit"></i>
      Ban User
    </button>
    <button onclick="showTempBanForm('{{ $user->id }}')"
      class="bg-orange-600 px-4 py-2 text-white hover:bg-orange-700 rounded-lg transition-colors flex items-center gap-2">
      <i class="ph-fill ph-clock"></i>
      Temporary Ban
    </button>
    <form method="POST" action="{{ route('admin.users.password-reset', $user) }}">
      @csrf
      <button type="submit" 
        class="bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition-colors flex items-center gap-2"
        onclick="this.disabled=true; this.innerHTML='<i class=\'ph-fill ph-spinner ph-spin\'></i> Sending...'; this.form.submit();">
        <i class="ph-fill ph-key"></i>
        Send Reset Email
      </button>
    </form>
    @endif
  </div>

  <!-- User Activity Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
    <!-- Adoption Applications -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-blue-900 flex items-center gap-2">
          <i class="ph-fill ph-paw-print"></i>
          Adoptions
        </h4>
        <span class="text-2xl font-bold text-blue-700">{{ $user->adoptionApplications->count() }}</span>
      </div>
      @if($user->adoptionApplications->isNotEmpty())
      <div class="space-y-2 text-sm text-blue-800">
        @foreach($user->adoptionApplications->take(2) as $app)
        <div class="bg-white/60 rounded p-2">
          <div class="font-medium truncate">{{ $app->transaction_number }}</div>
          <div class="text-xs text-blue-600">{{ ucfirst($app->status) }}</div>
        </div>
        @endforeach
        @if($user->adoptionApplications->count() > 2)
        <button onclick="toggleSection('adoptions-{{ $user->id }}')" 
          class="text-blue-700 hover:text-blue-800 font-medium text-xs">
          View all {{ $user->adoptionApplications->count() }} →
        </button>
        @endif
      </div>
      @else
      <p class="text-sm text-blue-700">No applications</p>
      @endif
    </div>

    <!-- Surrender Applications -->
    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-lg border border-purple-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-purple-900 flex items-center gap-2">
          <i class="ph-fill ph-hand-heart"></i>
          Surrenders
        </h4>
        <span class="text-2xl font-bold text-purple-700">{{ $user->surrenderApplications->count() }}</span>
      </div>
      @if($user->surrenderApplications->isNotEmpty())
      <div class="space-y-2 text-sm text-purple-800">
        @foreach($user->surrenderApplications->take(2) as $app)
        <div class="bg-white/60 rounded p-2">
          <div class="font-medium truncate">{{ $app->transaction_number }}</div>
          <div class="text-xs text-purple-600">{{ ucfirst($app->status) }}</div>
        </div>
        @endforeach
        @if($user->surrenderApplications->count() > 2)
        <button onclick="toggleSection('surrenders-{{ $user->id }}')" 
          class="text-purple-700 hover:text-purple-800 font-medium text-xs">
          View all {{ $user->surrenderApplications->count() }} →
        </button>
        @endif
      </div>
      @else
      <p class="text-sm text-purple-700">No applications</p>
      @endif
    </div>

    <!-- Abuse Reports -->
    <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg border border-red-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-red-900 flex items-center gap-2">
          <i class="ph-fill ph-warning"></i>
          Abuse Reports
        </h4>
        <span class="text-2xl font-bold text-red-700">{{ $user->animalAbuseReports->count() }}</span>
      </div>
      @if($user->animalAbuseReports->isNotEmpty())
      <div class="space-y-2 text-sm text-red-800">
        @foreach($user->animalAbuseReports->take(2) as $report)
        <div class="bg-white/60 rounded p-2">
          <div class="font-medium truncate">{{ $report->report_number }}</div>
          <div class="text-xs text-red-600">{{ ucfirst($report->status) }}</div>
        </div>
        @endforeach
        @if($user->animalAbuseReports->count() > 2)
        <button onclick="toggleSection('abuse-{{ $user->id }}')" 
          class="text-red-700 hover:text-red-800 font-medium text-xs">
          View all {{ $user->animalAbuseReports->count() }} →
        </button>
        @endif
      </div>
      @else
      <p class="text-sm text-red-700">No reports</p>
      @endif
    </div>

    <!-- Missing Pet Reports -->
    <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-4 rounded-lg border border-amber-200">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-semibold text-amber-900 flex items-center gap-2">
          <i class="ph-fill ph-magnifying-glass"></i>
          Missing Pets
        </h4>
        <span class="text-2xl font-bold text-amber-700">{{ $user->missingPetReports->count() }}</span>
      </div>
      @if($user->missingPetReports->isNotEmpty())
      <div class="space-y-2 text-sm text-amber-800">
        @foreach($user->missingPetReports->take(2) as $report)
        <div class="bg-white/60 rounded p-2">
          <div class="font-medium truncate">{{ $report->report_number }}</div>
          <div class="text-xs text-amber-600">{{ ucfirst($report->status) }}</div>
        </div>
        @endforeach
        @if($user->missingPetReports->count() > 2)
        <button onclick="toggleSection('missing-{{ $user->id }}')" 
          class="text-amber-700 hover:text-amber-800 font-medium text-xs">
          View all {{ $user->missingPetReports->count() }} →
        </button>
        @endif
      </div>
      @else
      <p class="text-sm text-amber-700">No reports</p>
      @endif
    </div>
  </div>
</div>

<!-- Ban Forms (Inline, hidden by default) -->
<div id="banForm-{{ $user->id }}" class="hidden bg-red-50 border-2 border-red-300 rounded-lg p-6 mb-6">
  <h3 class="text-xl font-bold text-red-900 mb-4 flex items-center gap-2">
    <i class="ph-fill ph-prohibit"></i>
    Permanently Ban User
  </h3>
  <form method="POST" action="{{ route('admin.users.ban', $user) }}">
    @csrf
    @method('PATCH')
    <div class="mb-4">
      <label for="ban_reason" class="block text-sm font-medium text-gray-700 mb-2">
        Reason for Ban <span class="text-red-600">*</span>
      </label>
      <textarea 
        id="ban_reason" 
        name="ban_reason" 
        rows="4" 
        required
        maxlength="500"
        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500"
        placeholder="Provide a detailed reason for banning this user..."></textarea>
      <p class="text-xs text-gray-500 mt-1">Maximum 500 characters</p>
    </div>
    <div class="flex gap-3">
      <button type="submit" 
        class="bg-red-600 px-6 py-2 text-white hover:bg-red-700 rounded-lg transition-colors font-medium">
        Confirm Ban
      </button>
      <button type="button" 
        onclick="hideBanForm('{{ $user->id }}')"
        class="bg-gray-200 px-6 py-2 text-gray-700 hover:bg-gray-300 rounded-lg transition-colors">
        Cancel
      </button>
    </div>
  </form>
</div>

<div id="tempBanForm-{{ $user->id }}" class="hidden bg-orange-50 border-2 border-orange-300 rounded-lg p-6 mb-6">
  <h3 class="text-xl font-bold text-orange-900 mb-4 flex items-center gap-2">
    <i class="ph-fill ph-clock"></i>
    Temporarily Ban User
  </h3>
  <form method="POST" action="{{ route('admin.users.temporary-ban', $user) }}">
    @csrf
    @method('PATCH')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <div>
        <label for="temporary_ban_reason" class="block text-sm font-medium text-gray-700 mb-2">
          Reason for Temporary Ban <span class="text-red-600">*</span>
        </label>
        <textarea 
          id="temporary_ban_reason" 
          name="temporary_ban_reason" 
          rows="4" 
          required
          maxlength="255"
          class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
          placeholder="Provide a reason for temporarily banning this user..."></textarea>
        <p class="text-xs text-gray-500 mt-1">Maximum 255 characters</p>
      </div>
      <div>
        <label for="temporary_ban_expires_at" class="block text-sm font-medium text-gray-700 mb-2">
          Ban Expires On <span class="text-red-600">*</span>
        </label>
        <input 
          type="datetime-local" 
          id="temporary_ban_expires_at" 
          name="temporary_ban_expires_at" 
          required
          min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
          class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
        <p class="text-xs text-gray-500 mt-1">Select when the ban should automatically expire</p>
      </div>
    </div>
    <div class="flex gap-3">
      <button type="submit" 
        class="bg-orange-600 px-6 py-2 text-white hover:bg-orange-700 rounded-lg transition-colors font-medium">
        Confirm Temporary Ban
      </button>
      <button type="button" 
        onclick="hideTempBanForm('{{ $user->id }}')"
        class="bg-gray-200 px-6 py-2 text-gray-700 hover:bg-gray-300 rounded-lg transition-colors">
        Cancel
      </button>
    </div>
  </form>
</div>

<script>
function showBanForm(userId) {
  document.getElementById('banForm-' + userId).classList.remove('hidden');
  document.getElementById('tempBanForm-' + userId).classList.add('hidden');
}

function hideBanForm(userId) {
  document.getElementById('banForm-' + userId).classList.add('hidden');
}

function showTempBanForm(userId) {
  document.getElementById('tempBanForm-' + userId).classList.remove('hidden');
  document.getElementById('banForm-' + userId).classList.add('hidden');
}

function hideTempBanForm(userId) {
  document.getElementById('tempBanForm-' + userId).classList.add('hidden');
}

function toggleSection(sectionId) {
  const section = document.getElementById(sectionId);
  if (section) {
    section.classList.toggle('hidden');
  }
}
</script>
@endif
