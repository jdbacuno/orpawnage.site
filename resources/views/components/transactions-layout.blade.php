<x-layout>
  <!-- Main content area with flex-grow to push footer down -->
  <div class="flex-grow">
    <!-- ========== ADOPTION REQUESTS SECTION ========== -->
    <section class="py-20 px-5 lg:px-20 mb-20 min-h-[calc(100vh-400px)]">
      <!-- Added min-height -->
      <!-- Section Type Selector -->
      <form method="GET" action="{{ url()->current() }}" class="mb-6">
        <select id="sectionSelector"
          class="border-b border-gray-400 font-bold text-gray-900 text-sm rounded-lg py-4 pl-2.5 pr-10 w-auto text-xl">
          <option value="/transactions/adoption-status" {{ request()->is('transactions/adoption-status') ? 'selected' :
            '' }}>
            Adoption Applications
          </option>
          <option value="/transactions/surrender-status" {{ request()->is('transactions/surrenders-status') ? 'selected'
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
      </form>

      {{ $slot }}
    </section>
  </div>

  <script>
    document.getElementById('sectionSelector').addEventListener('change', function() {
      window.location.href = this.value;
    });
  </script>
</x-layout>