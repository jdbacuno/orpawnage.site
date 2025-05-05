<div class="relative bg-white w-full max-w-[350px] mx-auto rounded-lg shadow-lg overflow-hidden group" wire:poll.10s>
  <a href="/services/{{ $pet->slug }}/adoption-form" class="block">
    <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
      class="h-64 w-full object-cover" />
  </a>

  <!-- Slide-Up Info Panel -->
  <div
    class="absolute bottom-0 left-0 w-full bg-white/50 backdrop-blur-md text-gray-900 p-4 translate-y-full group-hover:translate-y-0 transition-all duration-300 ease-in">
    <div class="flex justify-between items-center mb-2">
      <p class="text-lg font-bold">{{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
      </p>
      <span class="bg-yellow-500 text-sm text-black py-1 px-2 rounded font-bold">
        {{ $pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $pet->pet_number }}
      </span>
    </div>

    <ul class="text-sm space-y-1">
      <li><span class="font-semibold">Age:</span> {{ $pet->age }} {{ $pet->age == 1 ? Str::singular($pet->age_unit) :
        Str::plural($pet->age_unit) }} old</li>
      <li><span class="font-semibold">Sex:</span> {{ ucfirst($pet->sex) }}</li>
      <li><span class="font-semibold">Reproductive:</span> {{ ucfirst($pet->reproductive_status) }}</li>
      <li><span class="font-semibold">Color:</span> {{ ucfirst($pet->color) }}</li>
      <li><span class="font-semibold">Source:</span> {{ ucfirst($pet->source) }}</li>
    </ul>

    @php
    $timeAgo = \Carbon\Carbon::parse($pet->created_at)->diffForHumans();
    @endphp

    <p class="text-black font-semibold text-sm mt-2 italic text-right">Added {{ $timeAgo }}</p>

    <a href="/services/{{ $pet->slug }}/adoption-form"
      class="mt-3 block text-center px-3 py-2 text-sm font-medium text-white bg-orange-400 rounded-lg hover:bg-yellow-500 hover:text-black transition-color duration-100 ease-in">
      <i class="ph-fill ph-paw-print mr-2"></i> Adopt this {{ $pet->species === 'feline' ? 'Cat' : 'Dog' }}
    </a>
  </div>
</div>