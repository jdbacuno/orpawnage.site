<x-auth-layout>
  <!-- ===== Page Wrapper Start ===== -->
  <div class="relative p-6 bg-white z-1 sm:p-0">
    <div class="relative flex flex-col justify-center w-full h-screen sm:p-0 lg:flex-row">
      <!-- LEFT SIDE: Form -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto px-4 sm:px-6">
          <div class="space-y-8">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-8">
              <img src="{{ asset('images/orpawnage-logo.png') }}" class="h-24 mx-auto" alt="OrPAWnage Logo" />
            </div>

            <!-- Header -->
            <div class="space-y-3">
              <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                Reset Your Password
              </h1>
              <p class="text-gray-500">
                Enter your email and we'll send you a link to reset your password
              </p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
            <div id="alert" class="flex items-start p-4 mb-6 text-green-800 bg-green-50 rounded-lg" role="alert">
              <svg class="flex-shrink-0 w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path
                  d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
              </svg>
              <div class="ml-3 text-sm font-medium">
                {{ session('status') }}
              </div>
              <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert" aria-label="Close">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
              </button>
            </div>
            @endif

            <!-- Reset Form -->
            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" class="space-y-6">
              @csrf

              <!-- Email Field -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Email address
                </label>
                <input type="email" id="email" name="email" placeholder="your@email.com" autocomplete="email" autofocus
                  class="block w-full px-4 py-3 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                  value="{{ old('email') }}" required />
                <x-form-error name="email" />
              </div>

              <!-- Submit Button -->
              <div>
                <button type="submit"
                  class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-all duration-200 rounded-lg bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Send Reset Link
                </button>
              </div>
            </form>

            <!-- Back to Login -->
            <div class="text-sm text-center text-gray-500">
              Remember your password? <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">Sign
                in</a>
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
  <!-- ===== Page Wrapper End ===== -->
</x-auth-layout>