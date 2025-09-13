<x-layout>
  <!-- ========== START OF DONATION SECTION ========== -->
  <section class="relative flex items-center justify-center min-h-screen bg-black/50" id="mainContent">

    <!-- Background Image -->
    <div class="absolute inset-0 overflow-hidden">
      <img src="{{ asset('images/donate.png') }}" alt="Donate Background"
        class="w-full h-full object-cover bg-black mix-blend-light" />
    </div>

    <!-- Overlay Content - More compact version -->
    <div
      class="relative z-10 w-full max-w-2xl bg-white/70 backdrop-blur-xs p-6 md:p-8 rounded-xl shadow-lg border border-white/20 mx-4 overflow-hidden">
      <!-- Paw Accents -->
      <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-3xl -top-4 left-4"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-2xl top-8 right-8"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-3xl bottom-6 left-12"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-10 text-2xl bottom-2 right-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-xl top-20 left-20"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-10 text-2xl bottom-12 right-12"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-2xl top-2 right-2"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-xl bottom-4 left-2"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-2xl top-12 left-8"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-10 text-xl bottom-8 right-4"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-2xl top-4 left-12"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-xl top-16 right-16"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-2xl bottom-10 left-20"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-10 text-xl bottom-16 right-20"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-lg top-24 left-4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-10 text-lg bottom-20 left-16"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-xl top-6 right-12"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-2xl top-18 left-16"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-15 text-xl bottom-14 left-8"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-10 text-2xl bottom-18 right-8"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-15 text-lg top-28 left-12"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-10 text-lg bottom-24 left-24"></i>
      </div>

      <!-- Header -->
      <div class="relative z-10 text-center mb-6">
        <h1
          class="text-3xl md:text-4xl font-bold text-orange-500 mb-1 flex flex-col sm:flex-row items-center justify-center gap-2">
          <i class="ph-fill ph-hand-heart"></i> YOUR
          DONATIONS
        </h1>
        <h2 class="text-lg md:text-xl text-gray-700">Make a Difference</h2>
        <div class="w-20 h-1 bg-orange-400 rounded-full mx-auto mt-2"></div>
      </div>

      <!-- Donation List - Compact -->
      <div class="mb-6">
        <h3 class="text-lg md:text-xl font-semibold text-gray-700 mb-3 flex items-center">
          <i class="ph-fill ph-heart text-orange-500 mr-2"></i> We Need:
        </h3>
        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-base">
          @foreach ([
          'Food (Dry, Wet, Canned)',
          'Treats',
          'Collars / Leashes',
          'Cat Litter',
          'Towels',
          'Toys'
          ] as $item)
          <li
            class="flex items-center p-2 rounded-md border border-transparent hover:bg-orange-50 hover:border-orange-300 transition-all duration-300 cursor-pointer box-border">
            <i class="ph-fill ph-check-fat text-orange-500 mr-2"></i>
            <span>{{ $item }}</span>
          </li>
          @endforeach
        </ul>
      </div>

      <!-- Location - Compact -->
      <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-700 mb-3 flex items-center">
          <i class="ph-fill ph-map-trifold text-orange-500 mr-2"></i> Drop-Off:
        </h3>
        <div class="bg-white p-3 rounded-lg border border-gray-100">
          <p class="flex items-start mb-2 text-sm md:text-base">
            <i class="ph-fill ph-map-pin text-orange-500 mt-0.5 mr-2"></i>
            Orpawnage Main Building, Angeles City
          </p>
          <p class="text-xs md:text-sm text-gray-500 ml-5 pl-3 border-l-2 border-orange-100">
            123 Pusang Gala St, Brgy. Pampang, Angeles City
          </p>
          <p class="flex items-center mt-3 text-sm md:text-base">
            <i class="ph-fill ph-clock text-orange-500 mr-2"></i>
            Mon-Fri: 8AM-5PM (Weekends by appointment)
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- ========== END OF DONATION SECTION ========== -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function updateHeaderSpacer() {
          const header = document.getElementById('main-header');
          const mainContent = document.getElementById('mainContent');
          
          if (header && mainContent) {
              const headerHeight = header.offsetHeight;
              mainContent.style.marginTop = `${headerHeight * .5}px`;
          }
      }

      // Initial update
      updateHeaderSpacer();

      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);
    });
  </script>
</x-layout>