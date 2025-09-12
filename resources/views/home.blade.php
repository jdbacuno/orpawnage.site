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
  <div class="relative w-full h-screen 4xl:h-50 overflow-hidden">
    <!-- Carousel wrapper -->
    <div id="default-carousel" class="relative w-full h-full flex transition-transform duration-[1100ms] ease-in-out"
      data-carousel="static">
      <!-- Item 2 -->
      <div class="min-w-full flex-shrink-0 relative h-full">
        <img src="{{ asset('images/home_image-2.jpg') }}" class="absolute block w-full h-full object-cover"
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
        <img src="{{ asset('images/home_image-1.jpg') }}" class="absolute block w-full h-full object-cover"
          alt="Slide 1" />
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
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
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4 relative z-40 carousel-content">
              <a href="/services/adopt-a-pet"
                class="hero-button inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-yellow-400 hover:text-black rounded-md font-medium transition-all duration-200 text-white">
                <i class="ph-fill ph-paw-print mr-2"></i> Adopt a Pet
              </a>
              <a href="/donate"
                class="hero-button inline-flex items-center px-6 py-3 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 rounded-md font-medium transition-all duration-200 text-white">
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
        <img src="{{ asset('images/home_image-3.jpg') }}"
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
    <div class="absolute bottom-8 left-0 right-0 z-30 flex justify-center space-x-2 pointer-events-none">
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
        <img src="{{ asset('images/home_image-0.jpg') }}"
          class="w-full h-96 object-cover rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300" />
      </div>

      <!-- Text Section -->
      <div class="w-full md:w-1/2 text-black flex flex-col justify-between gap-y-6">
        <div>
          <h2 class="text-4xl font-bold mb-4 text-black">Lorem Ipsum</h2>
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

  <!-- ========== START OF FEATURED PETS SECTION ========== -->
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

      <div class="relative group">
        <!-- Scroll Left Button -->
        <button
          class="hidden md:block absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 bg-white/80 rounded-full hover:bg-orange-400 hover:text-white transition-all duration-300 md:opacity-0 group-hover:opacity-100 -ml-4"
          onclick="scrollFeaturedPets(-1)">
          <i class="ph-fill ph-caret-left text-xl"></i>
        </button>

        <!-- Scrollable Container -->
        <div class="relative overflow-x-auto pb-4 scrollbar-hidden" id="featuredPetsContainer">
          <div class="flex gap-x-6 px-2">
            @foreach($featuredPets as $featured)
            <!-- Individual Pet Card -->
            <div class="flex-shrink-0 w-full sm:max-w-[350px] relative group">
              <div class="bg-white rounded-lg overflow-hidden">
                <a href="/services/{{ $featured->slug }}/adoption-form" class="block" target="_blank">
                  <img src="{{ asset('storage/' . ($featured->image_path ?? 'pet-images/catdog.svg')) }}"
                    alt="Pet Image"
                    class="h-64 w-full object-cover group-hover:brightness-95 transition-transform duration-500 hover:scale-105" />
                </a>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Scroll Right Button -->
        <button
          class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 bg-white/80 rounded-full shadow-md hover:bg-orange-400 hover:text-white transition-all duration-300 md:opacity-0 group-hover:opacity-100 -mr-4"
          onclick="scrollFeaturedPets(1)">
          <i class="ph-fill ph-caret-right text-xl"></i>
        </button>
      </div>
    </div>
  </section>

  <script>
    function scrollFeaturedPets(direction) {
      const container = document.getElementById('featuredPetsContainer');
      const scrollAmount = 350; // Matches card width + gap
      container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
      });
    }
  </script>
  @endif
  <!-- ========== END OF FEATURED PETS SECTION ========== -->
</x-layout>