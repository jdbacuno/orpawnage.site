<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
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
</head>

<body class="text-gray-800 font-inter">
  <!-- start: Sidebar -->
  {{-- <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform"> --}}
    <div
      class="fixed left-0 top-0 w-64 h-full bg-white p-4 z-50 sidebar-menu transition-transform flex flex-col border-r border-gray-300">
      <a href="#" class="flex items-center pb-4 border-b border-b-gray-300">
        <img src="{{ asset('images/orpawnage-logo.png') }}" alt="" class="w-8 h-8 rounded object-cover" />
        <span class="text-lg font-bold text-yellow-500 ml-3">
          Or<span class="text-orange-500">PAW</span>nage
        </span>
      </a>
      <div class="flex-1 overflow-y-auto">
        <ul class="mt-4">
          <li class="mb-1 group {{ request()->is('admin') ? 'active' : '' }}">
            <a href="/admin"
              class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-500 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-500 group-[.active]:text-black group-[.active]:font-bold">
              <i class="ph-fill ph-squares-four mr-3 text-lg"></i>
              <span class="text-sm">Dashboard</span>
            </a>
          </li>
          <li class="mb-1 group {{ request()->is('admin/pet-profiles') ? 'active' : '' }}">
            <a href="/admin/pet-profiles"
              class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-500 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-500 group-[.active]:text-black group-[.active]:font-bold">
              <i class=" ph-fill ph-paw-print mr-3 text-lg"></i>
              <span class="text-sm">Manage Pet Profiles</span>
            </a>
          </li>
          <li class="mb-1 group {{ request()->is('admin/adoption-applications') ? 'selected' : '' }}">
            <a href="#"
              class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-500 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-yellow-500/60 group-[.selected]:text-black sidebar-dropdown-toggle">
              <i class="ph-fill ph-mailbox mr-3 text-lg"></i>
              <span class="text-sm">Applications</span>
              <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block">
              <li class="mb-1 group {{ request()->is('admin/adoption-applications') ? 'active' : '' }}">
                <a href="/admin/adoption-applications"
                  class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500 hover:text-black hover:font-semibold p-2 rounded-full group-[.active]:bg-yellow-500 group-[.active]:text-black group-[.active]:font-bold">
                  Adoption Applications
                </a>

              </li>
              <li class="mb-1">
                <a href="#" class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500
                hover:text-black hover:font-semibold p-2 rounded-full">
                  Surrender Applications
                </a>
              </li>
            </ul>
          </li>

          <li class="mb-1 group">
            <a href="#"
              class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-500 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-yellow-500/60 group-[.selected]:text-black sidebar-dropdown-toggle">
              <i class="ph-fill ph-warning mr-3 text-lg"></i>
              <span class="text-sm">Reports</span>
              <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block">
              <li class="mb-1">
                <a href="#"
                  class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500 hover:text-black hover:font-semibold group-[.active]:bg-yellow-500 group-[.active]:text-black p-2 rounded-full">Missing
                  Reports</a>
              </li>
              <li class="mb-1">
                <a href="#"
                  class="text-gray-900 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500 hover:text-black hover:font-semibold group-[.active]:bg-yellow-500 group-[.active]:text-black p-2 rounded-full">Abused
                  / Stray
                  Reports</a>
              </li>
            </ul>
          </li>
          <li class="mb-1 group">
            <a href="/" target="_blank"
              class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-500 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
              <i class="ph-fill ph-globe-hemisphere-east mr-3 text-lg"></i>
              <span class="text-sm">OrPAWnage.com</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Fixed bottom items -->
      <div class="pt-4">
        <ul>
          <!-- Settings Item -->
          <li class="mb-2 group border-b border-gray-300">
            <a href="#"
              class="flex items-center py-2 px-4 text-gray-900 hover:bg-yellow-500 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-500 group-[.active]:text-black">
              <i class="ph-fill ph-gear-six mr-3 text-lg"></i>
              <span class="text-sm">Settings</span>
            </a>
          </li>

          <!-- Profile Info + Logout -->
          <li class="my-3 px-2">
            <div class="flex items-center gap-3">
              <!-- User Image -->
              <img src="{{ asset('images/cityvet_logo.png') }}" alt="User" class="w-10 h-10 rounded object-cover" />

              <!-- Admin Info -->
              <div class="flex flex-col text-gray-900 text-sm leading-tight flex-1 max-w-28">
                <span class="text-xs truncate">{{ Auth::user()->email }}</span>
                <span class="font-semibold text-xs text-gray-400 truncate">Admin</span>
              </div>

              <!-- Logout Button -->
              <form action="/logout" method="POST" class="ml-auto">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="w-10 h-10 rounded-full text-gray-900 flex items-center justify-center text-xl hover:bg-yellow-500 hover:text-black transition-colors">
                  <i class="ph-fill ph-sign-out"></i>
                </button>
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <!-- end: Sidebar -->

    <!-- start: Main -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
      <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
        <button type="button" class="text-lg text-gray-600 sidebar-toggle">
          <i class="ri-menu-line"></i>
        </button>
        <ul class="flex items-center text-sm ml-4">
          <li class="mr-2">
            <a href="#" class="text-gray-400 hover:text-gray-600 font-medium">Dashboard</a>
          </li>
          <li class="text-gray-600 mr-2 font-medium">/</li>
          <li class="text-gray-600 mr-2 font-medium">{{ Route::currentRouteName() ? ucfirst(Route::currentRouteName()) :
            '' }}</li>
        </ul>

      </div>

      <div class="p-6">
        {{ $slot }}
      </div>
    </main>
    <!-- end: Main -->

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/script.js') }}"></script>
    <script src="{{ asset('js/admin/modal.js') }}"></script>
    <script src="{{ asset('js/admin/custom.js') }}"></script>
</body>

</html>