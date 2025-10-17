<div
  class="relative bg-white w-full mx-auto rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition-all duration-200 border border-gray-200"
  wire:poll.10s>

  <!-- Image with click handler -->
  <div class="block relative cursor-pointer" onclick="toggleSlideUp(this.closest('.group'))">
    <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
      class="h-64 w-full object-cover group-hover:brightness-95 transition-all duration-300 {{ $pet->archived_at ? 'grayscale opacity-60' : '' }}" />
    @if($pet->archived_at && $pet->archive_reason === 'Pet has passed away')
    <div class="absolute top-2 left-2">
      <span class="bg-gray-600 text-white text-[10px] font-bold px-2 py-1 rounded">Deceased</span>
    </div>
    @elseif($pet->archived_at)
    <div class="absolute top-2 left-2">
      <span class="bg-gray-600 text-white text-[10px] font-bold px-2 py-1 rounded">Archived</span>
    </div>
    @else
    <div class="absolute top-2 left-2">
      <span class="bg-rose-600 text-white text-[10px] font-bold px-2 py-1 rounded">Pick me!</span>
    </div>
    @endif
    <div class="absolute top-2 right-2">
      <span class="bg-black/60 text-white text-[10px] px-2 py-1 rounded flex items-center">
        <i class="ph-fill ph-clock mr-1"></i>
        Added {{ \Carbon\Carbon::parse($pet->created_at)->diffForHumans() }}
      </span>
    </div>
  </div>

  <!-- Slide-Up Panel with Blur -->
  <div
    class="slide-up-panel absolute bottom-0 left-0 w-full bg-white/70 backdrop-blur-md text-gray-900 p-4 translate-y-full transition-all duration-300 ease-in-out">

    <!-- Name & ID -->
    <div class="flex justify-between items-center mb-3">
      <h3 class="text-lg font-bold text-black">
        {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
      </h3>
      <span class="bg-yellow-400 text-xs text-black py-1 px-2 rounded font-bold">
        {{ $pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $pet->pet_number }}
      </span>
    </div>

    <!-- Colorized Badges -->
    <div class="flex flex-wrap gap-2 mb-3">
      <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full border border-blue-200 cursor-pointer"
        data-description="Age" onclick="event.stopPropagation(); changeText(this)">
        {{ $pet->formatted_age }} {{ $pet->formatted_age == 1 ? Str::singular($pet->age_unit) :
        Str::plural($pet->age_unit) }} old
      </span>
      <span
        class="{{ $pet->sex == 'male' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-pink-100 text-pink-800 border-pink-200' }} text-xs px-3 py-1 rounded-full border cursor-pointer"
        data-description="Sex" onclick="event.stopPropagation(); changeText(this)">
        {{ ucfirst($pet->sex) }}
      </span>
      <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full border border-green-200 cursor-pointer"
        data-description="Color" onclick="event.stopPropagation(); changeText(this)">
        {{ ucfirst($pet->color) }}
      </span>
      @php
      $ageYears = 0;
      if (strtolower($pet->age_unit) === 'year' || strtolower($pet->age_unit) === 'years') {
      $ageYears = (int) $pet->age;
      } elseif (strtolower($pet->age_unit) === 'month' || strtolower($pet->age_unit) === 'months') {
      $ageYears = floor(((int) $pet->age) / 12);
      }
      @endphp
      @if ($ageYears >= 6)
      <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full border border-purple-200">
        Senior
      </span>
      @endif
    </div>

    <div class="flex items-center justify-between">
      <div class="text-[11px] text-gray-600 inline-flex items-center gap-2">
        <span class="inline-flex items-center"><i class="ph-fill ph-sparkle mr-1 text-amber-600"></i>Give me a
          chance</span>
      </div>
      <div class="flex items-center gap-2">
        <a href="/services/{{ $pet->slug }}/adoption-form" onclick="event.stopPropagation()"
          class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
          <i class="ph-fill ph-paw-print mr-1"></i>Adopt me
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleSlideUp(card) {
  const panel = card.querySelector('.slide-up-panel');
  const isOpen = !panel.classList.contains('translate-y-full');

  if (isOpen) {
    // Close
    panel.classList.add('translate-y-full');
    card.classList.remove('details-open');
  } else {
    // Close all other open panels first
    document.querySelectorAll('.slide-up-panel').forEach(p => {
      p.classList.add('translate-y-full');
      p.closest('.group').classList.remove('details-open');
    });

    // Open this one
    panel.classList.remove('translate-y-full');
    card.classList.add('details-open');
  }
}

function closeSlideUp(button) {
  const panel = button.closest('.slide-up-panel');
  const card = button.closest('.group');
  panel.classList.add('translate-y-full');
  card.classList.remove('details-open');
}

// Close slide-up when clicking outside
document.addEventListener('click', function(e) {
  if (!e.target.closest('.group')) {
    document.querySelectorAll('.slide-up-panel').forEach(panel => {
      panel.classList.add('translate-y-full');
      panel.closest('.group').classList.remove('details-open');
    });
  }
});
</script>
