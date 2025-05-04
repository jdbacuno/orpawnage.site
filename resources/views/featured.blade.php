<x-layout>
  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="bg-gray-50 mt-10 py-16">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Header Section -->
      <div class="text-black flex items-center mb-6" id="pets">
        <h2 class="text-4xl font-extrabold text-black px-4">
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
          <div class="relative bg-white w-full max-w-[350px] mx-auto rounded-lg shadow-lg overflow-hidden group">
            <a href="/services/{{ $featured->slug }}/adoption-form" class="block">
              <img src="{{ asset('storage/' . ($featured->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
                class="h-64 w-full object-cover" />
            </a>

            <!-- Slide-Up Info Panel -->
            <div
              class="absolute bottom-0 left-0 w-full bg-white/50 backdrop-blur-md text-gray-900 p-4 translate-y-full group-hover:translate-y-0 transition-all duration-300 ease-in">
              <div class="flex justify-between items-center mb-2">
                <p class="text-lg font-bold">
                  {{ strtolower($featured->pet_name) !== 'n/a' ? ucwords($featured->pet_name) : 'Unnamed' }}
                </p>
                <span class="bg-yellow-500 text-sm text-black py-1 px-2 rounded font-bold">
                  {{ $featured->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $featured->pet_number }}
                </span>
              </div>

              <ul class="text-sm space-y-1">
                <li><span class="font-semibold">Age:</span> {{ $featured->age }}
                  {{ $featured->age == 1 ? Str::singular($featured->age_unit) : Str::plural($featured->age_unit) }} old
                </li>
                <li><span class="font-semibold">Sex:</span> {{ ucfirst($featured->sex) }}</li>
                <li><span class="font-semibold">Reproductive:</span> {{ ucfirst($featured->reproductive_status) }}</li>
                <li><span class="font-semibold">Color:</span> {{ ucfirst($featured->color) }}</li>
                <li><span class="font-semibold">Source:</span> {{ ucfirst($featured->source) }}</li>
              </ul>

              @php
              $timeAgo = \Carbon\Carbon::parse($featured->created_at)->diffForHumans();
              @endphp

              <p class="text-black font-semibold text-sm mt-2 italic text-right">Added {{ $timeAgo }}</p>

              <a href="/services/{{ $featured->slug }}/adoption-form"
                class="mt-3 block text-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 hover:text-black transition-color duration-100 ease-in">
                <i class="ph-fill ph-paw-print mr-2"></i> Adopt this {{ $featured->species === 'feline' ? 'Cat' : 'Dog'
                }}
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
          No pets found in the featured list.
        </p>
        <p class="text-xl">Check back later!</p>
      </div>
      @endif

    </div>
  </section>
</x-layout>