<x-admin-layout>
  <div class="w-full mx-auto mt-2">
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
              <form method="POST" action="{{ route('admin.settings.email.update') }}" id="settingsForm">
                @csrf @method('PATCH')

                <div class="space-y-4">

                  <div>
                    <label for="old_email" class="block text-sm font-medium text-gray-700 mb-1">Current Email</label>
                    <input type="email" id="old_email" value="{{ auth()->user()->email }}" readonly
                      class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm"
                      placeholder="Email Address">
                  </div>

                  <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">New Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Email Address">
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
              <form method="POST" action="{{ route('admin.settings.contact.update') }}" id="settingsForm">
                @csrf @method('PATCH')

                <div class="space-y-4">
                  <div>
                    <label for="old_contact_number" class="block text-sm font-medium text-gray-700 mb-1">Current Phone
                      Number</label>
                    <input type="tel" id="old_contact_number" value="{{ auth()->user()->contact_number }}"
                      pattern="^09\d{9}$" maxlength="11" placeholder="09XXXXXXXXX" readonly
                      class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
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
              <form method="POST" action="{{ route('admin.settings.password.update') }}" id="settingsForm">
                @csrf @method('PATCH')

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

                  <!-- Password Strength Progress Bar -->
                  <div class="mt-3">
                    <div class="h-1 rounded-full w-full bg-gray-300">
                      <div id="strength-progress" class="h-1 rounded-full w-0 bg-red-600"></div>
                    </div>
                  </div>
                </div>

                <div class="bg-blue-50 p-3 rounded-md mt-2">
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
                  
                  const strengthProgress = document.getElementById('strength-progress');
                
                  // Initially hide the progress bar and strength text
                  strengthProgress.style.width = '0%';
                  strengthText.innerText = 'Start typing to see strength...';
                  strengthProgress.style.backgroundColor = '#f44336'; // Red
                
                  const updateRequirement = (condition, element) => {
                    if (condition) {
                      element.classList.add('text-green-600');
                      element.classList.add('line-through');
                      element.classList.remove('text-blue-700');
                    } else {
                      element.classList.remove('text-green-600');
                      element.classList.remove('line-through');
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
                
                    let strength = 0;
                    if (hasLength) strength += 1;
                    if (hasUpper) strength += 1;
                    if (hasLower) strength += 1;
                    if (hasNumber) strength += 1;
                    if (hasSymbol) strength += 1;
                
                    let progressPercentage = (strength / 5) * 100;
                    strengthProgress.style.width = `${progressPercentage}%`;
                
                    if (progressPercentage === 0) {
                      strengthText.innerText = 'Start typing to see strength...';
                      strengthProgress.style.backgroundColor = '#f44336'; // Red
                    } else if (progressPercentage < 40) {
                      strengthText.innerText = 'Weak';
                      strengthProgress.style.backgroundColor = '#f44336'; // Red
                    } else if (progressPercentage < 70) {
                      strengthText.innerText = 'Medium';
                      strengthProgress.style.backgroundColor = '#ff9800'; // Orange
                    } else {
                      strengthText.innerText = 'Strong';
                      strengthProgress.style.backgroundColor = '#4caf50'; // Green
                    }
                  };
                
                  passwordInput.addEventListener('input', () => {
                    updateStrength(passwordInput.value);
                    // Show the progress bar and strength text when typing starts
                    strengthProgress.style.display = 'block';
                    strengthText.style.display = 'block';
                  });
                
                  togglePassword.addEventListener('click', () => {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                
                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
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


        </div>
      </div>
    </div>
  </div>
  </div>

  <script>
    // Prevent default form submission for all forms
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          console.log(`Prevented default submit on form with action: ${form.action}`);
          // Optionally, you can call your AJAX or custom validation function here
        });
      });
    });

    function togglePasswordVisibility(id, button) {
      const input = document.getElementById(id);
      const type = input.type === 'password' ? 'text' : 'password';
      input.type = type;
      button.innerHTML = type === 'password' 
        ? '<i class="ph-fill ph-eye text-lg"></i>' 
        : '<i class="ph-fill ph-eye-slash text-lg"></i>';
    }
  </script>

</x-admin-layout>