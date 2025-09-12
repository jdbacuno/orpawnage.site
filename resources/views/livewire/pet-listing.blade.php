<div>
  <!-- Header Section -->
  <div class="text-black flex flex-col items-center mb-6 gap-6" id="pets">
    <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4 sm:gap-8">
      {{-- TITLE --}}
      <h2 class="text-3xl sm:text-4xl font-extrabold text-black sm:mr-auto">
        Available Pets for Adoption
      </h2>

      <!-- SEARCH BAR -->
      <div class="w-full sm:w-[350px]">
        <form class="w-full" onsubmit="event.preventDefault();">
          <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
              </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="search" id="search"
              class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-orange-500 focus:border-orange-500"
              placeholder="Search by species, color, etc..." />
          </div>
        </form>
      </div>
    </div>
  </div>
  <div>
    <!-- Filters Section -->
    <div class="flex flex-wrap gap-4 items-center w-full mb-6">
      <!-- Species Filter -->
      <select wire:model.live="species"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-full px-4 py-2.5 min-w-[120px]">
        <option value="">All Species</option>
        <option value="feline">Cats</option>
        <option value="canine">Dogs</option>
      </select>

      <!-- Gender Filter -->
      <select wire:model.live="sex"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-full px-4 py-2.5 min-w-[120px]">
        <option value="">All Genders</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>

      <!-- Reproductive Status Filter -->
      <select wire:model.live="reproductive_status"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-full px-4 py-2.5 min-w-[200px]">
        <option value="">All Reproductive Statuses</option>
        <option value="intact">Intact</option>
        <option value="neutered">Neutered</option>
        <option value="unknown">Unknown</option>
      </select>

      <!-- Color Filter -->
      <select wire:model.live="color"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-full px-4 py-2.5 min-w-[100px]">
        <option value="">All Colors</option>
        <option value="black">Black</option>
        <option value="white">White</option>
        <option value="gray">Gray</option>
        <option value="brown">Brown</option>
        <option value="brindle">Brindle</option>
        <option value="orange">Orange</option>
        <option value="calico">Calico</option>
        <option value="tabby">Tabby</option>
        <option value="bi-color">Bi-Color</option>
        <option value="tri-color">Tri-Color</option>
        <option value="others">Others</option>
      </select>

      <!-- Source Filter -->
      <select wire:model.live="source"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-full px-4 py-2.5 min-w-[150px]">
        <option value="">All Sources</option>
        <option value="surrendered">Surrendered</option>
        <option value="rescued">Rescued</option>
        <option value="other">Other</option>
      </select>

      <!-- Combined Sort Dropdown -->
      <select wire:model.live="sort_by"
        class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-full px-4 py-2.5 min-w-[150px]">
        <option value="">Sort By</option>
        <option value="latest">Newest Arrivals</option>
        <option value="oldest">Oldest Arrivals</option>
        <option value="youngest">Youngest First</option>
        <option value="oldest_age">Oldest First</option>
      </select>

      <!-- Reset Filters Button -->
      <button wire:click="resetFilters"
        class="bg-gray-200 hover:bg-gray-300 border border-black text-center text-gray-800 px-4 py-2.5 rounded-lg text-sm min-w-[150px]">
        Reset Filters
      </button>
    </div>

    <!-- Pet Cards Grid Container -->
    @if ($pets->count() > 0)
    <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-5 sm:gap-y-10 justify-center">
      @foreach ($pets as $pet)
      @include('partials.pet-card', ['pet' => $pet])
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

    <!-- Pagination -->
    <div class="mt-8">
      {{ $pets->links() }}
    </div>
  </div>
</div>