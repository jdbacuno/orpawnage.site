<x-auth-layout>
  <div class="relative p-6 bg-white z-1 sm:p-0">
    <div class="relative flex flex-col justify-center w-full h-screen sm:p-0 lg:flex-row">
      <!-- LEFT SIDE: Form -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto px-4 sm:px-6">
          <div class="space-y-8">
            <!-- Mobile Logo -->
            <div class="lg:hidden">
              <img src="{{ asset('images/orpawnage-logo.png') }}" class="h-24 mx-auto" alt="OrPAWnage Logo" />
            </div>

            <!-- Header -->
            <div class="space-y-2 text-center">
              <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                Reset Your Password
              </h1>
              <p class="text-gray-500">
                Create a new secure password for your account
              </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm" class="space-y-6">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">
              <input type="hidden" name="email" value="{{ request('email') }}">

              <!-- New Password -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  New Password
                </label>
                <div class="relative">
                  <input type="password" id="password" name="password" placeholder="Create a new password"
                    class="block w-full px-4 py-3 pr-10 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                    required />
                  <span id="toggle-password"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer hover:text-gray-500">
                    <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-closed" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                  </span>
                </div>

                <x-form-error name="password" />

                <!-- Password Strength -->
                <div class="mt-3">
                  <p id="strength-text" class="text-xs text-blue-700">Start typing to see strength...</p>
                  <div class="h-1.5 mt-1 rounded-full w-full bg-transparent">
                    <div id="strength-progress"
                      class="h-1.5 rounded-full w-0 bg-transparent transition-all duration-300"></div>
                  </div>
                </div>

                <!-- Password Requirements -->
                <div class="p-3 mt-2 bg-blue-50 rounded-lg border border-blue-100">
                  <h4 class="text-sm font-medium text-blue-800 mb-2">Password Requirements:</h4>
                  <ul class="text-xs space-y-1.5">
                    <li id="req-length" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-check-circle mr-2 text-sm"></i> Minimum 6 characters
                    </li>
                    <li id="req-uppercase" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-check-circle mr-2 text-sm"></i> At least one uppercase letter
                    </li>
                    <li id="req-lowercase" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-check-circle mr-2 text-sm"></i> At least one lowercase letter
                    </li>
                    <li id="req-number" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-check-circle mr-2 text-sm"></i> At least one number
                    </li>
                    <li id="req-symbol" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-check-circle mr-2 text-sm"></i> At least one symbol
                    </li>
                  </ul>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Confirm New Password
                </label>
                <div x-data="{ showPassword: false }" class="relative">
                  <input :type="showPassword ? 'text' : 'password'" placeholder="Repeat your new password"
                    name="password_confirmation"
                    class="block w-full px-4 py-3 pr-10 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                    required />
                  <span @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer hover:text-gray-500">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      style="display: none;">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                  </span>
                </div>
                <x-form-error name="password_confirmation" />
              </div>

              <!-- Submit Button -->
              <div>
                <button type="submit"
                  class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-all duration-200 rounded-lg bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Reset Password
                </button>
              </div>
            </form>

            <!-- Sign In Link -->
            <div class="text-sm text-center text-gray-500">
              Remember your password? <a href="{{ route('login') }}"
                class="font-medium text-blue-600 hover:text-blue-500">Sign in</a>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE: Background Image -->
      <div class="relative hidden w-full h-full lg:block lg:w-1/2 bg-cover bg-center" style="
          background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                    url({{ asset('images/vet_service.jpg') }}) no-repeat center center;
          background-size: cover;
        ">
        <!-- Centered Content -->
        <div class="relative z-10 flex flex-col items-center justify-center w-full h-full p-8 text-center">
          <img src="{{ asset('images/orpawnage-logo.png') }}" alt="OrPAWnage Logo" class="w-40 mb-6" />
          <h2 class="text-3xl font-bold text-white"><span class="bg-black/20 relative overflow-hidden p-2">
              <span class="animate-color-change-orange">
                Or<strong class="animate-color-change-yellow">PAW</strong>nage
              </span>
              <span class="glowing-border"></span>
            </span></h2>
          <p class="mt-2 text-lg text-gray-300">Angeles City Veterinary Office</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Password Strength Script -->
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
        strengthText.style.color = '#ef4444';
        strengthProgress.style.backgroundColor = '#ef4444'; // Red
      } else if (progressPercentage < 70) {
        strengthText.innerText = 'Medium';
        strengthText.style.color = '#f59e0b';
        strengthProgress.style.backgroundColor = '#f59e0b'; // Orange
      } else {
        strengthText.innerText = 'Strong';
        strengthText.style.color = '#10b981';
        strengthProgress.style.backgroundColor = '#10b981'; // Green
      }
    };

    passwordInput.addEventListener('input', () => {
      updateStrength(passwordInput.value);
    });

    togglePassword.addEventListener('click', () => {
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
  
      eyeOpen.classList.toggle('hidden');
      eyeClosed.classList.toggle('hidden');
    });
  </script>
</x-auth-layout>