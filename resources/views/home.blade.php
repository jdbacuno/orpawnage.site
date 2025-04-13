<x-layout>
  <!-- ========== START OF HERO CAROUSEL ========== -->
  <div class="relative w-full h-screen 4xl:h-50 overflow-hidden">
    <!-- Carousel wrapper -->
    <div id="default-carousel" class="relative w-full h-full flex transition-transform duration-[1100ms] ease-in-out"
      data-carousel="static">
      <!-- Item 1 -->
      <div class="min-w-full flex-shrink-0 relative h-full">
        <img src="{{ asset('images/catdogBG.jpg') }}" class="absolute block w-full h-full object-cover" alt="Slide 1" />
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div class="text-center text-white">
            <h1 class="text-5xl font-bold mb-4 text-white cursor-pointer">
              <span class="hover:text-yellow-400 transition-colors duration-300">Malaus</span>
              <span class="hover:text-yellow-400 transition-colors duration-300">kayu</span>
              <span class="hover:text-yellow-400 transition-colors duration-300">pu</span>
              <span class="hover:text-yellow-400 transition-colors duration-300">kening</span>
              <span class="tracking-widest hover:text-yellow-400 transition-colors duration-300">
                <span class="text-orange-500 hover:text-yellow-400 transition-colors duration-300">
                  Or<strong
                    class="text-yellow-500 hover:text-orange-400 transition-colors duration-300">PAW</strong>nage!
                </span>
              </span>
            </h1>
            <p class="text-xl/10 mt-10 mx-auto max-w-[700px] px-5 tracking-widest">
              Save a life — adopt instead of buying, and gain a heart that
              will always love you back.
            </p>
          </div>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="min-w-full flex-shrink-0 relative h-full">
        <img src="{{ asset('images/panoramadog.jpg') }}" class="absolute block w-full h-full object-cover"
          alt="Slide 2" />
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div class="text-center text-white">
            <h1 class="text-5xl font-bold mb-4 text-orange-400">
              Explore Our Services
            </h1>
            <p class="text-xl">We offer the best services for you.</p>
          </div>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="min-w-full flex-shrink-0 relative h-full">
        <img src="{{ asset('images/dogss.jpg') }}" class="absolute block w-full h-full object-cover" alt="Slide 3" />
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div class="text-center text-white">
            <h1 class="text-5xl font-bold mb-4 text-orange-400">
              Join Us Today
            </h1>
            <p class="text-xl">Become a part of our community.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Slider controls -->
    <button type="button"
      class="absolute top-1/2 left-4 z-30 flex items-center justify-center w-10 h-10 bg-white/30 rounded-full hover:bg-yellow-400/50 focus:outline-none"
      onclick="slidePrev()">
      <span class="sr-only">Previous</span>
      <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 6 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
      </svg>
    </button>

    <button type="button"
      class="absolute top-1/2 right-4 z-30 flex items-center justify-center w-10 h-10 bg-white/30 rounded-full hover:bg-yellow-400/50 focus:outline-none"
      onclick="slideNext()">
      <span class="sr-only">Next</span>
      <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 6 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
      </svg>
    </button>
  </div>
  <!-- ========== END OF HERO CAROUSEL ========== -->

  <!-- ========== START OF A NEW SECTION ========== -->
  <section class="w-full py-16 bg-yellow-500">
    <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center gap-10 px-4">
      <!-- Image Section -->
      <div class="w-full md:w-1/2">
        <img src="{{ asset('images/black-dog.jpg') }}" class="w-full h-96 object-cover rounded-lg shadow-lg" />
      </div>

      <!-- Text Section -->
      <div class="w-full md:w-1/2 text-black flex flex-col justify-between gap-y-6">
        <h2 class="text-4xl font-bold mb-4 text-black">Lorem Ipsum</h2>
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

</x-layout>