<!DOCTYPE html>
<html lang="en" class="smooth-scroll scrollbar-hidden">

<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  {{--
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" /> --}}
  <link rel="icon" href="{{ asset('images/orpawnage-logo.png') }}" type="image/x-icon">
  @vite(['resources/css/admin/style.css', 'resources/css/admin/fonts/phosphor/phosphor.css',
  'resources/css/admin/fonts/phosphor/phosphor-fill.css', 'resources/css/admin/fonts/phosphor/phosphor-bold.css',
  'resources/css/admin/fonts/remix/remixicon.css'])
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script> --}}
  <script src="{{ asset('js/theme.js') }}"></script>
  <title>Orpawnage | Admin</title>

  <style>
    .draggable-item {
      transition: transform 0.2s ease;
      cursor: grab;
      user-select: none;
    }

    .draggable-item.dragging {
      opacity: 0.5;
      transform: scale(1.02);
      cursor: grabbing;
      z-index: 1000;
      position: relative;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    #staffGrid {
      min-height: 300px;
      position: relative;
    }

    /* Add this at the end of your style.css file */
    @media (max-width: 912px) {
      .main {
        margin-left: 0 !important;
        width: 100% !important;
      }

      .sidebar-menu {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }

      .sidebar-menu.-translate-x-full {
        transform: translateX(-100%);
      }

      .sidebar-menu:not(.-translate-x-full) {
        transform: translateX(0);
      }

      .sidebar-overlay {
        display: none;
      }

      .sidebar-overlay:not(.hidden) {
        display: block;
      }
    }
  </style>
</head>

