<x-layout>
  <div class="flex min-h-screen" id="mainContent">
    <!-- Sidebar - Fixed width -->
    <aside class="hidden sm:block w-70 bg-white border-r border-gray-200 px-4 flex-shrink-0 fixed h-full z-10">
      <h2 class="text-lg font-semibold mt-4 mb-4">Manage Transactions</h2>
      <nav class="space-y-2">
        <a href="/transactions/adoption-status"
          class="{{ request()->is('transactions/adoption-status') || request()->is('transactions') ? 'bg-yellow-400 text-black' : 'text-black' }} flex items-center px-4 py-2 rounded-full hover:bg-yellow-400 transition">
          <i class="ph-fill ph-paw-print mr-3 text-lg"></i>
          Adoption Applications
        </a>
        <a href="/transactions/surrender-status"
          class="{{ request()->is('transactions/surrender-status') ? 'bg-yellow-400 text-black' : 'text-black' }} flex items-center px-4 py-2 rounded-full hover:bg-yellow-400 transition">
          <i class="ph-fill ph-hand-arrow-up mr-3 text-lg"></i>
          Surrender Applications
        </a>
        <a href="/transactions/missing-status"
          class="{{ request()->is('transactions/missing-status') ? 'bg-yellow-400 text-black' : 'text-black' }} flex items-center px-4 py-2 rounded-full hover:bg-yellow-400 transition">
          <i class="ph-fill ph-magnifying-glass mr-3 text-lg"></i>
          Missing Pet Reports
        </a>
        <a href="/transactions/abused-status"
          class="{{ request()->is('transactions/abused-status') ? 'bg-yellow-400 text-black' : 'text-black' }} flex items-center px-4 py-2 rounded-full hover:bg-yellow-400 transition">
          <i class="ph-fill ph-warning-circle mr-3 text-lg"></i>
          Abused/Stray Reports
        </a>
      </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 sm:ml-64 w-full">
      <!-- Mobile Dropdown -->
      <div class="block sm:hidden px-6 pt-6">
        <select onchange="location = this.value"
          class="w-full border border-gray-300 text-gray-700 text-base rounded-md px-3 py-2 shadow-sm focus:ring-orange-500 focus:border-orange-500">
          <option value="/transactions/adoption-status" {{ request()->is('transactions/adoption-status') ? 'selected' :
            '' }}>
            Adoption Applications
          </option>
          <option value="/transactions/surrender-status" {{ request()->is('transactions/surrender-status') ? 'selected'
            : '' }}>
            Surrender Applications
          </option>
          <option value="/transactions/missing-status" {{ request()->is('transactions/missing-status') ? 'selected' : ''
            }}>
            Missing Pet Reports
          </option>
          <option value="/transactions/abused-status" {{ request()->is('transactions/abused-status') ? 'selected' : ''
            }}>
            Abused/Stray Reports
          </option>
        </select>
      </div>

      <!-- Content -->
      <main class="pt-6 sm:pt-10 pb-10 px-6 w-full max-w-[1800px] mx-auto">
        {{ $slot }}
      </main>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function updateHeaderSpacer() {
          const header = document.getElementById('main-header');
          const mainContent = document.getElementById('mainContent');
          
          if (header && mainContent) {
              const headerHeight = header.offsetHeight;
              mainContent.style.marginTop = `${headerHeight}px`;
          }
      }

      // Initial update
      updateHeaderSpacer();

      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);
    });
  </script>
</x-layout>