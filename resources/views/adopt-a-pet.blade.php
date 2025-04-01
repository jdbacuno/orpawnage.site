<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="bg-gray-50 dark:bg-gray-900 py-20 md:pt-28">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8 lg:flex lg:items-center lg:gap-x-6">
      <!-- LEFT SIDE CONTENT -->
      <div class="lg:w-1/2 mb-10 lg:mb-0 text-center lg:text-left">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
          Lorem ipsum dolor
          <span class="text-orange-500">Or<span class="text-yellow-500">PAW</span>nage</span>
        </h1>
        <p class="mt-4 text-gray-600 dark:text-gray-400">
          Browse through hundreds of pets looking for a new home. Give them
          a second chance at life.
        </p>

        <!-- SEARCH BAR -->
        <div class="mt-6">
          <form class="max-w-md mx-auto">
            <label for="default-search"
              class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
              </div>
              <input type="search" id="default-search"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-orange-500 focus:border-orange-500"
                placeholder="Search by species, color, etc..." required />
              <button type="submit"
                class="text-white absolute end-2.5 bottom-2.5 bg-orange-500 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-400/60 font-medium rounded-full text-sm px-4 py-2">
                Search
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- RIGHT SIDE IMAGE -->
      <div class="lg:w-1/2">
        <img src="{{ asset('images/catdogBG.jpg') }}" alt="Pet Adoption Hero Image"
          class="w-full max-w-[500px] mx-auto rounded-lg shadow-lg" />
      </div>
    </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="bg-yellow-500 py-16">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Header Section -->
      <div class="text-black flex flex-col justify-center items-center mb-6 gap-10" id="pets">
        <h2 class="text-4xl font-extrabold text-black">
          Available Pets for Adoption
        </h2>
        <!-- Filters Section -->
        <div class="flex flex-wrap gap-4 items-center justify-center">
          <form method="GET" action="{{ request()->url() }}#pets" class="flex flex-wrap gap-4">
            <!-- Species Filter -->
            <select name="species"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
              onchange="this.form.submit()">
              <option value="">All Species</option>
              <option value="feline" {{ request('species')=='feline' ? 'selected' : '' }}>Cats</option>
              <option value="canine" {{ request('species')=='canine' ? 'selected' : '' }}>Dogs</option>
            </select>

            <!-- Gender Filter -->
            <select name="sex"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
              onchange="this.form.submit()">
              <option value="">All Genders</option>
              <option value="male" {{ request('sex')=='male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ request('sex')=='female' ? 'selected' : '' }}>Female</option>
            </select>

            <!-- Reproductive Status Filter -->
            <select name="reproductive_status"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[200px]"
              onchange="this.form.submit()">
              <option value="">All Reproductive Statuses</option>
              <option value="intact" {{ request('reproductive_status')=='intact' ? 'selected' : '' }}>Intact</option>
              <option value="neutered" {{ request('reproductive_status')=='neutered' ? 'selected' : '' }}>Neutered
              </option>
              <option value="unknown" {{ request('reproductive_status')=='unknown' ? 'selected' : '' }}>Unknown
              </option>
            </select>

            <!-- Color Filter -->
            <select name="color"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
              onchange="this.form.submit()">
              <option value="">All Colors</option>
              <option value="black" {{ request('color')=='black' ? 'selected' : '' }}>Black</option>
              <option value="white" {{ request('color')=='white' ? 'selected' : '' }}>White</option>
              <option value="gray" {{ request('color')=='gray' ? 'selected' : '' }}>Gray</option>
              <option value="brown" {{ request('color')=='brown' ? 'selected' : '' }}>Brown</option>
              <option value="orange" {{ request('color')=='orange' ? 'selected' : '' }}>Orange</option>
              <option value="calico" {{ request('color')=='calico' ? 'selected' : '' }}>Calico</option>
              <option value="tabby" {{ request('color')=='tabby' ? 'selected' : '' }}>Tabby</option>
              <option value="bi-color" {{ request('color')=='bi-color' ? 'selected' : '' }}>Bi-Color</option>
              <option value="tri-color" {{ request('color')=='tri-color' ? 'selected' : '' }}>Tri-Color</option>
              <option value="others" {{ request('color')=='others' ? 'selected' : '' }}>Others</option>
            </select>

            <!-- Source Filter -->
            <select name="source"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
              onchange="this.form.submit()">
              <option value="">All Sources</option>
              <option value="surrendered" {{ request('source')=='surrendered' ? 'selected' : '' }}>Surrendered</option>
              <option value="rescued" {{ request('source')=='rescued' ? 'selected' : '' }}>Rescued</option>
              <option value="other" {{ request('source')=='other' ? 'selected' : '' }}>Other</option>
            </select>

            <!-- Combined Sort Dropdown -->
            <div>
              <select name="sort_by"
                class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[200px]"
                onchange="this.form.submit()">
                <option value="latest" {{ request('sort_by')=='latest' ? 'selected' : '' }}>Recently Added</option>
                <option value="oldest" {{ request('sort_by')=='oldest' ? 'selected' : '' }}>Oldest (by Date)</option>
                <option value="youngest" {{ request('sort_by')=='youngest' ? 'selected' : '' }}>Youngest (by Age)
                </option>
                <option value="oldest_age" {{ request('sort_by')=='oldest_age' ? 'selected' : '' }}>Oldest (by Age)
                </option>
              </select>
            </div>

            <!-- Filter Button -->
            {{-- <button type="submit"
              class="px-4 py-2 bg-orange-400 text-white font-bold rounded-lg hover:bg-yellow-500 transition">
              Apply Filters
            </button> --}}
          </form>
        </div>


      </div>

      <!-- Pet Cards Grid -->
      @if ($pets->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-10 justify-center">
        @foreach ($pets as $pet)
        <!-- CARD -->
        <div
          class="bg-white card w-full max-w-[350px] mx-auto rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 flex flex-col">
          <a href="/services/{{ $pet->slug }}/adoption-form" class="block overflow-hidden rounded-t-lg">
            <img class="rounded-t-lg h-60 w-full object-cover transition-transform hover:transform-gpu hover:scale-110"
              src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image" />
          </a>
          <div class="p-5 flex flex-col flex-grow">
            <h5 class="text-lg font-bold text-gray-900 dark:text-white">Pet #{{ $pet->pet_number }}</h5>
            <p class="text-sm text-gray-600">{{ ucfirst($pet->species) }}</p>
            <div class="mt-2 text-gray-800 dark:text-gray-400 text-sm truncate pb-6">
              <ul>
                <li><span class="text-md text-black font-bold">Age:</span> {{ $pet->age }} {{ $pet->age == 1 ?
                  Str::singular($pet->age_unit) : Str::plural($pet->age_unit) }} old</li>
                <li><span class="text-md text-black font-bold">Sex:</span> {{ ucfirst($pet->sex) }}</li>
                <li><span class="text-md text-black font-bold">Reproductive Status:</span> {{
                  ucfirst($pet->reproductive_status) }}</li>
                <li><span class="text-md text-black font-bold">Color:</span> {{ ucfirst($pet->color) }}</li>
                <li><span class="text-md text-black font-bold">Source:</span> {{ ucfirst($pet->source) }}</li>
              </ul>
            </div>
            <a href="/services/{{ $pet->slug }}/adoption-form" role="button"
              class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 transition">
              Adopt Now
            </a>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <!-- No Pets Found Message -->
      <div class="text-center text-black mt-10">
        <p class="text-lg font-semibold">
          No pets found matching your filters.
        </p>
        <p class="text-xl">Try adjusting your search criteria.</p>
      </div>
      @endif


      <hr class="my-6 border-gray-400/50 sm:mx-auto dark:border-gray-700 lg:my-8" />

      <!-- Tailwind Pagination -->
      @if ($pets->count() > 0)
      <div class="mt-8">
        {{ $pets->appends(request()->query())->links()->withPath(request()->url() . '#pets') }}
      </div>
      @endif

    </div>
  </section>
  <!-- ========== END OF PET LISTING SECTION ========== -->
</x-layout>