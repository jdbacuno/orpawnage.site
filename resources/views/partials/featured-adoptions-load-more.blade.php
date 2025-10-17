@foreach($featuredPets as $month => $images)
@foreach($images as $image)
<div
  class="gallery-item relative overflow-hidden rounded-lg shadow-md group cursor-pointer transition-all duration-300 hover:shadow-lg"
  data-src="{{ asset('storage/' . $image->image_path) }}" data-month="{{ date('n', strtotime($month)) }}"
  data-year="{{ date('Y', strtotime($month)) }}">
  <div class="relative aspect-square">
    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Featured adoption"
      class="object-cover w-full h-auto transition-transform duration-300 group-hover:scale-105" loading="lazy">
    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300">
    </div>
  </div>

  <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
    <span
      class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white/90 text-gray-800 backdrop-blur">
      {{ date('M Y', strtotime($month)) }}
    </span>
    <span
      class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-orange-500 text-white shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
      <i class="ph ph-magnifying-glass"></i>
    </span>
  </div>
</div>
@endforeach
@endforeach
