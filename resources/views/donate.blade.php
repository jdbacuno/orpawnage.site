<x-layout>
  <!-- ========== START OF DONATION SECTION ========== -->
  <section class="relative min-h-screen flex items-center justify-center bg-black/50 mt-8">
    <!-- Background Image -->
    <div class="absolute inset-0">
      <img src="{{ asset('images/donate.jpg') }}" alt="Donate Background"
        class="w-full h-full object-cover brightness-75" />
    </div>

    <!-- Overlay Content -->
    <div
      class="relative z-10 w-full max-w-2xl bg-white/80 backdrop-blur-md p-10 rounded-2xl shadow-xl border border-gray-200 space-y-6 mx-4">
      <div class="text-center">
        <h1 class="text-4xl font-bold text-orange-500">YOUR DONATIONS</h1>
        <h2 class="text-2xl font-semibold mt-1 text-gray-800">Make a Difference</h2>
      </div>

      <div>
        <h3 class="text-xl font-semibold text-gray-700">We Need:</h3>
        <ul class="mt-3 space-y-2 text-lg text-gray-700 font-medium">
          @foreach ([
          'Food (Dry, Wet, Canned)',
          'Treats',
          'Collars / Leashes',
          'Cat Litter',
          'Towels',
          'Toys'
          ] as $item)
          <li class="flex items-center gap-3">
            <i class="ph-fill ph-check-fat text-orange-500"></i> {{ $item }}
          </li>
          @endforeach
        </ul>
      </div>

      <div>
        <h3 class="text-xl font-semibold text-gray-700">Drop-Off Location:</h3>
        <p class="flex items-center mt-2 text-gray-600">
          <i class="ph-fill ph-map-pin mr-2 text-orange-500"></i>
          Angeles City Municipal Hall, Angeles City Veterinary Office
        </p>
        <p class="flex items-center mt-2 text-gray-600">
          <i class="ph-fill ph-map-pin mr-2 text-orange-500"></i>
          5J85+64M, City Hall Building, Aniceto Gueco St., Pulung Maragul, Angeles, 2009
        </p>
      </div>
    </div>
  </section>
  <!-- ========== END OF DONATION SECTION ========== -->
</x-layout>