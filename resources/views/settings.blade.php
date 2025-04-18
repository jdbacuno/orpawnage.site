<x-layout>
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 mt-10">
    <div class="max-w-6xl mx-auto">
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        {{-- Header --}}
        <div class="bg-gray-800 px-6 py-4">
          <h2 class="text-2xl font-bold text-white">Account Settings</h2>
          @if(session('success'))
          <div class="mt-2 bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
          @endif
        </div>

        <div class="p-6 md:p-8">
          {{-- Email Verification Status --}}
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-medium text-gray-900">Email Verification</h3>
                <p class="mt-1 text-sm text-gray-600">
                  Status:
                  <span
                    class="{{ auth()->user()->hasVerifiedEmail() ? 'text-green-600 font-medium' : 'text-red-600 font-medium' }}">
                    {{ auth()->user()->hasVerifiedEmail() ? 'Verified' : 'Not Verified' }}
                  </span>
                </p>
              </div>
              @unless(auth()->user()->hasVerifiedEmail())
              <form method="POST" action="{{ route('verification.send') }}" id="settingsForm">
                @csrf
                <button type="submit"
                  class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                  Resend Verification
                </button>
              </form>
              @endunless
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Left Column --}}
            <div class="space-y-6">
              {{-- Email Update --}}
              <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Change Email Address</h3>
                <form method="POST" action="{{ route('settings.email.update') }}" id="settingsForm">
                  @csrf @method('PATCH')

                  <div class="space-y-4">
                    <div>
                      <label for="old_email" class="block text-sm font-medium text-gray-700 mb-1">Current Email</label>
                      <input type="email" id="old_email" value="{{ auth()->user()->email }}"
                        class="w-full px-3 py-2 border bg-gray-200 border-gray-300 rounded-md shadow-sm"
                        placeholder="Email Address" readonly>
                    </div>

                    <div>
                      <label for="email" class="block text-sm font-medium text-gray-700 mb-1">New Email</label>
                      <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Email New Address">
                      <x-form-error name="email" />
                    </div>

                    <div>
                      <label for="current_password_email" class="block text-sm font-medium text-gray-700 mb-1">Current
                        Password</label>
                      <div class="relative">
                        <input type="password" id="current_password_email" name="current_password" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter Password">
                        <button type="button" onclick="togglePasswordVisibility('current_password_email', this)"
                          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                          <i class="ph-fill ph-eye text-lg"></i>
                        </button>
                      </div>
                      <x-form-error name="current_password" />
                    </div>

                    <div>
                      <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Email
                      </button>
                    </div>
                  </div>
                </form>
              </div>

              {{-- Contact Number --}}
              <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Contact Number</h3>
                <form method="POST" action="{{ route('settings.contact.update') }}" id="settingsForm">
                  @csrf @method('PATCH')

                  <div class="space-y-4">
                    <div>
                      <label for="old_contact_number" class="block text-sm font-medium text-gray-700 mb-1">Current Phone
                        Number</label>
                      <input type="tel" id="old_contact_number" value="{{ auth()->user()->contact_number }}"
                        pattern="^09\d{9}$" maxlength="11" placeholder="09XXXXXXXXX" readonly
                        class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm ">
                    </div>

                    <div>
                      <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">New Phone
                        Number</label>
                      <input type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number') }}"
                        pattern="^09\d{9}$" maxlength="11" placeholder="09XXXXXXXXX" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                      <p class="mt-1 text-sm text-gray-500">Format: 09XXXXXXXXX (11 digits)</p>
                      <x-form-error name="contact_number" />
                    </div>

                    <div>
                      <label for="current_password_contact" class="block text-sm font-medium text-gray-700 mb-1">Current
                        Password</label>
                      <div class="relative">
                        <input type="password" id="current_password_contact" name="current_password" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter Password">
                        <button type="button" onclick="togglePasswordVisibility('current_password_contact', this)"
                          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                          <i class="ph-fill ph-eye text-lg"></i>
                        </button>
                      </div>
                      <x-form-error name="current_password" />
                    </div>

                    <div>
                      <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Contact
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
              {{-- Password Update --}}
              <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                <form method="POST" action="{{ route('settings.password.update') }}" id="settingsForm">
                  @csrf @method('PATCH')

                  <div class="space-y-4">
                    <div>
                      <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current
                        Password</label>
                      <div class="relative">
                        <input type="password" id="current_password" name="current_password" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Current Password">
                        <button type="button" onclick="togglePasswordVisibility('current_password', this)"
                          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                          <i class="ph-fill ph-eye text-lg"></i>
                        </button>
                      </div>
                      <x-form-error name="current_password" />
                    </div>

                    <div>
                      <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                      <div class="relative">
                        <input type="password" id="password" name="password" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter New Password">
                        <button type="button" onclick="togglePasswordVisibility('password', this)"
                          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                          <i class="ph-fill ph-eye text-lg"></i>
                        </button>
                      </div>
                      <x-form-error name="password" />

                      {{-- Strength text only --}}
                      <p id="strength-text" class="text-xs mt-2 text-blue-700">Start typing to see strength...</p>
                    </div>

                    <div class="bg-blue-50 p-3 rounded-md">
                      <h4 class="text-sm font-medium text-blue-800 mb-1">Password Requirements:</h4>
                      <ul class="text-xs space-y-1">
                        <li id="req-length" class="flex items-center text-blue-700">
                          <i class="ph-fill ph-check-circle mr-2"></i> Minimum 6 characters
                        </li>
                        <li id="req-uppercase" class="flex items-center text-blue-700">
                          <i class="ph-fill ph-check-circle mr-2"></i> At least one uppercase letter
                        </li>
                        <li id="req-lowercase" class="flex items-center text-blue-700">
                          <i class="ph-fill ph-check-circle mr-2"></i> At least one lowercase letter
                        </li>
                        <li id="req-number" class="flex items-center text-blue-700">
                          <i class="ph-fill ph-check-circle mr-2"></i> At least one number
                        </li>
                        <li id="req-symbol" class="flex items-center text-blue-700">
                          <i class="ph-fill ph-check-circle mr-2"></i> At least one symbol
                        </li>
                      </ul>
                    </div>

                    <script>
                      const passwordInput = document.getElementById('password');
                      const strengthText = document.getElementById('strength-text');
                      const togglePassword = document.getElementById('toggle-password');
                      const eyeOpen = document.getElementById('eye-open');
                      const eyeClosed = document.getElementById('eye-closed');
                    
                      const reqLength = document.getElementById('req-length');
                      const reqUpper = document.getElementById('req-uppercase');
                      const reqLower = document.getElementById('req-lowercase');
                      const reqNumber = document.getElementById('req-number');
                      const reqSymbol = document.getElementById('req-symbol');
                    
                      const updateRequirement = (condition, element) => {
                        if (condition) {
                          element.classList.add('text-green-600');
                          element.classList.remove('text-blue-700');
                        } else {
                          element.classList.remove('text-green-600');
                          element.classList.add('text-blue-700');
                        }
                      };
                    
                      const updateStrength = (password) => {
                        const hasLength = password.length >= 6;
                        const hasUpper = /[A-Z]/.test(password);
                        const hasLower = /[a-z]/.test(password);
                        const hasNumber = /[0-9]/.test(password);
                        const hasSymbol = /[^A-Za-z0-9]/.test(password);
                    
                        updateRequirement(hasLength, reqLength);
                        updateRequirement(hasUpper, reqUpper);
                        updateRequirement(hasLower, reqLower);
                        updateRequirement(hasNumber, reqNumber);
                        updateRequirement(hasSymbol, reqSymbol);
                    
                        let score = [hasLength, hasUpper, hasLower, hasNumber, hasSymbol].filter(Boolean).length;
                    
                        let text = 'Weak';
                        let color = 'text-red-600';
                    
                        if (score === 5) {
                          text = 'Strong';
                          color = 'text-green-600';
                        } else if (score >= 3) {
                          text = 'Good';
                          color = 'text-yellow-500';
                        }
                    
                        strengthText.textContent = text;
                        strengthText.className = `text-xs mt-2 font-medium ${color}`;
                      };
                    
                      passwordInput.addEventListener('input', () => {
                        updateStrength(passwordInput.value);
                      });
                    
                      togglePassword.addEventListener('click', () => {
                        const isPassword = passwordInput.getAttribute('type') === 'password';
                        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                        eyeOpen.classList.toggle('hidden', !isPassword);
                        eyeClosed.classList.toggle('hidden', isPassword);
                      });
                    </script>

                    <div>
                      <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                        Password</label>
                      <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Confirm New Password">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)"
                          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                          <i class="ph-fill ph-eye text-lg"></i>
                        </button>
                      </div>
                    </div>

                    <div>
                      <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Password
                      </button>
                    </div>
                  </div>
                </form>
              </div>

              {{-- Account Deletion --}}
              @if (!auth()->user()->isAdmin)
              <div class="bg-white border border-red-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-red-900 mb-4">Delete Account</h3>
                <p class="text-sm text-gray-600 mb-4">
                  Once you delete your account, there is no going back. Please be certain.
                </p>

                <form method="POST" action="{{ route('settings.delete') }}" id="deleteAccountForm">
                  @csrf @method('DELETE')

                  <div class="space-y-4">
                    <div>
                      <label for="password_for_account_closure"
                        class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                      <div class="relative">
                        <input type="password" id="password_for_account_closure" name="password_for_account_closure"
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                          placeholder="Current Password">
                        <button type="button" onclick="togglePasswordVisibility('password_for_account_closure', this)"
                          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                          <i class="ph-fill ph-eye text-lg"></i>
                        </button>
                      </div>
                      <x-form-error name="password_for_account_closure" />
                    </div>

                    <div>
                      <button type="button" onclick="showDeleteModal()"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Account Permanently
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete Confirmation Modal --}}
  <div id="deleteConfirmationModal"
    class="fixed inset-0 px-1 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Account Deletion</h3>
      <p class="text-sm text-gray-700 mb-6">
        Are you absolutely sure you want to delete your account? This action cannot be undone.
      </p>
      <div class="flex justify-end space-x-3">
        <button onclick="hideDeleteModal()"
          class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300 transition">Cancel</button>
        <button onclick="submitDeleteForm()"
          class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700 transition"
          id="deleteBtn">Delete</button>
      </div>
    </div>
  </div>


  <script>
    function togglePasswordVisibility(id, button) {
      const input = document.getElementById(id);
      const type = input.type === 'password' ? 'text' : 'password';
      input.type = type;
      button.innerHTML = type === 'password' 
        ? '<i class="ph-fill ph-eye text-lg"></i>' 
        : '<i class="ph-fill ph-eye-slash text-lg"></i>';
    }

    function showDeleteModal() {
      document.getElementById('deleteConfirmationModal').classList.remove('hidden');
    }

    function hideDeleteModal() {
      document.getElementById('deleteConfirmationModal').classList.add('hidden');
    }

    function submitDeleteForm() {
      document.getElementById('deleteAccountForm').submit();
    }
  </script>

</x-layout>