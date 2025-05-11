<!DOCTYPE html>
<html lang="en" class="scroll-smooth scrollbar-hidden">

<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OrPAWnage | {{ Route::currentRouteName() ? ucwords(str_replace('.', ' ', Route::currentRouteName())) : '' }}
  </title>
  <link rel="icon" href="{{ asset('images/orpawnage-logo.png') }}" type="image/png" sizes="16x16">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  @vite(['resources/css/admin/fonts/phosphor/phosphor-fill.css', 'resources/css/admin/fonts/phosphor/phosphor.css'])
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="{{ asset('js/theme.js') }}"></script>

  @vite(['resources/css/preloader.css', 'resources/css/style.css'])

  <style>
    /* Add this custom CSS for the link animation */
    .nav-link {
      position: relative;
      display: inline-block;
      color: #1f2937;
      /* gray-900 */
      text-decoration: none;
      padding: 0.25rem 0;
      transition: color 0.3s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 0;
      height: 2px;
      background-color: #f97316;
      /* orange-500 */
      transition: width 0.3s ease;
    }

    .nav-link:hover {
      color: #ff6600;
      /* orange-500 */
    }

    .nav-link:hover::after {
      width: 100%;
    }

    /* For active state */
    .nav-link.active {
      font-weight: 500;
      color: #ff6600;
      /* orange-500 */
    }

    .nav-link.active::after {
      width: 100%;
      background-color: #ff6600;
      height: 3px;
    }
  </style>

  @vite(['resources/css/orpawnage-animation.css'])
</head>

