<x-auth-layout>
  <!-- ===== Page Wrapper Start ===== -->
  <div class="relative p-6 bg-white z-1 sm:p-0">
    <div class="relative flex flex-col justify-center w-full h-screen sm:p-0 lg:flex-row">
      <!-- LEFT SIDE: Form -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
          <div>
            <div class="lg:hidden mb-10 sm:mb-10">
              <img src="{{ asset('images/orpawnage-logo.png') }}" class="h-20 mx-auto" alt="Company Logo" />
            </div>

            <div class="mb-5 sm:mb-8">
              <h1 class="mb-2 font-semibold text-gray-800 text-title-sm sm:text-title-md">
                Forgot Password
              </h1>
              <p class="text-sm text-gray-500">
                Enter your email to receive a password reset link
              </p>
            </div>

            @if (session('status'))
            <div id="alert-3" class="flex items-center px-4 py-2 mb-4 text-green-800 rounded-lg bg-green-50"
              role="alert">
              <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                  d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
              </svg>
              <div class="ms-3 text-sm font-medium">
                {{ session('status') }}
              </div>
              <button type="button"
                class="ms-auto bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#alert-3" aria-label="Close">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
              </button>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="space-y-5">
                <!-- Email -->
                <div>
                  <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Email<span class="text-error-500">*</span>
                  </label>
                  <input type="email" id="email" name="email" placeholder="info@gmail.com"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10"
                    value="{{ old('email') }}" required autofocus />

                  <x-form-error name="email" />
                </div>

                <!-- Button -->
                <div class="mt-10">
                  <button
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                    Send Reset Link
                  </button>
                </div>
              </div>
            </form>

            <div class="mt-5">
              <p class="text-sm font-normal text-center text-gray-700 sm:text-start">
                Remember your password?
                <a href="/login" class="text-brand-500 hover:text-brand-600">Sign In</a>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE: Responsive Background Image with Overlay and Centered Logo -->
      <div class="relative hidden w-full h-full lg:grid lg:w-1/2 bg-cover bg-center" style="
          background: gray url({{ asset('images/vet_service.jpg') }}) no-repeat
            center center;
          background-size: cover;
          background-blend-mode: luminosity;
        ">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Centered Logo -->
        <div class="relative z-10 flex items-center justify-center w-full h-full">
          <img src="{{ asset('images/orpawnage-logo.png') }}" alt="Logo" class="block w-28 sm:w-32 md:w-36 lg:w-40" />
        </div>
      </div>
    </div>
  </div>
  <!-- ===== Page Wrapper End ===== -->
</x-auth-layout>