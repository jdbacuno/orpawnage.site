<x-auth-layout>
  <!-- ===== Page Wrapper Start ===== -->
  <div class="relative bg-white sm:p-0">
    <div class="flex flex-col justify-center w-full h-screen lg:flex-row">
      <!-- Form Section -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2 overflow-y-auto no-scrollbar left-content">
        <div class="flex flex-col justify-center w-full max-w-md mx-auto px-6 py-12">
          <!-- Mobile Logo -->
          <div class="lg:hidden mb-8 logo">
            <img src="{{ asset('images/orpawnage-logo.png') }}" class="h-24 mx-auto" alt="OrPAWnage Logo" />
          </div>

          <!-- Make the form container scrollable -->
          <div>
            <!-- Header -->
            <div class="mb-8 space-y-2 text-center">
              <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                Create Your Account
              </h1>
              <p class="text-gray-500">
                Sign up to access our services
              </p>
            </div>

            <!-- Social Login -->
            <div class="space-y-6">
              <a href="{{ route('google.login') }}"
                class="flex items-center justify-center w-full gap-3 px-4 py-3 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M18.7511 10.1944C18.7511 9.47495 18.6915 8.94995 18.5626 8.40552H10.1797V11.6527H15.1003C15.0011 12.4597 14.4654 13.675 13.2749 14.4916L13.2582 14.6003L15.9087 16.6126L16.0924 16.6305C17.7788 15.1041 18.7511 12.8583 18.7511 10.1944Z"
                    fill="#4285F4" />
                  <path
                    d="M10.1788 18.75C12.5895 18.75 14.6133 17.9722 16.0915 16.6305L13.274 14.4916C12.5201 15.0068 11.5081 15.3666 10.1788 15.3666C7.81773 15.3666 5.81379 13.8402 5.09944 11.7305L4.99473 11.7392L2.23868 13.8295L2.20264 13.9277C3.67087 16.786 6.68674 18.75 10.1788 18.75Z"
                    fill="#34A853" />
                  <path
                    d="M5.10014 11.7305C4.91165 11.186 4.80257 10.6027 4.80257 9.99992C4.80257 9.3971 4.91165 8.81379 5.09022 8.26935L5.08523 8.1534L2.29464 6.02954L2.20333 6.0721C1.5982 7.25823 1.25098 8.5902 1.25098 9.99992C1.25098 11.4096 1.5982 12.7415 2.20333 13.9277L5.10014 11.7305Z"
                    fill="#FBBC05" />
                  <path
                    d="M10.1789 4.63331C11.8554 4.63331 12.9864 5.34303 13.6312 5.93612L16.1511 3.525C14.6035 2.11528 12.5895 1.25 10.1789 1.25C6.68676 1.25 3.67088 3.21387 2.20264 6.07218L5.08953 8.26943C5.81381 6.15972 7.81776 4.63331 10.1789 4.63331Z"
                    fill="#EB4335" />
                </svg>
                Continue with Google
              </a>

              <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                  <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                  <span class="px-2 text-gray-500 bg-white">Or register with email</span>
                </div>
              </div>
            </div>

            <!-- Registration Form -->
            <form action="/register" method="POST" id="registerForm" class="space-y-5">
              @csrf

              @if (session('success'))
              <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor" viewBox="0 0 20 20">
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
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                </button>
              </div>
              @endif

              <!-- Username -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Username
                </label>
                <input type="text" id="username" name="username" placeholder="Choose a username"
                  class="block w-full px-4 py-3 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                  value="{{ old('username') }}" required />
                <x-form-error name="username" />
              </div>

              <!-- Email -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Email address
                </label>
                <input type="email" id="email" name="email" placeholder="your@email.com"
                  class="block w-full px-4 py-3 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                  value="{{ old('email') }}" required />
                <x-form-error name="email" />
              </div>

              <!-- Contact Number -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Contact Number
                </label>
                <input type="tel" id="contactno" name="contact_number" placeholder="09123456789"
                  class="block w-full px-4 py-3 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                  value="{{ old('contact_number') }}" required />
                <p class="mt-1 text-xs text-gray-500">Format: 09XXXXXXXXX (11 digits)</p>
                <x-form-error name="contact_number" />
              </div>

              <!-- Password -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Password
                </label>
                <div class="relative">
                  <input type="password" id="password" name="password" placeholder="Create a password"
                    class="block w-full px-4 py-3 pr-10 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                    value="{{ old('password') }}" required />
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
                      class="h-1.5 rounded-full w-0 bg-transparent transition-all duration-300">
                    </div>
                  </div>
                </div>

                <!-- Password Requirements -->
                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mt-2">
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

              <!-- Confirm Password -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Confirm Password
                </label>
                <div x-data="{ showPassword: false }" class="relative">
                  <input :type="showPassword ? 'text' : 'password'" placeholder="Repeat your password"
                    name="password_confirmation"
                    class="block w-full px-4 py-3 pr-10 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none" />
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
              <div class="pt-2">
                <button type="submit"
                  class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-all duration-200 rounded-lg bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Create Account
                </button>
              </div>
            </form>

            <!-- Login Link -->
            <div class="pt-4 text-sm text-center text-gray-500">
              Already have an account? <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">Sign
                in</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Image Section -->
      <div class="relative hidden w-full lg:block lg:w-1/2 bg-cover bg-center right-content" style="
          background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                    url({{ asset('images/vet_spaying.jpg') }}) no-repeat center center;
          background-size: cover;
        ">
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
  <!-- ===== Page Wrapper End ===== -->
</x-auth-layout>