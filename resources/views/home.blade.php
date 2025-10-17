<x-layout>
  <style>
    /* Ensure buttons are clickable and have proper hover effects */
    .hero-button {
      position: relative;
      z-index: 40;
      cursor: pointer;
      pointer-events: auto;
    }

    .hero-button:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Ensure carousel content is properly layered */
    .carousel-content {
      position: relative;
      z-index: 10;
    }
  </style>
  <!-- ========== START OF HERO CAROUSEL ========== -->
  <div class="relative w-full h-screen 4xl:h-50 overflow-hidden pb-[env(safe-area-inset-bottom)] md:pb-0">
    <!-- Carousel wrapper -->
    <div id="default-carousel" class="relative w-full h-full flex transition-transform duration-[1100ms] ease-in-out"
      data-carousel="static">
      <!-- Item 2 -->
      <div class="min-w-full flex-shrink-0 relative h-full">
        <img src="{{ asset('images/orpawnage-service-3.png') }}" class="absolute block w-full h-full object-cover"
          alt="Slide 2" />
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div class="text-center text-white">
            <h1 class="text-4xl font-bold mb-4 text-yellow-400">
              Explore Our Services
            </h1>
            <p
              class="text-lg/10 mt-10 mx-auto max-w-[700px] tracking-widest drop-shadow-md bg-black/20 px-4 py-2 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center border border-white/20">
              We offer the best services for you.</p>
          </div>
        </div>
      </div>

      <!-- Item 1 -->
      <div class="min-w-full flex-shrink-0 relative h-full">
        <img src="{{ asset('images/orpawnage-service-2.jpg') }}" class="absolute block w-full h-full object-cover"
          alt="Slide 1" />
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center px-2">
          <div class="text-center text-white">
            <h1 class="text-4xl font-bold mb-2 text-white cursor-pointer relative group">
              <span class="tracking-widest px-4 py-2 bg-black/20 rounded-lg relative overflow-hidden">
                <span class="animate-color-change-orange">
                  OR<strong class="animate-color-change-yellow">PAW</strong>NAGE
                </span>
                <span class="glowing-border"></span>
              </span>
            </h1>
            <p
              class="text-lg/10 mt-10 mx-auto max-w-[700px] tracking-widest drop-shadow-md bg-black/20 px-4 py-2 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center border border-white/20">
              An Online Portal Where Pets Find Their New Home
            </p>
            <div class="mt-8 flex flex-row flex-wrap justify-center gap-2 md:gap-4 relative z-40 carousel-content">
              <a href="/services/adopt-a-pet"
                class="hero-button inline-flex items-center px-3 py-2 md:px-6 md:py-3 bg-orange-500 hover:bg-yellow-400 hover:text-black rounded-md font-medium transition-all duration-200 text-white text-sm md:text-base">
                <i class="ph-fill ph-paw-print mr-2"></i> Adopt a Pet
              </a>
              <a href="/donate"
                class="hero-button inline-flex items-center px-3 py-2 md:px-6 md:py-3 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 rounded-md font-medium transition-all duration-200 text-white text-sm md:text-base">
                <i class="ph-fill ph-hand-heart mr-2"></i> Donate Now
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="min-w-full flex-shrink-0 relative h-full">
        @php
        $latestFeaturedAdoptions = App\Models\FeaturedAdoption::orderBy('created_at', 'desc')->take(3)->get();
        @endphp

        @if($latestFeaturedAdoptions->count() > 0)
        <!-- Mobile/Tablet - Single Image -->
        <div class="absolute block w-full h-full md:hidden">
          <img src="{{ asset('storage/' . $latestFeaturedAdoptions[0]->image_path) }}"
            class="w-full h-full object-cover" alt="Featured Adoption">
        </div>

        <!-- Desktop - Three Images -->
        <div class="absolute hidden w-full h-full md:flex">
          @foreach($latestFeaturedAdoptions as $adoption)
          <div class="w-1/3 h-full">
            <img src="{{ asset('storage/' . $adoption->image_path) }}" class="w-full h-full object-cover"
              alt="Featured Adoption {{ $loop->iteration }}">
          </div>
          @endforeach
        </div>
        @else
        <img src="{{ asset('images/pets.png') }}"
          class="absolute block w-full h-full object-cover sm:object-cover md:object-cover lg:object-contain xl:object-contain"
          alt="Slide 3" />
        @endif

        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div class="text-center text-white">
            <h1 class="text-4xl font-bold mb-4 text-yellow-400">
              Join Us Today
            </h1>
            <p
              class="text-lg/10 mt-10 mx-auto max-w-[700px] tracking-widest drop-shadow-md bg-black/20 px-4 py-2 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center border border-white/20">
              Become a part of our community.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Slider controls container -->
    <div class="absolute inset-0 group pointer-events-none">
      <!-- Previous button -->
      <button type="button"
        class="absolute top-1/2 left-4 z-30 flex items-center justify-center w-10 h-10 bg-white/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform -translate-y-1/2 hover:bg-yellow-400/50 focus:outline-none pointer-events-auto"
        onclick="slidePrev()">
        <span class="sr-only">Previous</span>
        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 1 1 5l4 4" />
        </svg>
      </button>

      <!-- Next button -->
      <button type="button"
        class="absolute top-1/2 right-4 z-30 flex items-center justify-center w-10 h-10 bg-white/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform -translate-y-1/2 hover:bg-yellow-400/50 focus:outline-none pointer-events-auto"
        onclick="slideNext()">
        <span class="sr-only">Next</span>
        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 9 4-4-4-4" />
        </svg>
      </button>
    </div>

    <!-- Slider indicators -->
    <div
      class="absolute bottom-4 md:bottom-8 left-0 right-0 z-30 flex justify-center space-x-2 pointer-events-none pb-[max(env(safe-area-inset-bottom),0px)] md:pb-0">
      <button type="button"
        class="h-2 w-6 rounded-full bg-white/50 hover:bg-yellow-400 transition-all duration-300 pointer-events-auto"
        onclick="goToSlide(0)"></button>
      <button type="button"
        class="h-2 w-6 rounded-full bg-white/50 hover:bg-yellow-400 transition-all duration-300 pointer-events-auto"
        onclick="goToSlide(1)"></button>
      <button type="button"
        class="h-2 w-6 rounded-full bg-white/50 hover:bg-yellow-400 transition-all duration-300 pointer-events-auto"
        onclick="goToSlide(2)"></button>
    </div>
  </div>
  <!-- ========== END OF HERO CAROUSEL ========== -->

  <!-- ========== START OF A NEW SECTION ========== -->
  <section class="w-full py-16 bg-gray-50">
    <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center gap-10 px-4">
      <!-- Image Section -->
      <div class="w-full md:w-1/2">
        <img src="{{ asset('images/orpawnage-service.png') }}"
          class="w-full h-96 object-cover rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300" />
      </div>

      <!-- Text Section -->
      <div class="w-full md:w-1/2 text-black flex flex-col justify-between gap-y-6">
        <div>
          <h2 class="text-4xl font-bold mb-4 text-black">What We Do</h2>
          <div class="w-20 h-1 bg-orange-400 rounded-full mt-1"></div>
        </div>
        <div class="text-lg/10 text-justify">
          <p class="leading-relaxed">
            At OrPAWnage, we believe that every animal deserves a loving
            home. Our mission is to rescue, protect, and find forever homes
            for abandoned or abused pets. With the help of our compassionate
            team and supportive community, we strive to reduce animal
            homelessness and promote responsible pet ownership.
          </p>
          <p class="mt-4 leading-relaxed">
            Our dedicated team works day and night to ensure that every pet
            we rescue receives medical care, attention, and affection. You
            can be a part of this mission by adopting, donating, or
            spreading awareness.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- ========== END OF A NEW SECTION ========== -->

  <!-- ========== START OF FEATURED PETS SECTION ========== -->
  @php
  $featuredPets = app('App\Http\Controllers\FeaturedPetController')->index()->getData()['featuredPets'];
  @endphp

  <!-- ========== START OF FEATURED PETS SECTION (HOME PAGE) ========== -->
  @if($featuredPets->count() > 4)
  <section class="w-full py-16 bg-white bg-yellow-20">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-black">
          <i class="ph-fill ph-paw-print mr-2 text-orange-400"></i>Featured Pets
        </h2>
        <a href="/featured-pets"
          class="flex items-center text-orange-400 hover:text-yellow-400 transition-colors duration-300">
          Show More <i class="ph-fill ph-arrow-right ml-1"></i>
        </a>
      </div>

      <div class="relative">
        <!-- Scroll Left Button -->
        <button
          class="hidden md:block absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 bg-white/80 rounded-full hover:bg-orange-400 hover:text-white transition-all duration-300 md:opacity-75 hover:opacity-100 -ml-4"
          onclick="scrollFeaturedPets(-1)">
          <i class="ph-fill ph-caret-left text-xl"></i>
        </button>

        <!-- Scrollable Container -->
        <div class="relative overflow-x-auto pb-4 scrollbar-hidden" id="featuredPetsContainer">
          <div class="flex gap-x-6 px-2">
            @foreach($featuredPets as $featured)
            <!-- ENHANCED CARD DESIGN WITH CLICK-TO-SLIDE -->
            <div
              class="flex-shrink-0 w-[350px] relative bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition-all duration-200 border border-gray-200"
              wire:poll.10s>

              <!-- Image with click handler (NO LONGER AN <a> TAG) -->
              <div class="block relative cursor-pointer" onclick="toggleSlideUp(this.closest('.group'))">
                <img src="{{ asset('storage/' . ($featured->pet->image_path ?? 'pet-images/catdog.svg')) }}"
                  alt="Pet Image"
                  class="h-64 w-full object-cover group-hover:brightness-95 transition-all duration-300" />
                <div class="absolute top-2 left-2">
                  <span class="bg-rose-600 text-white text-[10px] font-bold px-2 py-1 rounded">Pick me!</span>
                </div>
                <div class="absolute top-2 right-2">
                  <span class="bg-black/60 text-white text-[10px] px-2 py-1 rounded flex items-center">
                    <i class="ph-fill ph-clock mr-1"></i>
                    Added {{ \Carbon\Carbon::parse($featured->pet->created_at)->diffForHumans() }}
                  </span>
                </div>
              </div>

              <!-- Slide-Up Panel with Blur (CLICK-TO-SLIDE VERSION) -->
              <div
                class="slide-up-panel absolute bottom-0 left-0 w-full bg-white/70 backdrop-blur-md text-gray-900 p-4 translate-y-full transition-all duration-300 ease-in-out">

                <!-- Close button -->
                <button onclick="event.stopPropagation(); closeSlideUp(this)"
                  class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 z-10 opacity-0 pointer-events-none">
                  <i class="ph-fill ph-x text-lg"></i>
                </button>

                <!-- Name & ID -->
                <div class="flex justify-between items-center mb-3 pr-8">
                  <h3 class="text-lg font-bold text-black">
                    {{ strtolower($featured->pet->pet_name) !== 'n/a' ? ucwords($featured->pet->pet_name) : 'Unnamed' }}
                  </h3>
                  <span class="bg-yellow-400 text-xs text-black py-1 px-2 rounded font-bold">
                    {{ $featured->pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $featured->pet->pet_number }}
                  </span>
                </div>

                <!-- Colorized Badges (clickable/togglable) -->
                <div class="flex flex-wrap gap-2 mb-3">
                  <span
                    class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full border border-blue-200 cursor-pointer"
                    data-description="Age" onclick="event.stopPropagation(); changeText(this)">
                    {{ $featured->pet->formatted_age }} {{ $featured->pet->formatted_age == 1 ?
                    Str::singular($featured->pet->age_unit) :
                    Str::plural($featured->pet->age_unit) }} old
                  </span>
                  <span
                    class="{{ $featured->pet->sex == 'male' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-pink-100 text-pink-800 border-pink-200' }} text-xs px-3 py-1 rounded-full border cursor-pointer"
                    data-description="Sex" onclick="event.stopPropagation(); changeText(this)">
                    {{ ucfirst($featured->pet->sex) }}
                  </span>
                  <span
                    class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full border border-green-200 cursor-pointer"
                    data-description="Color" onclick="event.stopPropagation(); changeText(this)">
                    {{ ucfirst($featured->pet->color) }}
                  </span>
                </div>

                <!-- CTAs -->
                <div class="flex items-center justify-between">
                  <div class="text-[11px] text-gray-600 inline-flex items-center gap-2">
                    <span class="inline-flex items-center"><i class="ph-fill ph-sparkle mr-1 text-amber-600"></i>Give me
                      a chance</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <a href="/services/{{ $featured->pet->slug }}/adoption-form" onclick="event.stopPropagation()"
                      class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                      <i class="ph-fill ph-paw-print mr-1"></i>Adopt me
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Scroll Right Button -->
        <button
          class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 bg-white/80 rounded-full shadow-md hover:bg-orange-400 hover:text-white transition-all duration-300 md:opacity-75 hover:opacity-100 -mr-4"
          onclick="scrollFeaturedPets(1)">
          <i class="ph-fill ph-caret-right text-xl"></i>
        </button>
      </div>
    </div>
  </section>

  <script>
    // HORIZONTAL SCROLL FUNCTIONALITY (HOME PAGE SPECIFIC)
    function scrollFeaturedPets(direction) {
      const container = document.getElementById('featuredPetsContainer');
      const scrollAmount = 350; // Matches card width + gap
      container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
      });
    }

    // CLICK-TO-SLIDE FUNCTIONALITY (SHARED WITH FEATURED PAGE)
    function toggleSlideUp(card) {
      const panel = card.querySelector('.slide-up-panel');
      const closeButton = panel.querySelector('button');
      const isOpen = !panel.classList.contains('translate-y-full');

      if (isOpen) {
        // Close
        panel.classList.add('translate-y-full');
        card.classList.remove('details-open');
        closeButton.classList.add('opacity-0', 'pointer-events-none');
      } else {
        // Close all other open panels first
        document.querySelectorAll('.slide-up-panel').forEach(p => {
          p.classList.add('translate-y-full');
          p.closest('.group').classList.remove('details-open');
          p.querySelector('button').classList.add('opacity-0', 'pointer-events-none');
        });

        // Open this one
        panel.classList.remove('translate-y-full');
        card.classList.add('details-open');
        closeButton.classList.remove('opacity-0', 'pointer-events-none');
      }
    }

    function closeSlideUp(button) {
      const panel = button.closest('.slide-up-panel');
      const card = button.closest('.group');
      panel.classList.add('translate-y-full');
      card.classList.remove('details-open');
      button.classList.add('opacity-0', 'pointer-events-none');
    }

    // Close slide-up when clicking outside
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.group')) {
        document.querySelectorAll('.slide-up-panel').forEach(panel => {
          panel.classList.add('translate-y-full');
          panel.closest('.group').classList.remove('details-open');
          panel.querySelector('button').classList.add('opacity-0', 'pointer-events-none');
        });
      }
    });

    // Badge toggler shared with featured page
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
  @endif
  <!-- ========== END OF FEATURED PETS SECTION (HOME PAGE) ========== -->
</x-layout>
