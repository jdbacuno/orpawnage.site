@foreach($featuredPets as $month => $images)
@foreach($images as $image)
<div
  class="gallery-item overflow-hidden rounded-lg shadow-md group cursor-pointer transition-all duration-300 hover:shadow-lg"
  data-src="{{ asset('storage/' . $image->image_path) }}" data-month="{{ date('n', strtotime($month)) }}"
  data-year="{{ date('Y', strtotime($month)) }}">
  <div class="relative aspect-square">
    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Featured adoption"
      class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105" loading="lazy">
    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300">
    </div>
  </div>
</div>
@endforeach
@endforeach