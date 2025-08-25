<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Users</h1>

  <div class="mt-4">
    {{-- Filter and Search Section --}}
    <div class="flex flex-wrap gap-4 mb-4">
      <form method="GET" action="{{ route('admin.users') }}" class="flex flex-wrap gap-4 w-full">
        <!-- Search -->
        <div class="relative">
          <input type="text" name="search" placeholder="Search by email or username" value="{{ request('search') }}"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 pl-10">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="ph-fill ph-magnifying-glass text-gray-500"></i>
          </div>
        </div>

        <!-- Status Filter -->
        <select name="status"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[180px]"
          onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
          <option value="banned" {{ request('status')==='banned' ? 'selected' : '' }}>Banned</option>
          <option value="temporarily_banned" {{ request('status')==='temporarily_banned' ? 'selected' : '' }}>Temporarily Banned</option>
          <option value="verified" {{ request('status')==='verified' ? 'selected' : '' }}>Verified</option>
          <option value="unverified" {{ request('status')==='unverified' ? 'selected' : '' }}>Unverified</option>
        </select>

        <!-- Sort Direction -->
        <select name="direction"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
          onchange="this.form.submit()">
          <option value="desc" {{ request('direction', 'desc' )==='desc' ? 'selected' : '' }}>Newest First</option>
          <option value="asc" {{ request('direction')==='asc' ? 'selected' : '' }}>Oldest First</option>
        </select>
      </form>
    </div>

    @if($users->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No users found.</p>
    </div>
    @else
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($users as $user)
          <tr class="hover:bg-gray-50 cursor-pointer" onclick="showUserModal('{{ $user->id }}')">
            <td class="px-6 py-4">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <img class="h-10 w-10 rounded-full" src="{{ asset('images/profile_pic.png') }}" alt="Avatar">
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $user->username ?? 'No Name' }}</div>
                  <div class="text-sm text-gray-500">{{ $user->email }}</div>
                  <div class="mt-1">
                    @if($user->is_banned)
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Banned</span>
                    @elseif($user->is_temporarily_banned)
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Temporarily Banned</span>
                    @elseif($user->email_verified_at)
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Unverified</span>
                    @endif
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $users->links() }}
    </div>
    @endif
  </div>

  <!-- User Details Modal -->
  <div id="userModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl relative max-h-[90vh] overflow-y-auto">
      <button type="button" id="closeUserModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph ph-x"></i>
      </button>

      <div id="userModalContent">
        <!-- Content will be loaded via AJAX -->
        <div class="flex justify-center items-center h-64">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-gray-900"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Ban Modal -->
  <div id="banModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeBanModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Ban User</h2>
      <p class="mb-4">Please provide a reason for banning this user:</p>
      <p class="mb-4 text-red-500 text-sm">This will send an email notification to the user.</p>

      <form id="banForm" method="POST" action="">
        @csrf
        @method('PATCH')
        <input type="hidden" name="user_id" id="banUserId">

        <label for="ban_reason" class="block font-medium text-gray-700">Reason:</label>
        <textarea id="ban_reason" name="ban_reason" class="w-full border p-2 rounded-md mb-4" required></textarea>

        <button type="submit" id="banSubmitBtn" class="bg-red-500 px-4 py-2 text-white hover:bg-red-400 rounded-md w-full disabled:opacity-50 disabled:cursor-not-allowed">
          <i class="ph-fill ph-prohibit mr-2"></i>Confirm Ban
        </button>
      </form>
    </div>
  </div>

  <!-- Temporary Ban Modal -->
  <div id="temporaryBanModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeTemporaryBanModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Temporarily Ban User</h2>
      <p class="mb-4">Please provide a reason for temporarily banning this user:</p>
      <p class="mb-4 text-orange-500 text-sm">This will send an email notification to the user. The ban will automatically lift after 7 days.</p>

      <form id="temporaryBanForm" method="POST" action="">
        @csrf
        @method('PATCH')
        <input type="hidden" name="user_id" id="temporaryBanUserId">

        <label for="temporary_ban_reason" class="block font-medium text-gray-700">Reason:</label>
        <textarea id="temporary_ban_reason" name="temporary_ban_reason" class="w-full border p-2 rounded-md mb-4" required></textarea>

        <button type="submit" id="temporaryBanSubmitBtn" class="bg-orange-500 px-4 py-2 text-white hover:bg-orange-400 rounded-md w-full disabled:opacity-50 disabled:cursor-not-allowed">
          <i class="ph-fill ph-clock mr-2"></i>Confirm Temporary Ban
        </button>
      </form>
    </div>
  </div>

  <script>
    function showUserModal(userId) {
      const modal = document.getElementById('userModal');
      modal.classList.remove('hidden');
      
      // Load user details via AJAX
      fetch(`/admin/users/${userId}/details`)
        .then(response => response.text())
        .then(html => {
          document.getElementById('userModalContent').innerHTML = html;
        })
        .catch(error => {
          console.error('Error loading user details:', error);
          document.getElementById('userModalContent').innerHTML = `
            <div class="p-4 text-red-500">
              Error loading user details. Please try again.
            </div>
          `;
        });
    }

    document.getElementById('closeUserModal').addEventListener('click', () => {
      document.getElementById('userModal').classList.add('hidden');
    });

    // Make these functions globally available
    window.showBanModal = function(userId) {
      document.getElementById('banUserId').value = userId;
      document.getElementById('banForm').action = `/admin/users/${userId}/ban`;
      document.getElementById('banModal').classList.remove('hidden');
      
      // Reset form and button state
      document.getElementById('banForm').reset();
      const submitBtn = document.getElementById('banSubmitBtn');
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="ph-fill ph-prohibit mr-2"></i>Confirm Ban';
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
      }
    }

    window.showTemporaryBanModal = function(userId) {
      document.getElementById('temporaryBanUserId').value = userId;
      document.getElementById('temporaryBanForm').action = `/admin/users/${userId}/temporary-ban`;
      document.getElementById('temporaryBanModal').classList.remove('hidden');
      
      // Reset form and button state
      document.getElementById('temporaryBanForm').reset();
      const submitBtn = document.getElementById('temporaryBanSubmitBtn');
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="ph-fill ph-clock mr-2"></i>Confirm Temporary Ban';
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
      }
    }

    // Initialize event listeners when the main page loads
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('closeBanModal')?.addEventListener('click', () => {
        document.getElementById('banModal').classList.add('hidden');
        // Reset form and button state when modal is closed
        document.getElementById('banForm').reset();
        const submitBtn = document.getElementById('banSubmitBtn');
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="ph-fill ph-prohibit mr-2"></i>Confirm Ban';
          submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
      });
      
      document.getElementById('closeTemporaryBanModal')?.addEventListener('click', () => {
        document.getElementById('temporaryBanModal').classList.add('hidden');
        // Reset form and button state when modal is closed
        document.getElementById('temporaryBanForm').reset();
        const submitBtn = document.getElementById('temporaryBanSubmitBtn');
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="ph-fill ph-clock mr-2"></i>Confirm Temporary Ban';
          submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
      });

          // Handle form submissions to prevent multiple submissions
    document.getElementById('banForm')?.addEventListener('submit', function(e) {
      const submitBtn = document.getElementById('banSubmitBtn');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ph-fill ph-prohibit mr-2"></i>Processing...';
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
      }
    });

    document.getElementById('temporaryBanForm')?.addEventListener('submit', function(e) {
      const submitBtn = document.getElementById('temporaryBanSubmitBtn');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ph-fill ph-clock mr-2"></i>Processing...';
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
      }
    });

      // Close modals when clicking outside
      document.getElementById('banModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
          this.classList.add('hidden');
          // Reset form and button state
          document.getElementById('banForm').reset();
          const submitBtn = document.getElementById('banSubmitBtn');
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="ph-fill ph-prohibit mr-2"></i>Confirm Ban';
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
          }
        }
      });

      document.getElementById('temporaryBanModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
          this.classList.add('hidden');
          // Reset form and button state
          document.getElementById('temporaryBanForm').reset();
          const submitBtn = document.getElementById('temporaryBanSubmitBtn');
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="ph-fill ph-clock mr-2"></i>Confirm Temporary Ban';
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
          }
        }
      });

      // Handle escape key to close modals
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          const banModal = document.getElementById('banModal');
          const tempBanModal = document.getElementById('temporaryBanModal');
          
          if (banModal && !banModal.classList.contains('hidden')) {
            banModal.classList.add('hidden');
            // Reset form and button state
            document.getElementById('banForm').reset();
            const submitBtn = document.getElementById('banSubmitBtn');
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.innerHTML = '<i class="ph-fill ph-prohibit mr-2"></i>Confirm Ban';
              submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
          }
          
          if (tempBanModal && !tempBanModal.classList.contains('hidden')) {
            tempBanModal.classList.add('hidden');
            // Reset form and button state
            document.getElementById('temporaryBanForm').reset();
            const submitBtn = document.getElementById('temporaryBanSubmitBtn');
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.innerHTML = '<i class="ph-fill ph-clock mr-2"></i>Confirm Temporary Ban';
              submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
          }
        }
      });
    });

    // Define functions first before they're called
    function showApplicationsModal(type, items) {
      const modal = document.getElementById('applicationsModal');
      const title = document.getElementById('modalTitle');
      const content = document.getElementById('modalContent');
      
      // Set title based on type
      switch(type) {
        case 'adoption':
          title.textContent = 'Adoption Applications';
          break;
        case 'surrender':
          title.textContent = 'Surrender Applications';
          break;
        case 'abuse':
          title.textContent = 'Abuse Reports';
          break;
        case 'missing':
          title.textContent = 'Missing Pet Reports';
          break;
      }
      
      // Generate content
      let html = '';
      if (items && items.length > 0) {
        items.forEach(item => {
          html += `
            <div class="border-b border-gray-200 py-2">
              <div class="font-medium">${item.transaction_number || item.report_number}</div>
              <div class="text-gray-500">${item.status}</div>
              <div class="text-xs text-gray-400">${new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</div>
            </div>
          `;
        });
      } else {
        html = '<p class="text-gray-500">No items found</p>';
      }
      
      content.innerHTML = html;
      modal.classList.remove('hidden');
    }

    function closeApplicationsModal() {
      document.getElementById('applicationsModal').classList.add('hidden');
    }

    function showBanModal(userId) {
      document.getElementById('banUserId').value = userId;
      document.getElementById('banForm').action = `/admin/users/${userId}/ban`;
      document.getElementById('banModal').classList.remove('hidden');
    }

    // Close ban modal event listener
    document.getElementById('closeBanModal')?.addEventListener('click', () => {
      document.getElementById('banModal').classList.add('hidden');
    });

    // Define functions first before they're called
    function showApplicationsModal(type, items) {
      const modal = document.getElementById('applicationsModal');
      const title = document.getElementById('modalTitle');
      const content = document.getElementById('modalContent');
      
      // Set title based on type
      switch(type) {
        case 'adoption':
          title.textContent = 'Adoption Applications';
          break;
        case 'surrender':
          title.textContent = 'Surrender Applications';
          break;
        case 'abuse':
          title.textContent = 'Abuse Reports';
          break;
        case 'missing':
          title.textContent = 'Missing Pet Reports';
          break;
      }
      
      // Generate content
      let html = '';
      if (items && items.length > 0) {
        items.forEach(item => {
          html += `
            <div class="border-b border-gray-200 py-2">
              <div class="font-medium">${item.transaction_number || item.report_number}</div>
              <div class="text-gray-500">${item.previous_status || item.status }</div>
              <div class="text-xs text-gray-400">${new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</div>
            </div>
          `;
        });
      } else {
        html = '<p class="text-gray-500">No items found</p>';
      }
      
      content.innerHTML = html;
      modal.classList.remove('hidden');
    }

    function closeApplicationsModal() {
      document.getElementById('applicationsModal').classList.add('hidden');
    }

    function showBanModal(userId) {
      document.getElementById('banUserId').value = userId;
      document.getElementById('banForm').action = `/admin/users/${userId}/ban`;
      document.getElementById('banModal').classList.remove('hidden');
    }

    // Close ban modal event listener
    document.getElementById('closeBanModal')?.addEventListener('click', () => {
      document.getElementById('banModal').classList.add('hidden');
    });
  </script>
</x-admin-layout>