<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative w-full h-[70vh]">
    <img src="{{ asset('images/banner.jpg') }}" alt="Hero Image" class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
    <div class="absolute inset-0 flex items-center justify-center text-center px-5">
      <h1 class="text-white text-5xl font-bold md:text-6xl cursor-pointer">
        About
        <span class="text-orange-500 tracking-widest hover:text-yellow-400 transition-colors duration-500">
          Or<strong class="text-yellow-500 hover:text-orange-400 transition-colors duration-00">PAW</strong>nage
        </span>
      </h1>
    </div>
  </section>

  <!-- ========== WHO WE ARE SECTION ========== -->
  <div class="bg-yellow-500/30">
    <section class="max-w-screen-xl mx-auto px-5 py-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
      <!-- Left Content -->
      <div class="lg:pl-8">
        <h2 class="text-4xl font-bold text-black">Who We Are</h2>
        <p class="text-black text-lg/8 mt-4 text-justify">
          OrPAWnage is a dedicated pet adoption and rescue organization that
          helps animals find loving homes. Our mission is to ensure that
          every pet gets the care, attention, and love they deserve. We work
          tirelessly to connect compassionate individuals with furry friends
          in need. Join us in making a difference, one paw at a time. Lorem
          ipsum, dolor sit amet consectetur adipisicing elit.
        </p>
        <p class="text-black text-lg mt-2 text-justify">
          Recusandae natus vero non sint libero! Rerum perferendis sint
          excepturi atque quis dolores.
        </p>
      </div>

      <!-- Right Image -->
      <div class="flex justify-center">
        <img src="{{ asset('images/cityvet_logo.png') }}" alt="Who We Are Image" class="w-full max-w-sm rounded-lg" />
      </div>
    </section>
  </div>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START MISSION & SERVICES SECTION ========== -->
  <section class="max-w-screen-xl mx-auto px-5 py-16 grid grid-cols-1 md:grid-cols-2 gap-10">
    <!-- Left Side -->
    <div class="flex flex-col gap-10">
      <!-- Our Mission Card -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-orange-400">Our Mission</h2>
        <p class="text-gray-600 mt-4">
          At OrPAWnage, our mission is to provide shelter, medical care, and
          loving homes to abandoned pets. We believe that every pet deserves
          a second chance at happiness and work tirelessly to make this a
          reality.
        </p>
        <p class="text-gray-600 mt-2">
          Through our dedicated team and volunteers, we ensure that every
          rescued pet is given the care, rehabilitation, and love they need
          before finding their forever home.
        </p>
      </div>

      <!-- How Can You Help Card -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-orange-400">
          How Can You Help?
        </h2>
        <ul class="mt-4 space-y-3">
          <li class="flex items-start gap-3">
            <span class="text-yellow-500 text-lg"><i class="ph-fill ph-paw-print"></i></span>
            <p class="text-gray-600">
              Adopt a pet in need and provide them with a loving forever
              home.
            </p>
          </li>
          <li class="flex items-start gap-3">
            <span class="text-yellow-500 text-lg"><i class="ph-fill ph-paw-print"></i></span>
            <p class="text-gray-600">
              Volunteer at our shelter to help with feeding, grooming, and
              socializing pets.
            </p>
          </li>
          <li class="flex items-start gap-3">
            <span class="text-yellow-500 text-lg"><i class="ph-fill ph-paw-print"></i></span>
            <p class="text-gray-600">
              Make a donation to support our rescue efforts, medical
              treatments, and food supplies.
            </p>
          </li>
        </ul>
      </div>
    </div>

    <!-- Right Side -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col">
      <img src="{{ asset('images/woman_spaying.jpg') }}" alt="Our Services"
        class="w-full h-[400px] object-cover rounded-lg" />
      <h2 class="text-3xl font-bold text-orange-400 mt-6">Our Services</h2>
      <ul class="mt-4 space-y-3">
        <li class="flex items-start gap-3">
          <span class="text-yellow-500 text-lg"><i class="ph-fill ph-paw-print"></i></span>
          <p class="text-gray-600">
            Providing medical care and vaccinations to rescued pets.
          </p>
        </li>
        <li class="flex items-start gap-3">
          <span class="text-yellow-500 text-lg"><i class="ph-fill ph-paw-print"></i></span>
          <p class="text-gray-600">
            Facilitating pet adoptions to ensure a loving match for both
            pets and owners.
          </p>
        </li>
        <li class="flex items-start gap-3">
          <span class="text-yellow-500 text-lg"><i class="ph-fill ph-paw-print"></i></span>
          <p class="text-gray-600">
            Educating the community on responsible pet ownership and animal
            welfare.
          </p>
        </li>
      </ul>
    </div>
  </section>
  <!-- ========== END OF MISSION & SERVICES SECTION ========== -->

  <!-- ========== START OF TEAM SECTION ========== -->
  <div class="bg-black">
    <section class="max-w-screen-xl mx-auto px-5 py-16">
      <h2 class="text-4xl font-bold text-yellow-500 text-center">
        Meet Our Team
      </h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10 mt-20">
        <div class="flex flex-col items-center text-center">
          <img src="{{ asset('images/dl1.jpg') }}" alt="Team Member"
            class="w-40 h-40 md:w-32 md:h-32 object-cover rounded-full shadow-lg hover:outline hover:outline-offset-4 hover:outline-yellow-500 hover:shadow-none transition-outline duration-100" />
          <h3 class="text-xl font-bold mt-4 text-yellow-500">Lorem Name</h3>
          <p class="text-white text-sm">Frontend Developer</p>
        </div>
        <div class="flex flex-col items-center text-center">
          <img src="{{ asset('images/dl2.jpg') }}" alt="Team Member"
            class="w-40 h-40 md:w-32 md:h-32 object-cover rounded-full shadow-lg hover:outline hover:outline-offset-4 hover:outline-yellow-500 hover:shadow-none transition-outline duration-100" />
          <h3 class="text-xl font-bold mt-4 text-yellow-500">
            Lorem Ipsum
          </h3>
          <p class="text-white text-sm">Project Manager</p>
        </div>
        <div class="flex flex-col items-center text-center">
          <img src="{{ asset('images/dl3.jpg') }}" alt="Team Member"
            class="w-40 h-40 md:w-32 md:h-32 object-cover rounded-full shadow-lg hover:outline hover:outline-offset-4 hover:outline-yellow-500 hover:shadow-none transition-outline duration-100" />
          <h3 class="text-xl font-bold mt-4 text-yellow-500">
            Lorem Ipsum
          </h3>
          <p class="text-white text-sm">UI Designer</p>
        </div>
        <div class="flex flex-col items-center text-center">
          <img src="{{ asset('images/dl4.jpg') }}" alt="Team Member"
            class="w-40 h-40 md:w-32 md:h-32 object-cover rounded-full shadow-lg hover:outline hover:outline-offset-4 hover:outline-yellow-500 hover:shadow-none transition-outline duration-100" />
          <h3 class="text-xl font-bold mt-4 text-yellow-500">
            Lorem Name
          </h3>
          <p class="text-white text-sm">Backend Developer</p>
        </div>
        <div class="flex flex-col items-center text-center">
          <img src="{{ asset('images/kth.jpg') }}" alt="Team Member"
            class="w-40 h-40 md:w-32 md:h-32 object-cover rounded-full shadow-lg hover:outline hover:outline-offset-4 hover:outline-yellow-500 hover:shadow-none transition-outline duration-100" />
          <h3 class="text-xl font-bold mt-4 text-yellow-500">
            Lorem Name
          </h3>
          <p class="text-white text-sm">Researcher</p>
        </div>
      </div>
    </section>
  </div>
  <!-- END OF TEAM SECTION -->
</x-layout>