<body class="text-gray-800 font-inter">
  <!-- start: Sidebar -->
  <div
    class="fixed left-0 top-0 w-64 h-full bg-white p-4 z-50 sidebar-menu transition-transform flex flex-col border-r border-gray-300">
    <a href="/" target="_blank" class="flex items-center pb-4 border-b border-b-gray-300">
      <img src="{{ asset('images/orpawnage-brand-logo-2.png') }}" alt="logo" class="h-8 rounded object-cover" />
      {{-- <span class="text-lg font-bold text-yellow-500 ml-3">
        Or<span class="text-orange-500">PAW</span>nage
      </span> --}}
    </a>
    <div class="flex-1 overflow-y-auto">
      <ul class="mt-4">
        <li class="mb-1 group {{ request()->is('admin') ? 'active' : '' }}">
          <a href="/admin"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-400 group-[.active]:text-black">
            <i class="ph-fill ph-squares-four mr-3 text-lg"></i>
            <span class="text-sm">Dashboard</span>
          </a>
        </li>
        <li class="mb-1 group {{ request()->is('admin/pet-profiles') ? 'active' : '' }}">
          <a href="/admin/pet-profiles"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-400 group-[.active]:text-black">
            <i class=" ph-fill ph-paw-print mr-3 text-lg"></i>
            <span class="text-sm">Pet Profiles</span>
          </a>
        </li>
        <li
          class="mb-1 group {{ request()->is('admin/adoption-applications') || request()->is('admin/surrender-applications') ? 'selected' : '' }}">
          <a href="#"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-yellow-400/60 group-[.selected]:text-black sidebar-dropdown-toggle">
            <i class="ph-fill ph-mailbox mr-3 text-lg"></i>
            <span class="text-sm">Applications</span>
            <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
          </a>
          <ul class="pl-7 mt-2 hidden group-[.selected]:block">
            <li class="mb-1 group {{ request()->is('admin/adoption-applications') ? 'active' : '' }}">
              <a href="/admin/adoption-applications"
                class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-400 hover:text-black hover:font-semibold p-2 rounded-full group-[.active]:bg-yellow-400 group-[.active]:text-black">
                Adoption Applications
              </a>

            </li>
            <li class="mb-1 group {{ request()->is('admin/surrender-applications') ? 'active' : '' }}">
              <a href="/admin/surrender-applications"
                class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-400 hover:text-black hover:font-semibold p-2 rounded-full group-[.active]:bg-yellow-400 group-[.active]:text-black">
                Surrender Applications
              </a>

            </li>
          </ul>
        </li>
        <li
          class="mb-1 group {{ request()->is('admin/abused-or-stray-pets') || request()->is('admin/missing-pets') ? 'selected' : '' }}">
          <a href="#"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-yellow-400/60 group-[.selected]:text-black sidebar-dropdown-toggle">
            <i class="ph-fill ph-warning-circle mr-3 text-lg"></i>
            <span class="text-sm">Reports</span>
            <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
          </a>
          <ul class="pl-7 mt-2 hidden group-[.selected]:block">
            <li class="mb-1 group {{ request()->is('admin/missing-pets') ? 'active' : '' }}">
              <a href="/admin/missing-pets"
                class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-400 hover:text-black hover:font-semibold p-2 rounded-full group-[.active]:bg-yellow-400 group-[.active]:text-black">
                Missing Pets
              </a>

            </li>
            <li class="mb-1 group {{ request()->is('admin/abused-or-stray-pets') ? 'active' : '' }}">
              <a href="/admin/abused-or-stray-pets"
                class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-400 hover:text-black hover:font-semibold p-2 rounded-full group-[.active]:bg-yellow-400 group-[.active]:text-black">
                Abused / Stray Pets
              </a>

            </li>
          </ul>
        </li>

        <li class="mb-1 group {{ request()->is('admin/archives') ? 'active' : '' }}">
          <a href="/admin/archives"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-400 group-[.active]:text-black">
            <i class=" ph-fill ph-archive mr-3 text-lg"></i>
            <span class="text-sm">Archives</span>
          </a>
        </li>

        <li class="mb-1 group {{ request()->is('admin/bug-reports') ? 'active' : '' }}">
          <a href="/admin/bug-reports"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-400 group-[.active]:text-black">
            <i class="ph-fill ph-bug mr-3 text-lg"></i>
            <span class="text-sm">Bug Reports</span>
          </a>
        </li>

        <li class="mb-1 group {{ request()->is('admin/featured-adoptions') ? 'active' : '' }}">
          <a href="/admin/featured-adoptions"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-400 group-[.active]:text-black">
            <i class=" ph-fill ph-images-square mr-3 text-lg"></i>
            <span class="text-sm">Featured Adoptions</span>
          </a>
        </li>

        <li class="mb-1 group {{ request()->is('admin/users') ? 'active' : '' }}">
          <a href="/admin/users"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-400 group-[.active]:text-black">
            <i class=" ph-fill ph-user mr-3 text-lg"></i>
            <span class="text-sm">Users</span>
          </a>
        </li>

        <li class="mb-1 group {{ request()->is('admin/team-members') ? 'active' : '' }}">
          <a href="/admin/team-members"
            class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-400 group-[.active]:text-black">
            <i class=" ph-fill ph-users-four mr-3 text-lg"></i>
            <span class="text-sm">Team Members</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Fixed bottom items -->
    <div>
      <ul>
        <!-- Settings Item -->
        <li class="mb-2 pb-2 group border-b border-gray-300">
          <button onclick="openSettingsModal()"
            class="w-full text-left flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-400 hover:text-black hover:font-semibold rounded-md">
            <i class="ph-fill ph-gear-six mr-3 text-lg"></i>
            <span class="text-sm">Settings</span>
          </button>
        </li>

        <!-- Profile Info + Logout -->
        <li class="my-3 px-2">
          <div class="flex items-center gap-3">
            <!-- User Image -->
            <img src="{{ asset('images/orpawnage-logo.png') }}" alt="User" class="w-10 h-10 rounded object-cover" />

            <!-- Admin Info -->
            <div class="flex flex-col text-gray-900 text-sm leading-tight flex-1 max-w-28">
              <span class="text-xs truncate">{{ Auth::user()->email }}</span>
              <span class="font-semibold text-xs text-gray-400 truncate">Admin</span>
            </div>

            <!-- Logout Button -->
            <button type="button" onclick="openLogoutModal()"
              class="w-10 h-10 rounded-full text-gray-900 flex items-center justify-center text-xl hover:bg-yellow-400 hover:text-black transition-colors">
              <i class="ph-fill ph-sign-out"></i>
            </button>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 lg:hidden sidebar-overlay"></div>
  <!-- end: Sidebar -->

  <!-- start: Main -->
  <main class="relative md:ml-64 min-h-screen transition-all main bg-gradient-to-b from-orange-50 to-white">
    <!-- Desktop/Large screens: warm gradient + subtle pattern background -->
    <div class="hidden sm:block absolute inset-0 z-0">
      <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-orange-50 to-rose-100">
      </div>
      <div class="absolute inset-0 opacity-20"
        style="background-image: radial-gradient(rgba(251, 191, 36, 0.1) 1px, transparent 1px); background-size: 22px 22px;">
      </div>
      <!-- Paw accents sprinkled like background (non-interactive) -->
      <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-7xl -top-10 left-8"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-6xl top-6 left-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-5xl top-10 right-1/3"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-10 text-8xl top-1/3 -left-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-7xl top-1/2 left-1/5"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-10 text-6xl top-2/3 left-1/2"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-15 text-7xl bottom-10 right-16"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-10 text-5xl bottom-24 right-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-6xl bottom-8 left-1/3"></i>
        <!-- Extra right-side sprinkles -->
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-15 text-6xl top-4 right-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-10 text-5xl top-1/4 right-10"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-7xl top-1/3 right-1/6"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-10 text-6xl top-1/2 right-3"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-7xl bottom-1/3 right-8"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-10 text-5xl bottom-1/5 right-1/12"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-15 text-6xl bottom-6 right-4"></i>
      </div>
    </div>
    <div class="relative z-10 py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30"
      id="main-header">
      <button type="button" class="text-lg text-gray-600 sidebar-toggle">
        <i class="ri-menu-line"></i>
      </button>
      <ul class="flex items-center text-sm ml-4">
        <li class="mr-2">
          <a href="#" class="text-gray-400 hover:text-gray-600 font-medium">Dashboard</a>
        </li>
        <li class="text-gray-600 mr-2 font-medium flex items-center"><i class="ph-bold ph-caret-right"></i></li>
        <li class="text-gray-600 mr-2 font-medium">{{ Route::currentRouteName() ? ucwords(str_replace('.', ' ',
          Route::currentRouteName())) : '' }}
          </title>
        </li>
      </ul>

    </div>

    <div class="relative z-30 p-6 w-full">
      {{ $slot }}
    </div>
  </main>
  <!-- end: Main -->

  @php
  // Determine which tab should be active based on the errors
  $activeTab = 'account-tab';
  if ($errors->has('current_password') || $errors->has('password')) {
  $activeTab = 'password-tab';
  } elseif ($errors->has('email') || $errors->has('email_current_password') ||
  $errors->has('contact_number') || $errors->has('contact_current_password')) {
  $activeTab = 'account-tab';
  }

  // Check if modal should be open
  $modalOpen = $errors->has('email') || $errors->has('email_current_password') ||
  $errors->has('contact_number') || $errors->has('contact_current_password') ||
  $errors->has('current_password') || $errors->has('password')
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
                  <i class="ph-fill ph-gear mr-2 text-yellow-500"></i>Admin Settings
                </h3>
                <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-500">
                  <i class="ph-fill ph-x text-2xl"></i>
                </button>
              </div>

              <!-- Tabs -->
              <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                  <button onclick="switchTab('account-tab')" id="account-tab-btn"
                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'account-tab' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500' }}">
                    Account
                  </button>
                  <button onclick="switchTab('password-tab')" id="password-tab-btn"
                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'password-tab' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500' }}">
                    Security
                  </button>
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
                      <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                          class="text-sm bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition">
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
                        <i class="ph-fill ph-envelope mr-2 text-yellow-500"></i>Change Email
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
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400"
                              placeholder="New email address">
                            <x-form-error name="email" />
                          </div>
                          <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                            <div class="relative">
                              <input type="password" name="email_current_password" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400"
                                placeholder="Enter your current password">
                              <button type="button" onclick="togglePasswordVisibility(this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                                <i class="ph-fill ph-eye text-lg"></i>
                              </button>
                            </div>
                            <x-form-error name="email_current_password" />
                          </div>
                          <div class="pt-1 flex justify-end">
                            <button type="submit"
                              class="px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-600 transition duration-300 flex items-center justify-center shadow">
                              <i class="ph-fill ph-check-circle mr-2"></i>Save
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>

                    <!-- Contact Number Update -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                      <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="ph-fill ph-phone mr-2 text-yellow-500"></i>Update Contact
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
                            <input type="tel" name="contact_number" value="{{ old('contact_number') }}"
                              pattern="^09\d{9}$" maxlength="11" placeholder="09XXXXXXXXX" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400">
                            <p class="mt-1 text-xs text-gray-500">Format: 09XXXXXXXXX (11 digits)</p>
                            <x-form-error name="contact_number" />
                          </div>
                          <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                            <div class="relative">
                              <input type="password" name="contact_current_password" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400"
                                placeholder="Enter your current password">
                              <button type="button" onclick="togglePasswordVisibility(this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600">
                                <i class="ph-fill ph-eye text-lg"></i>
                              </button>
                            </div>
                            <x-form-error name="contact_current_password" />
                          </div>
                          <div class="pt-1 flex justify-end">
                            <button type="submit"
                              class="px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-600 transition duration-300 flex items-center justify-center shadow">
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
                      <i class="ph-fill ph-lock mr-2 text-yellow-500"></i>Change Password
                    </h3>
                    <form method="POST" action="{{ route('admin.settings.password.update') }}" id="passwordChangeForm">
                      @csrf
                      @method('PATCH')
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                          <label class="block text-sm font-medium text-gray-600 mb-1">Current Password</label>
                          <div class="relative">
                            <input type="password" name="current_password" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400"
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
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400"
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
                                class="h-1.5 rounded-full w-0 bg-transparent transition-all duration-300"></div>
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
                          <label class="block text-sm font-medium text-gray-600 mb-1">Confirm New Password</label>
                          <div class="relative">
                            <input type="password" name="password_confirmation" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400"
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
                          class="px-5 py-2.5 bg-yellow-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-600 transition duration-300 flex items-center justify-center shadow">
                          <i class="ph-fill ph-check-circle mr-2"></i>Update Password
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- End Tab content -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Confirmation Modal -->
  <div id="logoutModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <!-- Background overlay -->
      <div class="fixed inset-0 bg-gray-500 opacity-75 transition-opacity"></div>

      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto overflow-hidden">
        <div class="px-6 py-6">
          <div class="flex items-center justify-center mb-4">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
              <i class="ph-fill ph-sign-out text-yellow-600 text-xl"></i>
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-2">
              Confirm Logout
            </h3>
            <p class="text-sm text-gray-500">
              Are you sure you want to log out?
            </p>
          </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 rounded-b-lg">
          <form action="/logout" method="POST" id="logoutForm" class="w-full sm:w-auto">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-500 text-base font-medium text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
              <i class="ph-fill ph-sign-out mr-2"></i>Logout
            </button>
          </form>
          <button type="button" onclick="closeLogoutModal()"
            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
            Cancel
          </button>
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

      // Logout Modal Functions
      function openLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
      }

      function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
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

        // Add event listeners for logout modal
        const logoutModal = document.getElementById('logoutModal');
        const logoutModalContent = logoutModal.querySelector('.inline-block');

        // Close modal when clicking outside
        logoutModal.addEventListener('click', function(e) {
          if (e.target === logoutModal) {
            closeLogoutModal();
          }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape' && !logoutModal.classList.contains('hidden')) {
            closeLogoutModal();
          }
        });
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
            button.classList.remove('border-yellow-500', 'text-yellow-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById(tabId).classList.remove('hidden');
        document.getElementById(tabId).classList.add('activeTab');
        
        // Activate selected tab button
        const tabButton = document.getElementById(tabId + '-btn');
        tabButton.classList.remove('border-transparent', 'text-gray-500');
        tabButton.classList.add('border-yellow-500', 'text-yellow-600');
        
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

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/admin/script.js') }}"></script>
  <script src="{{ asset('js/admin/modal.js') }}"></script>
  <script src="{{ asset('js/admin/disableSubmission.js') }}"></script>
  <script src="{{ asset('js/admin/custom.js') }}"></script>
</body>

</html>