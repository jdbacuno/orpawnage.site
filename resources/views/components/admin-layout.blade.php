<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  @vite(['resources/css/admin/style.css'])
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
  <script src="{{ asset('js/theme.js') }}"></script>
  <title>Orpawnage | Admin</title>
</head>

<body class="text-gray-800 font-inter">
  <!-- start: Sidebar -->
  <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
    <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
      <img src="{{ asset('images/orpawnage-logo.png') }}" alt="" class="w-8 h-8 rounded object-cover" />
      <span class="text-lg font-bold text-yellow-500 ml-3">
        Or<span class="text-orange-500">PAW</span>nage
      </span>
    </a>
    <ul class="mt-4">
      <li class="mb-1 group {{ request()->is('admin') ? 'active' : '' }}">
        <a href="/admin"
          class="flex items-center py-2 px-4 text-gray-300 hover:bg-yellow-500 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-500 group-[.active]:text-black group-[.active]:font-bold">
          <i class="ph-fill ph-squares-four mr-3 text-lg"></i>
          <span class="text-sm">Dashboard</span>
        </a>
      </li>
      <li class="mb-1 group {{ request()->is('admin/pet-profiles') ? 'active' : '' }}">
        <a href="/admin/pet-profiles"
          class="flex items-center py-2 px-4 text-gray-300 hover:bg-yellow-500 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-500 group-[.active]:text-black group-[.active]:font-bold">
          <i class=" ph-fill ph-paw-print mr-3 text-lg"></i>
          <span class="text-sm">Manage Pet Profiles</span>
        </a>
      </li>
      <li class="mb-1 group">
        <a href="#"
          class="flex items-center py-2 px-4 text-gray-300 hover:bg-yellow-500 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-yellow-500/60 group-[.selected]:text-black sidebar-dropdown-toggle">
          <i class="ph-fill ph-mailbox mr-3 text-lg"></i>
          <span class="text-sm">Requests</span>
          <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
        </a>
        <ul class="pl-7 mt-2 hidden group-[.selected]:block">
          <li class="mb-1">
            <a href="#"
              class="text-gray-300 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500 hover:text-black hover:font-semibold group-[.active]:bg-yellow-500 group-[.active]:text-black p-2 rounded-full">Adoption
              Requests</a>
          </li>
          <li class="mb-1">
            <a href="#"
              class="text-gray-300 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500 hover:text-black hover:font-semibold group-[.active]:bg-yellow-500 group-[.active]:text-black p-2 rounded-full">Surrender
              Requests</a>
          </li>
        </ul>
      </li>
      <li class="mb-1 group">
        <a href="#"
          class="flex items-center py-2 px-4 text-gray-300 hover:bg-yellow-500 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-yellow-500/60 group-[.selected]:text-black sidebar-dropdown-toggle">
          <i class="ph-fill ph-warning mr-3 text-lg"></i>
          <span class="text-sm">Reports</span>
          <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
        </a>
        <ul class="pl-7 mt-2 hidden group-[.selected]:block">
          <li class="mb-1">
            <a href="#"
              class="text-gray-300 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500 hover:text-black hover:font-semibold group-[.active]:bg-yellow-500 group-[.active]:text-black p-2 rounded-full">Missing
              Reports</a>
          </li>
          <li class="mb-1">
            <a href="#"
              class="text-gray-300 text-sm flex items-center before:contents-[''] before:w-1 hover:bg-yellow-500 hover:text-black hover:font-semibold group-[.active]:bg-yellow-500 group-[.active]:text-black p-2 rounded-full">Abused
              / Stray
              Reports</a>
          </li>
        </ul>
      </li>
      <li class="mb-1 group">
        <a href="/" target="_blank"
          class="flex items-center py-2 px-4 text-gray-300 hover:bg-yellow-500 hover:text-black hover:font-semibold transition-colors duration-300 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
          <i class="ph-fill ph-globe-hemisphere-east mr-3 text-lg"></i>
          <span class="text-sm">OrPAWnage.com</span>
        </a>
      </li>
      <li class="mb-1 group">
        <a href="#"
          class="flex items-center py-2 px-4 text-gray-300 hover:bg-yellow-500 hover:text-black hover:font-semibold rounded-md group-[.active]:bg-yellow-500 group-[.active]:text-black">
          <span><i class="ph-fill ph-gear-six mr-3 text-lg"></i></span>
          <span class="text-sm">Settings</span>
        </a>
      </li>
    </ul>
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
      <ul class="ml-auto flex items-center">
        <li class="dropdown ml-3">
          <button type="button"
            class="dropdown-toggle flex items-center text-gray-900 hover:text-yellow-500 transition-colors duration-300">
            {{-- <img src="{{ asset('images/orpawnage-logo.png') }}" alt=""
              class="w-8 h-8 rounded block object-cover align-middle" /> --}}

            <i class="ph-fill ph-user-circle text-4xl"></i>
            <i class="ph-fill ph-caret-down"></i>
          </button>
          <ul
            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden px-1.5 py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[280px] ">
            <li class="border-b border-b-gray-300 py-2">
              <span class="flex items-center text-md font-semibold pb-0 px-4 text-gray-600">{{ Auth::user()->username
                }}</span>
              <span href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 truncate overflow-hidden">{{
                Auth::user()->email }}</span>
            </li>
            <li class="py-1">
              <a href="#"
                class="flex items-center gap-2 text-sm py-1.5 px-4 text-gray-600 rounded-full hover:text-black hover:bg-yellow-500 hover:font-semibold transition-colors duration-300">
                <span><i class="ph-fill ph-gear-six font-bold"></i></span>
                Settings</a>
            </li>
            <li class="py-1">
              <form action="/logout" method="POST">
                @csrf
                @method('DELETE')

                <button
                  class="flex items-center gap-2 text-sm py-1.5 px-4 text-gray-600 w-full rounded-full hover:text-black hover:bg-yellow-500 hover:font-semibold transition-colors duration-300">
                  <i class="ph-fill ph-sign-out font-bold"></i>
                  Logout</button>
              </form>
            </li>
          </ul>
        </li>
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