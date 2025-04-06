<x-layout>
  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="bg-yellow-500 mt-10 py-16">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Header Section -->
      <div class="text-black flex items-center mb-6" id="pets">
        <h2 class="text-4xl font-extrabold text-black">
          Featured Pets
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
          <!-- CARD -->
          <div
            class="bg-white card w-full max-w-[350px] mx-auto rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 flex flex-col">
            <a href="/services/{{ $featured->slug }}/adoption-form" class="block overflow-hidden rounded-t-lg">
              <img
                class="rounded-t-lg h-60 w-full object-cover transition-transform hover:transform-gpu hover:scale-110"
                src="{{ asset('storage/' . ($featured->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image" />
            </a>
            <div class="p-5 flex flex-col flex-grow">
              <h5 class="text-lg font-bold text-gray-900 dark:text-white">Pet #{{ $featured->pet_number }}</h5>
              <p class="text-sm text-gray-600">{{ strtolower($featured->pet_name) !== 'n/a' ?
                ucwords($featured->pet_name) . ' - '
                :
                '' }}{{
                ucfirst($featured->species) }}</p>
              <div class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6">
                <ul>
                  {{-- <li><span class="text-md text-black font-bold">Adoption Likelihood:</span> {{
                    number_format($featured->adoption_probability * 100, 1) }}%</li> --}}
                  <li><span class="text-md text-black font-bold">Age:</span> {{ $featured->age }} {{ $featured->age == 1
                    ?
                    Str::singular($featured->age_unit) : Str::plural($featured->age_unit) }} old</li>
                  <li><span class="text-md text-black font-bold">Sex:</span> {{ ucfirst($featured->sex) }}</li>
                  <li><span class="text-md text-black font-bold">Reproductive Status:</span> {{
                    ucfirst($featured->reproductive_status) }}</li>
                  <li><span class="text-md text-black font-bold">Color:</span> {{ ucfirst($featured->color) }}</li>
                  <li><span class="text-md text-black font-bold">Source:</span> {{ ucfirst($featured->source) }}</li>
                </ul>
              </div>
              <a href="/services/{{ $featured->slug }}/adoption-form" role="button"
                class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition">
                Adopt Now
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
      <div class="text-center text-black mt-10">
        <p class="text-lg font-semibold">
          No pets found in the featured list.
        </p>
        <p class="text-xl">Check back later!</p>
      </div>
      @endif

    </div>
  </section>
</x-layout>