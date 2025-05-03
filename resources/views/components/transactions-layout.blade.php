<x-layout>
  <div class="flex flex-col sm:flex-row min-h-screen">
    <!-- Mobile Dropdown -->
    <div class="block sm:hidden px-6 pt-6 mt-20">
      <select onchange="location = this.value"
        class="w-full border border-gray-300 text-gray-700 text-base rounded-md px-3 py-2 shadow-sm focus:ring-orange-500 focus:border-orange-500">
        <option value="/transactions/adoption-status" {{ request()->is('transactions/adoption-status') ? 'selected' : ''
          }}>
          Adoption Applications
        </option>
        <option value="/transactions/surrender-status" {{ request()->is('transactions/surrender-status') ? 'selected' :
          '' }}>
          Surrender Applications
        </option>
        <option value="/transactions/missing-status" {{ request()->is('transactions/missing-status') ? 'selected' : ''
          }}>
          Missing Pet Reports
        </option>
        <option value="/transactions/abused-status" {{ request()->is('transactions/abused-status') ? 'selected' : '' }}>
          Abused/Stray Reports
        </option>
      </select>
    </div>

    <!-- Sidebar -->
    <aside class="hidden sm:block sm:w-64 bg-white border-r border-gray-200 px-4 py-10">
      <h2 class="text-lg font-semibold mb-4">Manage Transactions</h2>
      <nav class="space-y-2">
        <a href="/transactions/adoption-status"
          class="{{ request()->is('transactions/adoption-status') || request()->is('transactions') ? 'bg-yellow-500 text-black font-semibold' : 'text-black' }} block px-4 py-2 rounded-full hover:bg-yellow-500 hover:font-semibold transition">
          Adoption Applications
        </a>
        <a href="/transactions/surrender-status"
          class="{{ request()->is('transactions/surrender-status') ? 'bg-yellow-500 text-black font-semibold' : 'text-black' }} block px-4 py-2 rounded-full hover:bg-yellow-500 hover:font-semibold transition">
          Surrender Applications
        </a>
        <a href="/transactions/missing-status"
          class="{{ request()->is('transactions/missing-status') ? 'bg-yellow-500 text-black font-semibold' : 'text-black' }} block px-4 py-2 rounded-full hover:bg-yellow-500 hover:font-semibold transition">
          Missing Pet Reports
        </a>
        <a href="/transactions/abused-status"
          class="{{ request()->is('transactions/abused-status') ? 'bg-yellow-500 text-black font-semibold' : 'text-black' }} block px-4 py-2 rounded-full hover:bg-yellow-500 hover:font-semibold transition">
          Abused/Stray Reports
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow pt-6 sm:pt-10 pb-10 px-6">
      {{ $slot }}
    </main>
  </div>
</x-layout>