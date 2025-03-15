<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

    <link rel="icon" href="{{ asset('images/orpawnage-logo.png') }}" />
    
    @vite(['resources/css/auth.css'])
  </head>
  <body
    x-data="{ page: 'comingSoon', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <div
      x-show="loaded"
      x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
      class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black"
    >
      <div
        class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"
      ></div>
    </div>
    <!-- ===== Preloader End ===== -->

    {{ $slot }}
    <script src="{{ asset('js/custom.js') }}"></script>
    <script defer src="{{ asset('js/auth.js') }}"></script>
  </body>
</html>
