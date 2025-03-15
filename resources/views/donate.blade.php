<x-layout>
  <!-- ========== START OF SECTION ========== -->
  <section class="flex flex-col md:flex-row-reverse min-h-screen pt-10">
    <!-- Right Side: Full-Screen Image (Now appears first on mobile) -->
    <div class="w-full md:w-1/2 bg-yellow-500">
      <img
        src="{{ asset('images/black-dog.jpg') }}"
        alt="Missing Pet"
        class="w-full h-full object-cover mix-blend-multiply"
      />
    </div>

    <!-- Left Side: Text Content -->
    <div
      class="bg-yellow-500 w-full md:w-1/2 flex justify-center items-center p-8"
    >
      <div class="max-w-2xl w-full px-6 py-4">
        <h1 class="text-3xl md:text-4xl font-bold text-black">
          YOUR DONATIONS
        </h1>
        <h2 class="text-2xl md:text-3xl mt-2">Makes A Difference</h2>

        <h3 class="text-lg md:text-xl font-semibold mt-4">We need:</h3>
        <ul class="mt-2 space-y-1 text-xl font-medium">
          <li class="flex items-center gap-2">
            <i class="ph-fill ph-check-fat text-black"></i> Food (Dry, Wet,
            Canned)
          </li>
          <li class="flex items-center gap-2">
            <i class="ph-fill ph-check-fat text-black"></i> Treats
          </li>
          <li class="flex items-center gap-2">
            <i class="ph-fill ph-check-fat text-black"></i> Collars/Leashes
          </li>
          <li class="flex items-center gap-2">
            <i class="ph-fill ph-check-fat text-black"></i> Cat Litter
          </li>
          <li class="flex items-center gap-2">
            <i class="ph-fill ph-check-fat text-black"></i> Towels
          </li>
          <li class="flex items-center gap-2">
            <i class="ph-fill ph-check-fat text-black"></i> Toys
          </li>
        </ul>

        <h3 class="text-lg md:text-xl font-semibold mt-6">
          Drop Off Location:
        </h3>
        <p class="flex items-center text-base mt-2">
          <i class="ph-fill ph-map-pin mr-2 text-black"></i> Angeles City
          Municipal Hall, Angeles City Veterinary Office
        </p>
        <p class="flex items-center text-base mt-2">
          <i class="ph-fill ph-map-pin mr-2 text-black"></i> 5J85+64M, City
          Hall Building, Aniceto Gueco Street, Pulung Maragul, Angeles, 2009
        </p>
      </div>
    </div>
  </section>
  <!-- ========== END OF SECTION ========== -->
</x-layout>