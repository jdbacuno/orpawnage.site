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
  @vite(['resources/css/orpawnage-animation.css'])

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
      background-color: #ff7206;
      /* orange-500 */
      transition: width 0.3s ease;
    }

    .nav-link:hover {
      color: #ff7206;
      /* orange-500 */
    }

    .nav-link:hover::after {
      width: 100%;
    }

    /* For active state */
    .nav-link.active {
      font-weight: 500;
      color: #ff7206;
      /* orange-500 */
    }

    .nav-link.active::after {
      width: 100%;
      background-color: #ff7206;
      height: 2px;
    }

    /* Add this to your existing styles */
    .mobile-dropdown {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-out;
    }

    .mobile-dropdown.open {
      max-height: 500px;
      /* Adjust based on your content */
      transition: max-height 0.5s ease-in;
    }

    .tab-button.border-orange-500 {
      border-color: #ff7206;
    }

    .tab-button.text-orange-600 {
      color: #ea580c;
    }

    .tab-button.border-transparent {
      border-color: transparent;
    }

    .tab-button.text-gray-500 {
      color: #6b7280;
    }

    @media (width: 912px) {
      #title {
        display: none;
      }
    }

    @media (min-width: 768px) and (max-width: 912px) {
      .logos {
        flex-direction: column;
        justify-content: space-evenly;
      }

      .footer-content {
        row-gap: 10px
      }
    }

    .custom-gradient {
      background: linear-gradient(15deg, #ffd745 0%, #fffef5 40%) !important;
    }

    .footer-gradient {
      background: linear-gradient(-165deg, #ffd745 0%, #fffef5 40%) !important;
    }
  </style>
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
  <!-- ===== Preloader End ===== -->

  <div class="bg-white">
    <header class="absolute inset-x-0 z-50">
      <!-- ========== START OF NAVBAR ========== -->
      <!-- Admin Indicator Bar -->
      <nav id="main-header" class="bg-white fixed w-full z-20 start-0 border-b border-gray-200 shadow-sm">
        @if (Auth::check() && Auth::user()->isAdmin)
        <div id="adminIndicator" class="footer-gradient text-black font-semibold text-center py-2 px-4 shadow-md">
          <div class="flex items-center justify-center gap-2 flex-wrap">
            <i class="ph-fill ph-shield-check text-lg"></i>
            <span class="text-sm sm:text-base">You are viewing as an Administrator</span>
            <a href="/admin"
              class="ml-2 sm:ml-4 bg-yellow-500 hover:bg-yellow-200 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm transition-colors duration-200">
              Go to Admin Dashboard
            </a>
          </div>
        </div>
        @endif

        <div class="max-w-screen-xl flex flex-wrap gap-y-4 items-center justify-between mx-auto p-4">
          <a href="/" class="flex items-center space-x-3">
            <img src="{{ asset('images/orpawnage-brand-logo-2.PNG') }}" class="h-8" alt="Flowbite Logo" />
            {{-- <span class="self-center text-2xl font-semibold whitespace-nowrap text-orange-400" id="title">Or<strong
                class="text-yellow-500">PAW</strong>nage</span> --}}
          </a>

          <!-- Dropdown Menu Button -->
          <div class="flex items-center md:order-2 space-x-3 transition duration-300">
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
            <div
              class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 border-t border-t-orange-400 rounded-lg shadow-md"
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

                <!-- Add this near the user dropdown menu items in layout.blade.php -->
                @unless(Auth::user()->is_banned)
                <li class="mx-4 flex items-center gap-x-2 text-gray-700 rounded-full mx-1 nav-link">
                  <i class="ph-fill ph-gear"></i>
                  <button onclick="openSettingsModal()" class="block py-2 text-sm">Profile Settings</button>
                </li>
                @endunless
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
              <li class="xl:mr-6 md:mr-4">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
              </li>

              <!-- FEATURED PETS -->
              <li class="xl:mr-6 md:mr-4">
                <a href="/featured-pets" class="nav-link {{ request()->is('featured-pets') ? 'active' : '' }}">Featured
                  Pets</a>
              </li>

              <!-- SERVICES -->
              <li class="xl:mr-6 md:mr-4">
                <div class="relative">
                  <!-- Desktop dropdown trigger (button) -->
                  <button id="dropdownNavbarLink1" data-dropdown-toggle="dropdownNavbar1"
                    class="hidden md:flex nav-link items-center justify-between w-full md:w-auto {{ request()->is('services/adopt-a-pet') || request()->is('services/surrender-an-animal') ? 'active' : '' }}">
                    Services
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                    </svg>
                  </button>

                  <!-- Mobile dropdown trigger (button) -->
                  <button id="mobileDropdownNavbarLink1" onclick="toggleMobileDropdown('mobileDropdownNavbar1')"
                    class="md:hidden flex nav-link items-center justify-between w-full {{ request()->is('services/adopt-a-pet') || request()->is('services/surrender-an-animal') ? 'active' : '' }}">
                    Services
                    <svg id="mobileDropdownNavbarLink1Icon"
                      class="w-2.5 h-2.5 ms-2.5 transform transition-transform duration-300" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                    </svg>
                  </button>

                  <!-- Desktop dropdown menu -->
                  <div id="dropdownNavbar1"
                    class="z-10 hidden font-normal bg-white divide-y divide-gray-100 border-t border-t-orange-400 rounded-lg shadow-md w-56 transition-colors duration-300">
                    <ul class="p-4 text-md text-gray-700 transition-colors duration-300 space-y-2"
                      aria-labelledby="dropdownLargeButton">
                      <li>
                        <a href="/services/adopt-a-pet"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Adopt a Pet</a>
                      </li>
                      <li>
                        <a href="/services/surrender-an-animal"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Surrender a Pet</a>
                      </li>
                    </ul>
                  </div>

                  <!-- Mobile dropdown menu -->
                  <div id="mobileDropdownNavbar1" class="mobile-dropdown md:hidden">
                    <ul class="py-2 pl-4 text-md text-gray-700 space-y-2">
                      <li>
                        <a href="/services/adopt-a-pet"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Adopt a Pet</a>
                      </li>
                      <li>
                        <a href="/services/surrender-an-animal"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Surrender a Pet</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>

              <!-- REPORT -->
              <li class="xl:mr-6 md:mr-4">
                <div class="relative">
                  <!-- Desktop dropdown trigger (button) -->
                  <button id="dropdownNavbarLink2" data-dropdown-toggle="dropdownNavbar2"
                    class="hidden md:flex nav-link items-center justify-between w-full md:w-auto {{ request()->is('report/missing-pet') || request()->is('report/abused-stray-animal') ? 'active' : '' }}">
                    Report
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                    </svg>
                  </button>

                  <!-- Mobile dropdown trigger (button) -->
                  <button id="mobileDropdownNavbarLink2" onclick="toggleMobileDropdown('mobileDropdownNavbar2')"
                    class="md:hidden flex nav-link items-center justify-between w-full {{ request()->is('report/missing-pet') || request()->is('report/abused-stray-animal') ? 'active' : '' }}">
                    Report
                    <svg id="mobileDropdownNavbarLink2Icon"
                      class="w-2.5 h-2.5 ms-2.5 transform transition-transform duration-300" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                    </svg>
                  </button>

                  <!-- Desktop dropdown menu -->
                  <div id="dropdownNavbar2"
                    class="z-10 hidden font-normal bg-white divide-y divide-gray-100 border-t border-t-orange-400 rounded-lg shadow-md w-56 transition-colors duration-300">
                    <ul class="p-4 text-md text-gray-700 transition-colors duration-300 space-y-2"
                      aria-labelledby="dropdownLargeButton">
                      <li>
                        <a href="/report/missing-pet"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Missing Pet</a>
                      </li>
                      <li>
                        <a href="/report/abused-stray-animal"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Abused / Stray
                          Animal</a>
                      </li>
                    </ul>
                  </div>

                  <!-- Mobile dropdown menu -->
                  <div id="mobileDropdownNavbar2" class="mobile-dropdown md:hidden">
                    <ul class="py-2 pl-4 text-md text-gray-700 space-y-2">
                      <li>
                        <a href="/report/missing-pet"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Missing Pet</a>
                      </li>
                      <li>
                        <a href="/report/abused-stray-animal"
                          class="nav-link block rounded-full mx-1 transition-colors duration-300">Abused / Stray
                          Animal</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>

              <!-- SUCCESSFUL ADOPTION -->
              <li class="xl:mr-6 md:mr-4">
                <a href="/featured-adoptions"
                  class="nav-link {{ request()->is('featured-adoptions') ? 'active' : '' }}">Adopted Pets</a>
              </li>

              <!-- ABOUT US -->
              <li class="xl:mr-6 md:mr-4">
                <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">About Us</a>
              </li>

              <!-- DONATE -->
              <li class="xl:mr-6 md:mr-4 lg:mr-4">
                <a href="/donate" class="nav-link {{ request()->is('donate') ? 'active' : '' }}">Donate</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- ========== END OF NAVBAR ========== -->
    </header>

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
    <footer class="footer-gradient w-full mt-auto px-10 {{ request()->is('transactions') }}">
      <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-around footer-content">
          <div class="flex items-center gap-x-4 logos mb-6 md:mb-0">
            <a href="/" class="flex items-center">
              <img src="{{ asset('images/orpawnage-logo.png') }}"
                class="w-[80px] h-[80px] sm:w-[90px] sm:h-[90px] md:w-[100px] md:h-[100px] lg:w-[130px] lg:h-[130px] xl:w-[200px] xl:h-[200px] object-fill"
                alt="Brand Logo 1" />
            </a>

            <a href="/" class="flex items-center">
              <img src="{{ asset('images/orpawnage-brand-logo.png') }}"
                class="w-[90px] h-[80px] sm:w-[100px] sm:h-[90px] md:w-[120px] md:h-[100px] lg:w-[130px] lg:h-[120px] xl:w-[250px] xl:h-[200px] object-cover"
                alt="Brand Logo 2" />
            </a>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-10">
            <div>
              <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase flex items-center gap-2">
                <i class="ph-fill ph-list text-orange-400"></i> Our Services
              </h2>
              <ul class="text-gray-600 font-medium space-y-3">
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <a href="/services/adopt-a-pet" class="flex items-center gap-2 nav-link">
                    <i class="ph-fill ph-heart text-orange-400"></i>
                    Adopt a Pet
                  </a>
                </li>
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <a href="/services/surrender-an-animal" class="flex items-center gap-2 nav-link">
                    <i class="ph-fill ph-hand-palm text-orange-400"></i>
                    Surrender a Pet
                  </a>
                </li>
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <a href="/report/missing-pet" class="flex items-center gap-2 nav-link">
                    <i class="ph-fill ph-magnifying-glass text-orange-400"></i>
                    Report Missing Pet
                  </a>
                </li>
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <a href="/report/abused-stray-animal" class="flex items-center gap-2 nav-link">
                    <i class="ph-fill ph-warning text-orange-400"></i>
                    Report Abused/Stray
                  </a>
                </li>
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <a href="/donate" class="flex items-center gap-2 nav-link">
                    <i class="ph-fill ph-currency-circle-dollar text-orange-400"></i>
                    Donate
                  </a>
                </li>
              </ul>
            </div>

            <div>
              <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase flex items-center gap-2">
                <i class="ph-fill ph-chat-dots text-orange-400"></i> Contact Us
              </h2>
              <p class="text-gray-500 text-sm mb-4">We'd love to hear from you! Reach us anytime:</p>
              <ul class="text-gray-600 font-medium space-y-3">
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <i class="ph-fill ph-phone text-orange-400"></i>
                  <a href="tel:09123456789" class="nav-link">0912 345 6789</a>
                </li>
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <i class="ph-fill ph-envelope text-orange-400"></i>
                  <a href="mailto:orpawnagedevelopers@gmail.com" class="nav-link">orpawnagedevelopers@gmail.com</a>
                </li>
                <li class="flex items-center gap-2 pl-4 text-sm">
                  <i class="ph-fill ph-facebook-logo text-orange-400"></i>
                  <a href="https://facebook.com/orpawnage" target="_blank" class="nav-link">
                    Orpawnage Main Office
                  </a>
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
  <button id="scrollToTop" class="fixed bottom-8 right-8 z-10 hidden bg-orange-500 hover:bg-yellow-400 hover:text-black 
text-white text-lg font-bold w-12 h-12 flex items-center justify-center rounded-full transition-opacity duration-300">
    <i class="ph-fill ph-arrow-up"></i>
  </button>

  @php
  // Determine which tab should be active based on the errors
  $activeTab = 'account-tab';
  if ($errors->has('settings_current_password') || $errors->has('settings_password')) {
  $activeTab = 'password-tab';
  } elseif ($errors->has('settings_delete_current_password')) {
  $activeTab = 'danger-tab';
  } elseif ($errors->has('settings_email') || $errors->has('settings_email_current_password') ||
  $errors->has('settings_contact_number') || $errors->has('settings_contact_current_password')) {
  $activeTab = 'account-tab';
  }

  // Check if modal should be open
  $modalOpen = $errors->has('settings_email') || $errors->has('settings_email_current_password') ||
  $errors->has('settings_contact_number') || $errors->has('settings_contact_current_password') ||
  $errors->has('settings_current_password') || $errors->has('settings_password') ||
  $errors->has('settings_delete_current_password');
  @endphp

  <!-- Settings Modal -->
  <div id="settingsModal" class="{{ $modalOpen ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-1 pb-20 text-center sm:block sm:p-0">
      <!-- Background overlay -->
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <!-- Modal content -->
      <div
        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full sm:max-w-3xl sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="w-full">
              <!-- Header -->
              <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">
                  <i class="ph-fill ph-gear mr-2 text-orange-400"></i>Account Settings
                </h3>
                <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-500">
                  <i class="ph-fill ph-x text-2xl"></i>
                </button>
              </div>

              <!-- Tabs -->
              <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                  <button onclick="switchTab('account-tab')" id="account-tab-btn"
                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'account-tab' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500' }}">
                    Account
                  </button>
                  <button onclick="switchTab('password-tab')" id="password-tab-btn"
                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'password-tab' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500' }}">
                    Password
                  </button>
                  @if (!auth()->user()->isAdmin)
                  <button onclick="switchTab('danger-tab')" id="danger-tab-btn"
                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'danger-tab' ? 'border-orange-500 text-orange-500' : 'border-transparent text-gray-500' }}">
                    Danger Zone
                  </button>
                  @endif
                </nav>
              </div>

              <!-- Tab content -->
              <div class="py-4">
                <!-- Success Alert -->
                @if(session('settings-success'))
                <div id="alert-3"
                  class="flex items-center pl-4 pr-6 py-3 mb-4 text-green-800 rounded-lg bg-green-50 border-l-4 border-green-400"
                  role="alert">
                  <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                  </svg>
                  <span class="sr-only">Info</span>
                  <div class="ms-3 text-sm font-medium">
                    {!! session('settings-success') !!}
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

                <!-- Account Tab -->
                <div id="account-tab" class="tab-content {{ $activeTab === 'account-tab' ? 'activeTab' : 'hidden' }}">
                  <!-- Overview / Verification -->
                  <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                      <div class="flex items-start">
                        <i class="ph-fill ph-warning text-yellow-500 text-xl mr-2"></i>
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
                      <form method="POST" action="{{ route('verification.send') }}#settingsModal">
                        @csrf
                        <button type="submit"
                          class="text-sm bg-orange-400 hover:bg-orange-500 text-white px-4 py-2 rounded-md transition">
                          Resend Verification
                        </button>
                      </form>
                      @endunless
                    </div>
                  </div>

                  <!-- Profile & Contact -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email Update -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                      <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="ph-fill ph-envelope mr-2 text-orange-400"></i>Change Email
                      </h3>
                      <form method="POST" action="{{ route('settings.email.update') }}" id="emailUpdateForm">
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
                            <input type="email" name="settings_email" value="{{ old('settings_email') }}" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                              placeholder="New email address">
                            <x-form-error name="settings_email" />
                          </div>
                          <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                            <div class="relative">
                              <input type="password" name="settings_email_current_password" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                                placeholder="Enter your current password">
                              <button type="button" onclick="togglePasswordVisibility(this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                                <i class="ph-fill ph-eye text-lg"></i>
                              </button>
                            </div>
                            <x-form-error name="settings_email_current_password" />
                          </div>
                          <div class="pt-1 flex justify-end">
                            <button type="submit"
                              class="px-4 py-2 bg-orange-400 text-white text-sm font-medium rounded-lg hover:bg-orange-500 transition duration-300 flex items-center justify-center shadow">
                              <i class="ph-fill ph-check-circle mr-2"></i>Save
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>

                    <!-- Contact Number Update -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                      <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="ph-fill ph-phone mr-2 text-orange-400"></i>Update Contact
                      </h3>
                      <form method="POST" action="{{ route('settings.contact.update') }}" id="contactUpdateForm">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-4">
                          <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Current Number</label>
                            <input type="tel" value="{{ auth()->user()->contact_number ?: 'Not Set (Please update)' }}"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100" readonly>
                          </div>
                          <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">New Phone Number</label>
                            <input type="tel" name="settings_contact_number"
                              value="{{ old('settings_contact_number') }}" pattern="^09\d{9}$" maxlength="11"
                              placeholder="09XXXXXXXXX" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400">
                            <p class="mt-1 text-xs text-gray-500">Format: 09XXXXXXXXX (11 digits)</p>
                            <x-form-error name="settings_contact_number" />
                          </div>
                          <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                            <div class="relative">
                              <input type="password" name="settings_contact_current_password" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                                placeholder="Enter your current password">
                              <button type="button" onclick="togglePasswordVisibility(this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                                <i class="ph-fill ph-eye text-lg"></i>
                              </button>
                            </div>
                            <x-form-error name="settings_contact_current_password" />
                          </div>
                          <div class="pt-1 flex justify-end">
                            <button type="submit"
                              class="px-4 py-2 bg-orange-400 text-white text-sm font-medium rounded-lg hover:bg-orange-500 transition duration-300 flex items-center justify-center shadow">
                              <i class="ph-fill ph-check-circle mr-2"></i>Save
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Password Tab -->
                <div id="password-tab" class="tab-content {{ $activeTab === 'password-tab' ? 'activeTab' : 'hidden' }}">
                  <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                      <i class="ph-fill ph-lock mr-2 text-orange-400"></i>
                      @if(auth()->user()->signed_up_with_google && !auth()->user()->has_set_password)
                      Set a Password
                      @else
                      Change Password
                      @endif
                    </h3>

                    @if(auth()->user()->signed_up_with_google && !auth()->user()->has_set_password)
                    <form method="POST" action="{{ route('settings.password.setup') }}" id="passwordSetupForm">
                      @csrf
                      @method('PATCH')
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                          <label class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
                          <div class="relative">
                            <input type="password" name="settings_password" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                              placeholder="Choose a password">
                            <button type="button" onclick="togglePasswordVisibility(this)"
                              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                              <i class="ph-fill ph-eye text-lg"></i>
                            </button>
                          </div>
                          <x-form-error name="settings_password" />

                          <div class="mt-2 space-y-2">
                            <p id="strength-text" class="text-xs text-blue-700">Start typing to see strength...</p>
                            <div class="h-1.5 mt-1 rounded-full w-full bg-transparent">
                              <div id="strength-progress"
                                class="h-1.5 rounded-full w-0 bg-transparent transition-all duration-300"></div>
                            </div>
                          </div>

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
                            <input type="password" name="settings_password_confirmation" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                              placeholder="Confirm your password">
                            <button type="button" onclick="togglePasswordVisibility(this)"
                              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                              <i class="ph-fill ph-eye text-lg"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="pt-3 flex justify-end">
                        <button type="submit"
                          class="px-5 py-2.5 bg-orange-400 text-white text-sm font-medium rounded-lg hover:bg-orange-500 transition duration-300 flex items-center justify-center shadow">
                          <i class="ph-fill ph-check-circle mr-2"></i>Set Password
                        </button>
                      </div>
                    </form>
                    @else
                    <!-- Existing password change form -->
                    <form method="POST" action="{{ route('settings.password.update') }}" id="passwordChangeForm">
                      @csrf
                      @method('PATCH')
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                          <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                          <div class="relative">
                            <input type="password" name="settings_current_password" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                              placeholder="Current password">
                            <button type="button" onclick="togglePasswordVisibility(this)"
                              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                              <i class="ph-fill ph-eye text-lg"></i>
                            </button>
                          </div>
                          <x-form-error name="settings_current_password" />
                        </div>
                        <div>
                          <label class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
                          <div class="relative">
                            <input type="password" id="password" name="settings_password" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                              placeholder="New password">
                            <button type="button" onclick="togglePasswordVisibility(this)"
                              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                              <i class="ph-fill ph-eye text-lg"></i>
                            </button>
                          </div>
                          <x-form-error name="settings_password" />

                          <div class="mt-2 space-y-2">
                            <p id="strength-text" class="text-xs text-blue-700">Start typing to see strength...</p>
                            <div class="h-1.5 mt-1 rounded-full w-full bg-transparent">
                              <div id="strength-progress"
                                class="h-1.5 rounded-full w-0 bg-transparent transition-all duration-300"></div>
                            </div>
                          </div>

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
                          <label class="block text-sm font-medium text-gray-600 mb-1">Confirm New Password</label>
                          <div class="relative">
                            <input type="password" name="settings_password_confirmation" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                              placeholder="Confirm new password">
                            <button type="button" onclick="togglePasswordVisibility(this)"
                              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                              <i class="ph-fill ph-eye text-lg"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="pt-3 flex justify-end">
                        <button type="submit"
                          class="px-5 py-2.5 bg-orange-400 text-white text-sm font-medium rounded-lg hover:bg-orange-500 transition duration-300 flex items-center justify-center shadow">
                          <i class="ph-fill ph-check-circle mr-2"></i>Update Password
                        </button>
                      </div>
                    </form>
                    @endif
                  </div>
                </div>

                <!-- Danger Zone Tab -->
                <div id="danger-tab" class="tab-content {{ $activeTab === 'danger-tab' ? 'activeTab' : 'hidden' }}">
                  @if (!auth()->user()->isAdmin)
                  <div class="bg-red-50 p-6 rounded-xl border border-red-200 shadow-sm">
                    <h3 class="text-base font-semibold text-red-800 mb-4 flex items-center">
                      <i class="ph-fill ph-trash mr-2 text-red-500"></i>Delete Account
                    </h3>

                    @if(auth()->user()->signed_up_with_google && !auth()->user()->has_set_password)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-r-lg">
                      <div class="flex items-center">
                        <i class="ph-fill ph-warning text-yellow-500 text-xl mr-2"></i>
                        <p class="text-sm text-gray-700">
                          You signed up with Google. To delete your account, you must first
                          <a href="#" onclick="switchTab('password-tab')" class="text-orange-500 hover:underline">
                            set a password
                          </a>.
                        </p>
                      </div>
                    </div>
                    @else
                    <p class="text-sm text-gray-700 mb-4">
                      Once you delete your account, there is no going back. Please be certain.
                    </p>

                    <form method="POST" action="{{ route('settings.delete') }}" id="deleteAccountForm">
                      @csrf
                      @method('DELETE')
                      <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                        <div class="relative">
                          <input type="password" name="settings_delete_current_password" required
                            class="w-full border border-red-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-300 focus:border-red-400"
                            placeholder="Enter your current password">
                          <button type="button" onclick="togglePasswordVisibility(this)"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                            <i class="ph-fill ph-eye text-lg"></i>
                          </button>
                        </div>
                        <x-form-error name="settings_delete_current_password" />
                      </div>
                      <div class="pt-3 flex justify-end">
                        <button type="submit"
                          class="px-5 py-2.5 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition duration-300 flex items-center justify-center shadow">
                          <i class="ph-fill ph-warning-circle mr-2"></i>Delete Account Permanently
                        </button>
                      </div>
                    </form>
                    @endif
                  </div>
                  @endif
                </div>
              </div>
              <!-- End Tab content -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Settings Modal Functions
    function openSettingsModal() {
      document.getElementById('settingsModal').classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
      // Reset to first tab when opening
      switchTab('account-tab');
    }

    function closeSettingsModal() {
      document.getElementById('settingsModal').classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
      window.location.hash = '';
      history.replaceState(null, null);
    }
    
    // Update your DOMContentLoaded event listener
    document.addEventListener('DOMContentLoaded', function() {
      // Check if we should open the modal (from URL hash)
      if (window.location.hash.includes('settingsModal')) {
        openSettingsModal();
        
        // Parse the tab parameter from the URL
        const urlParams = new URLSearchParams(window.location.hash.split('?')[1]);
        const tab = urlParams.get('tab');
        
        // Switch to the specified tab if valid
        if (tab && ['account-tab', 'password-tab', 'danger-tab'].includes(tab)) {
            switchTab(tab);
        }
      }
    });

    // Modify your switchTab function to update URL
    function switchTab(tabId) {
      // Hide all tab contents
      document.querySelectorAll('.tab-content').forEach(tab => {
          tab.classList.add('hidden');
          tab.classList.remove('activeTab');
      });
      
      // Deactivate all tab buttons
      document.querySelectorAll('.tab-button').forEach(button => {
          button.classList.remove('border-orange-500', 'text-orange-500');
          button.classList.add('border-transparent', 'text-gray-500');
      });
      
      // Show selected tab content
      document.getElementById(tabId).classList.remove('hidden');
      document.getElementById(tabId).classList.add('activeTab');
      
      // Activate selected tab button
      const tabButton = document.getElementById(tabId + '-btn');
      tabButton.classList.remove('border-transparent', 'text-gray-500');
      tabButton.classList.add('border-orange-500', 'text-orange-500');
      
      // Update URL without reloading
      history.replaceState(null, null, '#settingsModal?tab=' + tabId);
    }

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
      
      // You can add validation or other logic here before submission
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      // Submit the form after validation
      this.submit();
    });

    document.getElementById('contactUpdateForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // You can add validation or other logic here before submission
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      // Submit the form after validation
      this.submit();
    });

    document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // You can add validation or other logic here before submission
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      // Submit the form after validation
      this.submit();
    });

    document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // You can add validation or other logic here before submission
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      // Submit the form after validation
      this.submit();
    });

    // Add this to your existing script section
    document.getElementById('passwordSetupForm')?.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="ph-fill ph-circle-notch animate-spin mr-2"></i> Processing...';
      
      this.submit();
    });

    // Admin indicator height adjustment
    function adjustNavbarPosition() {
      const adminIndicator = document.getElementById('adminIndicator');
      const navbar = document.getElementById('main-header');
      const header = document.querySelector('header');
      
      if (adminIndicator && navbar && header) {
        // Get the computed styles to account for any CSS
        const indicatorStyles = window.getComputedStyle(adminIndicator);
        const indicatorHeight = adminIndicator.offsetHeight;
        const indicatorTop = parseInt(indicatorStyles.top) || 0;
        const indicatorMarginTop = parseInt(indicatorStyles.marginTop) || 0;
        const indicatorMarginBottom = parseInt(indicatorStyles.marginBottom) || 0;
        
        // Calculate total height including margins
        const totalIndicatorHeight = indicatorHeight + indicatorTop + indicatorMarginTop + indicatorMarginBottom;
        
        // Set navbar and header position
        navbar.style.top = totalIndicatorHeight + 'px';
        header.style.top = totalIndicatorHeight + 'px';
        
        // Ensure navbar is visible
        navbar.style.position = 'fixed';
        navbar.style.zIndex = '20';
        
        // Add some debugging for mobile
        console.log('Indicator height:', indicatorHeight, 'Total height:', totalIndicatorHeight);
      } else if (navbar && header) {
        // No admin indicator, reset to top
        navbar.style.top = '0px';
        header.style.top = '0px';
      }
    }

    // Call on page load, window resize, and after a short delay to ensure all elements are rendered
    document.addEventListener('DOMContentLoaded', function() {
      adjustNavbarPosition();
      // Additional check after a short delay to handle any dynamic content
      setTimeout(adjustNavbarPosition, 100);
      
      // Use ResizeObserver to watch for changes in admin indicator size
      const adminIndicator = document.getElementById('adminIndicator');
      if (adminIndicator && window.ResizeObserver) {
        const resizeObserver = new ResizeObserver(function(entries) {
          adjustNavbarPosition();
        });
        resizeObserver.observe(adminIndicator);
      }
    });
    
    window.addEventListener('resize', adjustNavbarPosition);
    
    // Also adjust when the page becomes visible (for mobile browsers)
    document.addEventListener('visibilitychange', function() {
      if (!document.hidden) {
        setTimeout(adjustNavbarPosition, 50);
      }
    });
    
    // Additional check for mobile orientation changes
    window.addEventListener('orientationchange', function() {
      setTimeout(adjustNavbarPosition, 200);
    });

  </script>

  <!-- Bug Report Button - Only show on non-admin pages -->
  @if(!request()->is('admin*'))
  <x-bug-report-button />
  @endif

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="{{ asset('js/heroSlider.js') }}"></script>
  <script src="{{ asset('js/preloader.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="{{ asset('js/seemore.js') }}"></script>
  <script src="{{ asset('js/modal.js') }}"></script>
  <script src="{{ asset('js/disableSubmission.js') }}"></script>
  <script src="{{ asset('js/scrollToTop.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>