<body class="mx-auto max-w-[1920px] relative">
  <!-- ===== Preloader Start ===== -->
  <div id="preloader" class="preloader">
    <div class="dog">
      <div class="torso">
        <div class="fur">
          <div class="spot"></div>
        </div>
        <div class="neck">
          <div class="fur"></div>
          <div class="head">
            <div class="fur">
              <div class="snout"></div>
            </div>
            <div class="ears">
              <div class="ear">
                <div class="fur"></div>
              </div>
              <div class="ear">
                <div class="fur"></div>
              </div>
            </div>
            <div class="eye"></div>
          </div>
          <div class="collar"></div>
        </div>
        <div class="legs">
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
        </div>
        <div class="tail">
          <div class="tail">
            <div class="tail">
              <div class="tail -end">
                <div class="tail">
                  <div class="tail">
                    <div class="tail">
                      <div class="tail"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== Preloader End ===== -->

  <div class="bg-white">
    <header class="absolute inset-x-0 top-0 z-50">
      <!-- ========== START OF NAVBAR ========== -->
      <nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200 shadow-sm">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
          <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('images/orpawnage-logo.png') }}" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-orange-400">Or<strong
                class="text-yellow-400">PAW</strong>nage</span>
          </a>

          <!-- Dropdown Menu Button -->
          <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse transition duration-300">
            <button type="button"
              class="flex items-center justify-center text-sm bg-transparent rounded-full md:me-0 focus:ring-4 focus:ring-orange-400/40 relative"
              id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
              data-dropdown-placement="bottom">

              <span class="sr-only">Open user menu</span>

              <!-- Ping animation -->
              <div class="absolute inset-0 flex items-center justify-center -m-1 z-0 pointer-events-none">
                <span class="block w-10 h-10 bg-orange-400 rounded-full animate-ping-slow opacity-60"></span>
              </div>

              <!-- Actual icon -->
              <svg
                class="relative z-10 w-8 h-8 rounded-full bg-orange-500 hover:bg-yellow-400 transition-colors duration-300"
                xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#fff" viewBox="0 0 256 256">
                <path
                  d="M172,120a44,44,0,1,1-44-44A44.05,44.05,0,0,1,172,120Zm60,8A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88.09,88.09,0,0,0-91.47-87.93C77.43,41.89,39.87,81.12,40,128.25a87.65,87.65,0,0,0,22.24,58.16A79.71,79.71,0,0,1,84,165.1a4,4,0,0,1,4.83.32,59.83,59.83,0,0,0,78.28,0,4,4,0,0,1,4.83-.32,79.71,79.71,0,0,1,21.79,21.31A87.62,87.62,0,0,0,216,128Z">
                </path>
              </svg>

            </button>

            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-md"
              id="user-dropdown">
              <div class="px-4 py-3">
                <span class="block text-sm text-gray-900">Your Account</span>
                <span class="block text-sm text-gray-500 truncate truncate">
                  @if (Auth::check())
                  {{ Auth::user()->email }}
                  @endif
                </span>
              </div>
              <ul class="py-2 transition-colors duration-300" aria-labelledby="user-menu-button">
                @if (Auth::user()->isAdmin)
                <li class="mx-4 flex items-center gap-x-2 text-gray-700 mx-1 nav-link">
                  <i class="ph-fill ph-grid-four"></i>
                  <a href="/admin" target="_blank" class="block py-2 text-sm">Go to
                    Admin Dashboard</a>
                </li>
                @endif

                <li class="mx-4 flex items-center gap-x-2 text-gray-700 rounded-full mx-1 nav-link">
                  <i class="ph-fill ph-bell"></i>
                  <a href="/transactions" class="block py-2 text-sm">Transaction
                    Status</a>
                </li>

                <li class="mx-4 flex items-center gap-x-2 text-gray-700 rounded-full mx-1 nav-link">
                  <i class="ph-fill ph-gear"></i>
                  <a href="/settings" class="block py-2 text-sm">Profile
                    Settings</a>
                </li>
                <li class="mx-4 mb-2 flex items-center gap-x-2 text-gray-700 rounded-full mx-1 nav-link">
                  <i class="ph-fill ph-sign-out"></i>
                  <form action="/logout" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="block py-2 text-sm">
                      Sign Out</button>
                  </form>
                </li>
              </ul>
            </div>
            <button data-collapse-toggle="navbar-user" type="button"
              class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
              aria-controls="navbar-user" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M1 1h15M1 7h15M1 13h15" />
              </svg>
            </button>
          </div>
          <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
              class="flex flex-col gap-y-4 font-normal p-4 sm:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 sm:flex-row sm:mt-0 sm:border-0 sm:bg-white transition-colors duration-300">
              <!-- HOME -->
              <li class="sm:mr-6">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
              </li>

              <!-- FEATURED PETS -->
              <li class="sm:mr-6">
                <a href="/featured-pets" class="nav-link {{ request()->is('featured-pets') ? 'active' : '' }}">Featured
                  Pets</a>
              </li>

              <!-- SERVICES -->
              <li class="sm:mr-6">
                <button id="dropdownNavbarLink1" data-dropdown-toggle="dropdownNavbar1"
                  class="nav-link flex items-center justify-between w-full md:w-auto {{ request()->is('services/adopt-a-pet') || request()->is('services/surrender-an-animal') ? 'active' : '' }}">
                  Services
                  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 4 4 4-4" />
                  </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbar1"
                  class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-md w-44 transition-colors duration-300">
                  <ul class="p-4 text-md text-gray-700 transition-colors duration-300 space-y-2"
                    aria-labelledby="dropdownLargeButton">
                    <li>
                      <a href="/services/adopt-a-pet"
                        class="nav-link block rounded-full mx-1 transition-colors duration-300">Adopt a
                        Pet</a>
                    </li>
                    <li>
                      <a href="/services/surrender-an-animal"
                        class="nav-link block rounded-full mx-1 transition-colors duration-300">Surrender
                        a Pet</a>
                    </li>
                  </ul>
                </div>
              </li>

              <!-- REPORT -->
              <li class="sm:mr-6">
                <button id="dropdownNavbarLink2" data-dropdown-toggle="dropdownNavbar2"
                  class="nav-link flex items-center justify-between w-full md:w-auto {{ request()->is('report/missing-pet') || request()->is('report/abused-stray-animal') ? 'active' : '' }}">
                  Report
                  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 4 4 4-4" />
                  </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbar2"
                  class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-md w-50 transition-colors duration-300">
                  <ul class="p-4 text-md text-gray-700 transition-colors duration-300 space-y-2"
                    aria-labelledby="dropdownLargeButton">
                    <li>
                      <a href="/report/missing-pet"
                        class="nav-link block rounded-full mx-1 transition-colors duration-300">Missing
                        Pet</a>
                    </li>
                    <li>
                      <a href="/report/abused-stray-animal"
                        class="nav-link block rounded-full mx-1 transition-colors duration-300">Abused /
                        Stray Animal</a>
                    </li>
                  </ul>
                </div>
              </li>

              <!-- SUCCESSFUL ADOPTION -->
              <li class="sm:mr-6">
                <a href="/featured-adoptions"
                  class="nav-link {{ request()->is('featured-adoptions') ? 'active' : '' }}">Featured Adoptions</a>
              </li>

              <!-- ABOUT US -->
              <li class="sm:mr-6">
                <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">About Us</a>
              </li>

              <!-- DONATE -->
              <li class="sm:mr-6">
                <a href="/donate" class="nav-link {{ request()->is('donate') ? 'active' : '' }}">Donate</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- ========== END OF NAVBAR ========== -->
    </header>

    @auth
    @if (!auth()->user()->hasVerifiedEmail())
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-4 text-center">
      Your email is not verified.
      <a href="{{ route('verification.notice') }}" class="underline font-semibold">Click here to verify</a>.
    </div>
    @endif
    @endauth

    @if (session('status') === 'already-verified')
    <div class="bg-blue-100 border border-blue-400 text-blue-700 p-4 text-center">
      Your email is already verified.
    </div>
    @endif

    @if (session('status') === 'email-verified')
    <div class="bg-green-100 border border-green-400 text-green-700 p-4 text-center">
      Your email has already been verified. Welcome back!
    </div>
    @endif

    {{ $slot }}

    <!-- ========== START OF FOOTER ========== -->
    @if (!str_contains(request()->path(), 'transactions') && !str_contains(request()->path(), 'settings'))
    <footer class="bg-yellow-300 w-full mt-auto {{ request()->is('transactions') }}">
      <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-around">
          <div class="flex items-center space-x-4 mb-6 md:mb-0">
            <a href="/" class="flex items-center">
              <img src="{{ asset('images/orpawnage-logo.png') }}" class="w-[100px] h-[100px]" alt="Brand Logo 1" />
            </a>
            <a href="/" class="flex items-center">
              <img src="{{ asset('images/cityvet_logo.png') }}" class="w-[150px] h-[100px]" alt="Brand Logo 2" />
            </a>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-10">
            <div>
              <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">
                Services
              </h2>
              <ul class="text-gray-500 font-medium">
                <li class="mb-4">
                  <a href="/services/adopt-a-pet"
                    class="hover:text-orange-500 transition-colors duration-300 nav-link">Adopt</a>
                </li>
                <li class="mb-4">
                  <a href="/services/surrender-an-animal"
                    class="hover:text-orange-500 transition-colors duration-300 nav-link">Surrender</a>
                </li>
                <li class="mb-4">
                  <a href="/report/missing-pet"
                    class="hover:text-orange-500 transition-colors duration-300 nav-link">Report a
                    Missing Pet</a>
                </li>
                <li class="mb-4">
                  <a href="/report/abused-stray-animal"
                    class="hover:text-orange-500 transition-colors duration-300 nav-link">Report an Abused / Stray
                    Pet</a>
                </li>
                <li class="mb-4">
                  <a href="/donate" class="hover:text-orange-500 transition-colors duration-300 nav-link">Donate</a>
                </li>
              </ul>
            </div>

            <div>
              <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">
                Contact Us
              </h2>
              <ul class="text-gray-500 font-medium">
                <li class="mb-4 flex items-center space-x-2 hover:text-orange-500 transition-colors duration-300">
                  <i class="ph-fill ph-phone text-lg"></i>
                  <a href="#" class="hover:text-orange-500 transition-colors duration-300 nav-link">09123456789</a>
                </li>
                <li class="mb-4 flex items-center space-x-2 hover:text-orange-500 transition-colors duration-300">
                  <i class="ph-fill ph-envelope text-lg"></i>
                  <a href="#"
                    class="hover:text-orange-500 transition-colors duration-300 nav-link">orpawnageteam@gmail.com</a>
                </li>
                <li class="mb-4 flex items-center space-x-2 hover:text-orange-500 transition-colors duration-300">
                  <i class="ph-fill ph-facebook-logo text-lg"></i>
                  <a href="#" class="hover:text-orange-500 transition-colors duration-300 nav-link">Angeles City
                    Veterinary Office</a>
                </li>
              </ul>

            </div>
          </div>
        </div>

        <hr class="my-6 border-gray-500 sm:mx-auto lg:my-8" />

        <div class="text-white sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center">
            © 2025 <strong>OrPAWnage</strong>™. All Rights Reserved.
          </span>
          <div class="flex gap-x-4 mt-4 sm:justify-center sm:mt-0">
            <a href="#" class="text-gray-500 hover:text-orange-500 transition-colors duration-300">Terms &
              Conditions</a>
            <a href="#" class="text-gray-500 hover:text-orange-500 transition-colors duration-300">Privacy &
              Policy</a>
          </div>
        </div>
      </div>
    </footer>
    @endif
    <!-- ========== END OF FOOTER ========== -->
  </div>

  <!-- Scroll to Top Button -->
  <button id="scrollToTop" class="fixed bottom-20 right-8 z-10 hidden bg-orange-500 hover:bg-yellow-400 hover:text-black 
text-white text-lg font-bold w-12 h-12 flex items-center justify-center rounded-full transition-opacity duration-300">
    <i class="ph-fill ph-arrow-up"></i>
  </button>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="{{ asset('js/heroSlider.js') }}"></script>
  <script src="{{ asset('js/preloader.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="{{ asset('js/seemore.js') }}"></script>
  <script src="{{ asset('js/modal.js') }}"></script>
  <script src="{{ asset('js/disableSubmission.js') }}"></script>
  <script src="{{ asset('js/scrollToTop.js') }}"></script>
</body>

</html>