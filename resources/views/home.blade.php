<x-layout>
  <!-- ========== START OF HERO CAROUSEL ========== -->
<div class="relative w-full h-screen 4xl:h-50 overflow-hidden">
  <!-- Carousel wrapper -->
  <div
    id="default-carousel"
    class="relative w-full h-full flex transition-transform duration-[1100ms] ease-in-out"
    data-carousel="static"
  >
    <!-- Item 1 -->
    <div class="min-w-full flex-shrink-0 relative h-full">
      <img
        src="{{ asset('images/catdogBG.jpg') }}"
        class="absolute block w-full h-full object-cover"
        alt="Slide 1"
      />
      <div
        class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center"
      >
        <div class="text-center text-white">
          <h1 class="text-5xl font-bold mb-4 text-white cursor-pointer">
            <span
              class="hover:text-yellow-400 transition-colors duration-300"
              >Malaus</span
            >
            <span
              class="hover:text-yellow-400 transition-colors duration-300"
              >kayu</span
            >
            <span
              class="hover:text-yellow-400 transition-colors duration-300"
              >pu</span
            >
            <span
              class="hover:text-yellow-400 transition-colors duration-300"
              >kening</span
            >
            <span
              class="tracking-widest hover:text-yellow-400 transition-colors duration-300"
            >
              <span
                class="text-orange-500 hover:text-yellow-400 transition-colors duration-300"
              >
                Or<strong
                  class="text-yellow-500 hover:text-orange-400 transition-colors duration-300"
                  >PAW</strong
                >nage!
              </span>
            </span>
          </h1>
          <p
            class="text-xl/10 mt-10 mx-auto max-w-[700px] px-5 tracking-widest"
          >
            Save a life — adopt instead of buying, and gain a heart that
            will always love you back.
          </p>
        </div>
      </div>
    </div>

    <!-- Item 2 -->
    <div class="min-w-full flex-shrink-0 relative h-full">
      <img
        src="{{ asset('images/panoramadog.jpg') }}"
        class="absolute block w-full h-full object-cover"
        alt="Slide 2"
      />
      <div
        class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center"
      >
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
      <img
        src="{{ asset('images/dogss.jpg') }}"
        class="absolute block w-full h-full object-cover"
        alt="Slide 3"
      />
      <div
        class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center"
      >
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
  <button
    type="button"
    class="absolute top-1/2 left-4 z-30 flex items-center justify-center w-10 h-10 bg-white/30 rounded-full hover:bg-yellow-400/50 focus:outline-none"
    onclick="slidePrev()"
  >
    <span class="sr-only">Previous</span>
    <svg
      class="w-6 h-6 text-white"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 6 10"
    >
      <path
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M5 1 1 5l4 4"
      />
    </svg>
  </button>

  <button
    type="button"
    class="absolute top-1/2 right-4 z-30 flex items-center justify-center w-10 h-10 bg-white/30 rounded-full hover:bg-yellow-400/50 focus:outline-none"
    onclick="slideNext()"
  >
    <span class="sr-only">Next</span>
    <svg
      class="w-6 h-6 text-white"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 6 10"
    >
      <path
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="m1 9 4-4-4-4"
      />
    </svg>
  </button>
</div>
<!-- ========== END OF HERO CAROUSEL ========== -->

<!-- ========== START OF A NEW SECTION ========== -->
<section class="w-full py-16 bg-yellow-500 dark:bg-gray-800">
  <div
    class="max-w-screen-xl mx-auto flex flex-col md:flex-row items-center gap-10 px-4"
  >
    <!-- Image Section -->
    <div class="w-full md:w-1/2">
      <img
        src="{{ asset('images/black-dog.jpg') }}"
        class="w-full h-96 object-cover rounded-lg shadow-lg"
      />
    </div>

    <!-- Text Section -->
    <div
      class="w-full md:w-1/2 text-black flex flex-col justify-between gap-y-6"
    >
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

<!-- ========== START OF PETS THAT NEED ATTENTION ========== -->
<section class="w-full py-16 px-5 bg-gray-100">
  <div class="max-w-screen-xl mx-auto text-center mb-10">
    <h2 class="text-4xl font-bold text-black">Featured Pets</h2>
    <p class="text-black mt-2">
      Meet some of the pets that need attention.
    </p>
  </div>

  <!-- Scrollable Container -->
  <div class="max-w-screen-xl mx-auto overflow-x-auto">
    <div class="flex gap-x-4 flex-nowrap pb-6 pl-4">
      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- CARD -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 1"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Pet#1
          </h5>
          <p class="text-sm text-gray-600">Golden Retriever - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Pet#1 is a sweet and loving dog looking for a forever home.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>

      <!-- Duplicate cards to test scrolling -->
      <div
        class="bg-white card w-full max-w-[280px] flex-shrink-0 mx-auto rounded-lg shadow-md dark:bg-gray-800"
      >
        <a href="#" class="block overflow-hidden rounded-t-lg">
          <img
            class="rounded-t-lg h-60 w-full object-cover transition-transform hover:scale-110"
            src="{{ asset('images/black-dog.jpg') }}"
            alt="Pet 2"
          />
        </a>
        <div class="p-5 flex flex-col flex-grow">
          <h5 class="text-lg font-bold text-gray-900 dark:text-white">
            Max
          </h5>
          <p class="text-sm text-gray-600">Labrador - Dog</p>
          <p
            class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6"
          >
            Max is a fun and energetic dog who loves running around.
          </p>
          <a
            href="adoption-form.html"
            role="button"
            class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition"
          >
            Adopt Now
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ========== END OF PETS THAT NEED ATTENTION ========== -->

</x-layout>