<x-admin-layout>
  <div class="flex flex-wrap justify-between items-center gap-3 mb-8">
    <h1 class="text-2xl font-bold text-gray-900">
      <i class="ph-fill ph-gear mr-2 text-blue-500"></i>Admin Profile Settings
    </h1>

    <!-- Success Alert -->
    @if(session('success'))
    <div id="alert-3"
      class="flex items-center pl-4 pr-6 py-3 mb-4 text-green-800 rounded-lg bg-green-50 border-l-4 border-green-400"
      role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">
        {!! session('success') !!}
      </div>
      <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
        data-dismiss-target="#alert-3" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
      </button>
    </div>
    @endif
  </div>

  <div class="bg-white p-6 sm:p-8 shadow-md rounded-lg mt-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Left Column -->
      <div class="space-y-6">
        <!-- Email Verification Status -->
        <div class="bg-blue-50 border-l-4 border-blue-400 rounded-r-lg p-4">
          <div class="flex items-center justify-between">
            <div class="flex items-start">
              <i class="ph-fill ph-warning text-blue-500 text-xl mr-2"></i>
              <div>
                <h3 class="text-lg font-medium text-gray-900">Email Verification</h3>
                <p class="text-sm text-gray-700">
                  Status: <span
                    class="{{ auth()->user()->hasVerifiedEmail() ? 'text-green-600 font-medium' : 'text-red-600 font-medium' }}">
                    {{ auth()->user()->hasVerifiedEmail() ? 'Verified' : 'Not Verified' }}
                  </span>
                </p>
              </div>
            </div>
            @unless(auth()->user()->hasVerifiedEmail())
            <form method="POST" action="{{ route('verification.send') }}">
              @csrf
              <button type="submit"
                class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
                Resend Verification
              </button>
            </form>
            @endunless
          </div>
        </div>

        <!-- Email Update -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
          <h3 class="text-md sm:text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="ph-fill ph-envelope mr-2 text-blue-500"></i>Change Email Address
          </h3>
          <form method="POST" action="{{ route('admin.settings.email.update') }}" id="emailUpdateForm">
            @csrf
            @method('PATCH')

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Current Email</label>
                <input type="email" value="{{ auth()->user()->email }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100" readonly>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">New Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                  placeholder="New email address">
                <x-form-error name="email" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                <div class="relative">
                  <input type="password" name=email_current_password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                    placeholder="Enter your current password">
                  <button type="button" onclick="togglePasswordVisibility(this)"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                    <i class="ph-fill ph-eye text-lg"></i>
                  </button>
                </div>
                <x-form-error name="email_current_password" />
              </div>

              <div class="pt-2 flex justify-end">
                <button type="submit"
                  class="px-5 py-2.5 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                  <i class="ph-fill ph-check-circle mr-2"></i>Update Email
                </button>
              </div>
            </div>
          </form>
        </div>

        <!-- Contact Number Update -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
          <h3 class="text-md sm:text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="ph-fill ph-phone mr-2 text-blue-500"></i>Update Contact Number
          </h3>
          <form method="POST" action="{{ route('admin.settings.contact.update') }}" id="contactUpdateForm">
            @csrf
            @method('PATCH')

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Current Number</label>
                <input type="tel" value="{{ auth()->user()->contact_number }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100" readonly>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">New Phone Number</label>
                <input type="tel" name="contact_number" value="{{ old('contact_number') }}" pattern="^09\d{9}$"
                  maxlength="11" placeholder="09XXXXXXXXX" required
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400">
                <p class="mt-1 text-xs text-gray-500">Format: 09XXXXXXXXX (11 digits)</p>
                <x-form-error name="contact_number" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                <div class="relative">
                  <input type="password" name="contact_current_password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                    placeholder="Enter your current password">
                  <button type="button" onclick="togglePasswordVisibility(this)"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                    <i class="ph-fill ph-eye text-lg"></i>
                  </button>
                </div>
                <x-form-error name="contact_current_password" />
              </div>

              <div class="pt-2 flex justify-end">
                <button type="submit"
                  class="px-5 py-2.5 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                  <i class="ph-fill ph-check-circle mr-2"></i>Update Contact
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Column -->
      <div class="space-y-6">
        <!-- Password Update -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
          <h3 class="text-md sm:text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="ph-fill ph-lock mr-2 text-blue-500"></i>Change Password
          </h3>
          <form method="POST" action="{{ route('admin.settings.password.update') }}" id="passwordChangeForm">
            @csrf
            @method('PATCH')

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                <div class="relative">
                  <input type="password" name="current_password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                    placeholder="Current password">
                  <button type="button" onclick="togglePasswordVisibility(this)"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                    <i class="ph-fill ph-eye text-lg"></i>
                  </button>
                </div>
                <x-form-error name="current_password" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
                <div class="relative">
                  <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                    placeholder="New password">
                  <button type="button" onclick="togglePasswordVisibility(this)"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                    <i class="ph-fill ph-eye text-lg"></i>
                  </button>
                </div>
                <x-form-error name="password" />

                <!-- Password Strength Meter -->
                <div class="mt-2 space-y-2">
                  <p id="strength-text" class="text-xs text-blue-700">Start typing to see strength...</p>
                  <div class="h-1.5 mt-1 rounded-full w-full bg-transparent">
                    <div id="strength-progress"
                      class="h-1.5 rounded-full w-0 bg-transparent transition-all duration-300">
                    </div>
                  </div>
                </div>

                <!-- Password Requirements -->
                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mt-3">
                  <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                    <i class="ph-fill ph-info mr-2"></i>Password Requirements
                  </h4>
                  <ul class="text-xs space-y-1">
                    <li id="req-length" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> Minimum 6 characters
                    </li>
                    <li id="req-uppercase" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one uppercase letter
                    </li>
                    <li id="req-lowercase" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one lowercase letter
                    </li>
                    <li id="req-number" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one number
                    </li>
                    <li id="req-symbol" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one symbol
                    </li>
                  </ul>
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Confirm Password</label>
                <div class="relative">
                  <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                    placeholder="Confirm new password">
                  <button type="button" onclick="togglePasswordVisibility(this)"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                    <i class="ph-fill ph-eye text-lg"></i>
                  </button>
                </div>
              </div>

              <div class="pt-2 flex justify-end">
                <button type="submit"
                  class="px-5 py-2.5 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                  <i class="ph-fill ph-check-circle mr-2"></i>Update Password
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthText = document.getElementById('strength-text');
    const strengthProgress = document.getElementById('strength-progress');

    const reqLength = document.getElementById('req-length');
    const reqUpper = document.getElementById('req-uppercase');
    const reqLower = document.getElementById('req-lowercase');
    const reqNumber = document.getElementById('req-number');
    const reqSymbol = document.getElementById('req-symbol');

    const updateRequirement = (condition, element) => {
      if (condition) {
        element.classList.remove('text-blue-700');
        element.classList.add('text-green-600');
        element.querySelector('i').classList.replace('ph-circle', 'ph-check-circle');
      } else {
        element.classList.remove('text-green-600');
        element.classList.add('text-blue-700');
        element.querySelector('i').classList.replace('ph-check-circle', 'ph-circle');
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
        strengthProgress.style.backgroundColor = '#ef4444'; // Red
      } else if (progressPercentage < 40) {
        strengthText.innerText = 'Weak';
        strengthText.className = 'text-xs text-red-600';
        strengthProgress.style.backgroundColor = '#ef4444'; // Red
      } else if (progressPercentage < 70) {
        strengthText.innerText = 'Medium';
        strengthText.className = 'text-xs text-yellow-600';
        strengthProgress.style.backgroundColor = '#f59e0b'; // Orange
      } else {
        strengthText.innerText = 'Strong';
        strengthText.className = 'text-xs text-green-600';
        strengthProgress.style.backgroundColor = '#10b981'; // Green
      }
    };

    passwordInput.addEventListener('input', () => {
      updateStrength(passwordInput.value);
    });

    // Toggle password visibility
    function togglePasswordVisibility(button) {
      const input = button.parentElement.querySelector('input');
      const type = input.type === 'password' ? 'text' : 'password';
      input.type = type;
      button.innerHTML = type === 'password' 
        ? '<i class="ph-fill ph-eye text-lg"></i>' 
        : '<i class="ph-fill ph-eye-slash text-lg"></i>';
    }

    // Prevent default form submission and handle it manually
    document.getElementById('emailUpdateForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      this.submit();
    });

    document.getElementById('contactUpdateForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      this.submit();
    });

    document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      this.submit();
    });
  </script>
</x-admin-layout>