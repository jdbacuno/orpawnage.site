@if ($pets->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-5 sm:gap-y-10 justify-center">
  @foreach ($pets as $pet)
  <!-- CARD -->
  <div class="bg-white card w-full max-w-[350px] mx-auto rounded-lg shadow-lg flex flex-col">
    <a href="/services/{{ $pet->slug }}/adoption-form" class="block overflow-hidden rounded-t-lg">
      <img class="rounded-t-lg h-40 w-full object-cover transition-transform hover:transform-gpu hover:scale-110"
        src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image" />
    </a>
    <div class="p-5 flex flex-col flex-grow">
      <div class="flex justify-between items-center">
        <p class="text-lg text-gray-600 font-bold">{{ strtolower($pet->pet_name) !== 'n/a' ?
          ucwords($pet->pet_name) : 'Unnamed' }}</p>
        <span
          class="bg-yellow-500 text-sm text-black py-1 px-2 rounded rounded-lg flex items-center justify-center font-bold">
          {{ $pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $pet->pet_number }}</span>
      </div>

      <div class="mt-2 text-gray-800 text-sm truncate pb-6">
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
        class="mt-auto inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 hover:text-black transition">
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