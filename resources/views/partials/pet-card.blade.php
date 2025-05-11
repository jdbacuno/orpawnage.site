<div
  class="relative bg-white w-full max-w-[350px] mx-auto rounded-lg shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300"
  wire:poll.10s>
  <a href="/services/{{ $pet->slug }}/adoption-form" class="block">
    <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
      class="h-64 w-full object-cover group-hover:brightness-95 transition-brightness duration-300" />
  </a>

  <!-- Slide-Up Panel with Blur -->
  <div
    class="absolute bottom-0 left-0 w-full bg-white/50 backdrop-blur-sm text-gray-900 p-4 translate-y-full group-hover:translate-y-0 transition-translate duration-300 ease-in-out">

    <!-- Name & ID -->
    <div class="flex justify-between items-center mb-3">
      <h3 class="text-lg font-bold">
        {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
      </h3>
      <span class="bg-yellow-400 text-xs text-black py-1 px-2 rounded font-bold">
        {{ $pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $pet->pet_number }}
      </span>
    </div>

    <!-- Colorized Badges -->
    <div class="flex flex-wrap gap-2 mb-3">
      <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full border border-blue-200">
        {{ $pet->age }} {{ $pet->age == 1 ? Str::singular($pet->age_unit) : Str::plural($pet->age_unit) }} old
      </span>
      <span
        class="{{ $pet->sex == 'male' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-pink-100 text-pink-800 border-pink-200' }} text-xs px-3 py-1 rounded-full border">
        {{ ucfirst($pet->sex) }}
      </span>
      <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full border border-green-200">
        {{ ucfirst($pet->color) }}
      </span>
    </div>

    <!-- HIGHLIGHTED TIMESTAMP - Now more visible -->
    <div class="flex justify-end">
      <span class="bg-black/10 text-gray-700 text-xs px-3 py-1 rounded-full backdrop-blur-lg inline-flex items-center">
        <i class="ph-fill ph-clock mr-1"></i> Added {{ \Carbon\Carbon::parse($pet->created_at)->diffForHumans() }}
      </span>
    </div>

    <!-- YOUR ORIGINAL BUTTON -->
    <a href="/services/{{ $pet->slug }}/adoption-form"
      class="mt-3 block text-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-400 hover:text-black transition-color duration-100 ease-in">
      <i class="ph-fill ph-paw-print mr-1"></i> View More Details
    </a>
  </div>
</div>