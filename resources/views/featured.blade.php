<x-layout>
  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="bg-gray-50 mt-10 py-16 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Header Section -->
      <div class="text-black flex items-center mb-6" id="pets">
        <h2 class="text-4xl font-extrabold text-black px-4 flex items-center">
          <i class="ph-fill ph-paw-print mr-2 text-orange-400"></i>Featured Pets
        </h2>
      </div>

      @if ($featuredPets->count() > 0)
      <div class="container mx-auto px-4">
        <p class="text-md text-black font-semibold mb-6">
          These pets have a lower chance of being adopted based on our analysis.
        </p>

        <!-- Pet Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-10 justify-center">
          @foreach ($featuredPets as $featured)
          <!-- ENHANCED CARD DESIGN -->
          <div
            class="relative bg-white w-full max-w-[350px] mx-auto rounded-lg shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
            <a href="/services/{{ $featured->slug }}/adoption-form" class="block">
              <img src="{{ asset('storage/' . ($featured->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
                class="h-64 w-full object-cover group-hover:brightness-95 transition-all duration-300" />
            </a>

            <!-- Enhanced Slide-Up Panel -->
            <div
              class="absolute bottom-0 left-0 w-full bg-white/50 backdrop-blur-md text-gray-900 p-4 translate-y-full group-hover:translate-y-0 transition-all duration-300 ease-in-out">

              <!-- Name & ID -->
              <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-bold text-black">
                  {{ strtolower($featured->pet_name) !== 'n/a' ? ucwords($featured->pet_name) : 'Unnamed' }}
                </h3>
                <span class="bg-yellow-400 text-xs text-black py-1 px-2 rounded font-bold">
                  {{ $featured->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $featured->pet_number }}
                </span>
              </div>

              <!-- Colorized Badges -->
              <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full border border-blue-200">
                  {{ $featured->age }} {{ $featured->age == 1 ? Str::singular($featured->age_unit) :
                  Str::plural($featured->age_unit) }} old
                </span>
                <span
                  class="{{ $featured->sex == 'male' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-pink-100 text-pink-800 border-pink-200' }} text-xs px-3 py-1 rounded-full border">
                  {{ ucfirst($featured->sex) }}
                </span>
                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full border border-green-200">
                  {{ ucfirst($featured->color) }}
                </span>
              </div>

              <!-- Highlighted Timestamp -->
              <div class="flex justify-end">
                <span
                  class="bg-black/10 text-gray-700 text-xs px-3 py-1 rounded-full backdrop-blur-lg inline-flex items-center">
                  <i class="ph-fill ph-clock mr-1"></i> Added {{
                  \Carbon\Carbon::parse($featured->created_at)->diffForHumans() }}
                </span>
              </div>

              <!-- Original Button -->
              <a href="/services/{{ $featured->slug }}/adoption-form"
                class="mt-3 block text-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-400 hover:text-black transition-color duration-100 ease-in">
                <i class="ph-fill ph-paw-print mr-1"></i> View More Details
              </a>
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
        <p class="text-lg font-semibold">
          No featured pets at the moment.
        </p>
        <p class="text-xl">Check back later!</p>
      </div>
      @endif
    </div>
  </section>
</x-layout>