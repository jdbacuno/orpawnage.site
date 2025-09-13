<x-layout>
  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="relative featured-gradient min-h-screen bg-yellow-20" id="mainContent">

    <!-- Desktop/Large screens: warm gradient + subtle pattern background -->
    <div class="hidden sm:block absolute inset-0 z-0">
      <div
        class="absolute inset-0 bg-gradient-to-br from-amber-50 via-orange-50 to-rose-100 animate-[gradientShift_14s_ease-in-out_infinite]">
      </div>
      <div class="absolute inset-0 opacity-40"
        style="background-image: radial-gradient(rgba(251, 191, 36, 0.25) 1px, transparent 1px); background-size: 22px 22px;">
      </div>
      <!-- Paw accents sprinkled like background (non-interactive) -->
      <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-30 text-7xl -top-10 left-8"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-6xl top-6 left-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-5xl top-10 right-1/3"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-8xl top-1/3 -left-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-7xl top-1/2 left-1/5"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-20 text-6xl top-2/3 left-1/2"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-7xl bottom-10 right-16"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-20 text-5xl bottom-24 right-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-6xl bottom-8 left-1/3"></i>
        <!-- Extra right-side sprinkles -->
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-6xl top-4 right-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-20 text-5xl top-1/4 right-10"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-7xl top-1/3 right-1/6"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-6xl top-1/2 right-3"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-7xl bottom-1/3 right-8"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-20 text-5xl bottom-1/5 right-1/12"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-6xl bottom-6 right-4"></i>
      </div>
    </div>
    <div class="relative z-10 max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Hero / Purpose Banner -->
      <div class="mt-2 mb-8">
        <div class="rounded-2xl overflow-hidden">
          <div class="relative p-6 sm:p-8 border border-amber-200/60">
            <!-- Animated gradient background layer -->
            <div
              class="absolute inset-0 bg-gradient-to-r from-amber-100 via-rose-100 to-orange-100 animate-[gradientShift_14s_ease-in-out_infinite]">
            </div>
            <!-- Subtle dotted pattern overlay -->
            <div class="absolute inset-0 opacity-[.28]"
              style="background-image: radial-gradient(rgba(251, 191, 36, 0.25) 1px, transparent 1px); background-size: 22px 22px;">
            </div>
            <!-- Floating paw accents -->
            <div
              class="pointer-events-none absolute -top-6 -left-6 text-yellow-400 opacity-50 animate-[floatSlow_10s_ease-in-out_infinite]">
              <i class="ph-fill ph-paw-print text-7xl"></i>
            </div>
            <div
              class="pointer-events-none absolute -bottom-8 right-10 text-orange-400 opacity-40 animate-[floatSlow_12s_ease-in-out_infinite_reverse]">
              <i class="ph-fill ph-paw-print text-8xl"></i>
            </div>
            <div
              class="pointer-events-none absolute top-6 right-1/3 text-rose-400 opacity-30 animate-[floatSlow_11s_ease-in-out_infinite]">
              <i class="ph-fill ph-paw-print text-6xl"></i>
            </div>
            <div class="relative">
              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                  <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight flex items-center">
                    <i class="ph-fill ph-heart text-amber-500 mr-3"></i>
                    Featured Pets
                  </h2>
                  <p class="mt-2 text-gray-700 max-w-2xl">
                    These pets have a lower likelihood of being adopted quickly. Your attention can make all the
                    difference—please consider meeting them first.
                  </p>
                  <ul class="mt-3 text-sm text-gray-600 flex flex-wrap gap-x-4 gap-y-1">
                    <li class="inline-flex items-center"><i class="ph-fill ph-clock mr-1 text-amber-500"></i>Longest in
                      care</li>
                    <li class="inline-flex items-center"><i
                        class="ph-fill ph-user-heart mr-1 text-rose-500"></i>Under‑noticed personalities</li>
                    <li class="inline-flex items-center"><i
                        class="ph-fill ph-stethoscope mr-1 text-orange-500"></i>Mild/special needs</li>
                  </ul>
                </div>
                <div class="flex sm:flex-col gap-2">
                  <a href="#pets"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-amber-500 text-white font-semibold hover:bg-amber-600 transition">
                    <i class="ph-fill ph-paw-print mr-2"></i>See Featured Pets
                  </a>
                  <a href="/services/adopt-a-pet"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-white text-gray-800 font-semibold border hover:bg-gray-50 transition">
                    Explore All Pets
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @if ($featuredPets->count() > 0)
      <div class="container mx-auto px-4">


        <div class="mb-5 p-4 bg-white border border-amber-200 rounded-xl shadow-sm" id="pets">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="ph-fill ph-megaphone"></i>
              </div>
              <p class="text-sm text-gray-700">
                We highlight pets who need an extra boost—often older, shy-at-first, or simply overlooked. Share a
                little extra love by checking them out first.
              </p>
            </div>
          </div>
        </div>

        <!-- Pet Cards Grid -->
        <div
          class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-10 justify-center">
          @foreach ($featuredPets as $featured)
          <!-- ENHANCED CARD DESIGN -->
          <div
            class="relative bg-white w-full mx-auto rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition-all duration-200 border border-gray-200">
            <a href="/services/{{ $featured->slug }}/adoption-form" class="block relative">
              <img src="{{ asset('storage/' . ($featured->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
                class="h-64 w-full object-cover group-hover:brightness-95 transition-all duration-300" />
              <div class="absolute top-2 left-2">
                <span class="bg-rose-600 text-white text-[10px] font-bold px-2 py-1 rounded">Pick me!</span>
              </div>
              <div class="absolute top-2 right-2">
                <span class="bg-black/60 text-white text-[10px] px-2 py-1 rounded flex items-center">
                  <i class="ph-fill ph-clock mr-1"></i>
                  Added {{ \Carbon\Carbon::parse($featured->created_at)->diffForHumans() }}
                </span>
              </div>
            </a>

            <!-- Enhanced Slide-Up Panel -->
            <div
              class="absolute bottom-0 left-0 w-full bg-white/70 backdrop-blur-md text-gray-900 p-4 translate-y-full group-hover:translate-y-0 transition-all duration-300 ease-in-out">

              <!-- Name & ID -->
              <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-bold text-black">
                  {{ strtolower($featured->pet_name) !== 'n/a' ? ucwords($featured->pet_name) : 'Unnamed' }}
                </h3>
                <span class="bg-yellow-400 text-xs text-black py-1 px-2 rounded font-bold">
                  {{ $featured->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $featured->pet_number }}
                </span>
              </div>

              <!-- Colorized Badges (clickable/togglable) -->
              <div class="flex flex-wrap gap-2 mb-3">
                <span
                  class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full border border-blue-200 cursor-pointer"
                  data-description="Age" onclick="changeText(this)">
                  {{ $featured->age }} {{ $featured->age == 1 ? Str::singular($featured->age_unit) :
                  Str::plural($featured->age_unit) }} old
                </span>
                <span
                  class="{{ $featured->sex == 'male' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-pink-100 text-pink-800 border-pink-200' }} text-xs px-3 py-1 rounded-full border cursor-pointer"
                  data-description="Sex" onclick="changeText(this)">
                  {{ ucfirst($featured->sex) }}
                </span>
                <span
                  class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full border border-green-200 cursor-pointer"
                  data-description="Color" onclick="changeText(this)">
                  {{ ucfirst($featured->color) }}
                </span>
              </div>

              <!-- CTAs -->
              <div class="flex items-center justify-between">
                <div class="text-[11px] text-gray-600 inline-flex items-center gap-2">
                  <span class="inline-flex items-center"><i class="ph-fill ph-sparkle mr-1 text-amber-600"></i>Give me a
                    chance</span>
                </div>
                <div class="flex items-center gap-2">
                  <a href="/services/{{ $featured->slug }}/adoption-form"
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                    <i class="ph-fill ph-paw-print mr-1"></i>Adopt me
                  </a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Pagination Controls -->
        <div class="mt-6">
          {{ $featuredPets->links() }}
        </div>
      </div>

      @else
      <!-- No Pets Found Message -->
      <div class="text-center text-black mt-10 h-dvh">
        <div class="max-w-md mx-auto bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
          <i class="ph-fill ph-paw-print text-3xl text-gray-500"></i>
          <p class="mt-3 text-lg font-semibold">No featured pets right now</p>
          <p class="text-sm text-gray-600">Great news—everyone is getting attention. Please explore all adoptable pets
            instead.</p>
          <a href="/adopt-a-pet"
            class="mt-4 inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-white font-semibold hover:bg-amber-600 transition">
            Explore All Pets
          </a>
        </div>
      </div>
      @endif
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function updateHeaderSpacer() {
        const header = document.getElementById('main-header');
        const mainContent = document.getElementById('mainContent');
        
        if (header && mainContent) {
          const headerHeight = header.offsetHeight;
          mainContent.style.marginTop = `${headerHeight}px`;
          mainContent.style.paddingTop = `${headerHeight * .30}px`;
          mainContent.style.paddingBottom = `${headerHeight * .30}px`;
        }
      }
     
      // Initial update
      updateHeaderSpacer();
     
      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);
    });

    // share button removed; no extra JS needed
  </script>

  <script>
    // Badge toggler shared with adopt-a-pet
    function changeText(el) {
      const original = el.getAttribute('data-original-text') || el.textContent.trim();
      const desc = el.getAttribute('data-description') || '';
      if (!el.getAttribute('data-original-text')) {
        el.setAttribute('data-original-text', original);
      }
      const showingDesc = el.getAttribute('data-showing') === 'desc';
      if (showingDesc) {
        el.textContent = el.getAttribute('data-original-text');
        el.setAttribute('data-showing', 'orig');
      } else {
        el.textContent = desc;
        el.setAttribute('data-showing', 'desc');
      }
    }
  </script>
</x-layout>