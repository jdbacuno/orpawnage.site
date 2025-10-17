<x-layout>
  <!-- Hero -->
  <section id="mainContent" class="relative min-h-screen bg-gradient-to-b from-orange-50 to-white">

    <!-- Desktop/Large screens: warm gradient + subtle pattern background -->
    <div class="hidden sm:block absolute inset-0 z-0">
      <div
        class="absolute inset-0 bg-gradient-to-br from-amber-50 via-orange-50 to-rose-100 animate-[gradientShift_14s_ease-in-out_infinite]">
      </div>
      <div class="absolute inset-0 opacity-40"
        style="background-image: radial-gradient(rgba(251, 191, 36, 0.25) 1px, transparent 1px); background-size: 22px 22px;">
      </div>
      <!-- Paw accents sprinkled like background (non-interactive) -->
      <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-30 text-7xl -top-10 left-8"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-6xl top-6 left-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-5xl top-10 right-1/3"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-8xl top-1/3 -left-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-7xl top-1/2 left-1/5"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-20 text-6xl top-2/3 left-1/2"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-7xl bottom-10 right-16"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-20 text-5xl bottom-24 right-1/4"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-6xl bottom-8 left-1/3"></i>
        <!-- Extra right-side sprinkles -->
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-6xl top-4 right-6"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-20 text-5xl top-1/4 right-10"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-25 text-7xl top-1/3 right-1/6"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-20 text-6xl top-1/2 right-3"></i>
        <i class="ph-fill ph-paw-print absolute text-orange-400 opacity-25 text-7xl bottom-1/3 right-8"></i>
        <i class="ph-fill ph-paw-print absolute text-rose-400 opacity-20 text-5xl bottom-1/5 right-1/12"></i>
        <i class="ph-fill ph-paw-print absolute text-yellow-400 opacity-25 text-6xl bottom-6 right-4"></i>
      </div>
    </div>

    <div class="relative z-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 py-8">
      <div class="text-center">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-medium">
          <i class="ph-fill ph-magnifying-glass"></i>
          Help Us Find Them
        </span>
        <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Missing Pets</h1>
        <p class="max-w-2xl mx-auto mt-3 text-lg text-gray-600">
          These pets are missing and their owners need our help. If you spot any of them, please reach out to the owner
          immediately.
        </p>
      </div>

      <!-- Filters and Result Count -->
      <div class="mt-10 flex flex-col items-center gap-4">
        @if ($recentPosts->count() > 0)
        <div class="w-full flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3">
          <div class="w-full sm:w-80">
            <label for="searchFilter" class="sr-only">Search</label>
            <div class="relative">
              <input type="text" id="searchFilter"
                class="appearance-none block w-full pl-4 pr-10 py-2.5 text-base bg-white border border-gray-200 rounded-full shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                placeholder="Search by pet name or location..." />
              <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                <i class="ph ph-magnifying-glass"></i>
              </div>
            </div>
          </div>
        </div>
        @endif

        <div class="text-sm text-gray-600" id="resultsMeta">
          <span id="resultCount"></span>
        </div>
      </div>

      <!-- Grid Gallery -->
      <div class="mt-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($recentPosts as $post)
          <div
            class="missing-card relative bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-all duration-200 border border-gray-100"
            data-pet-name="{{ strtolower($post->pet_name) }}"
            data-location="{{ strtolower($post->last_seen_location) }}" data-contact="{{ $post->contact_no }}"
            data-owner="{{ $post->owner_name }}" data-photos="{{ $post->pet_photos }}"
            data-location-photos="{{ $post->location_photos }}" data-description="{{ $post->pet_description }}"
            data-posted="{{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}"
            data-updated="{{ \Carbon\Carbon::parse($post->last_reposted_at ?? $post->created_at)->format('M d, Y') }}">

            <!-- Image Container -->
            <div class="relative overflow-hidden h-80 cursor-pointer"
              onclick="openCardModal(this.closest('.missing-card'))">
              @php
              $petPhotos = json_decode($post->pet_photos);
              $firstPhoto = $petPhotos[0] ?? null;
              @endphp
              @if($firstPhoto)
              <img src="{{ asset('storage/' . $firstPhoto) }}" alt="{{ $post->pet_name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
              @else
              <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                <i class="ph-fill ph-image text-gray-400 text-4xl"></i>
              </div>
              @endif

              <!-- Overlay -->
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              </div>

              <!-- Missing Badge -->
              <div class="absolute top-3 left-3">
                <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                  <i class="ph-fill ph-warning"></i> MISSING
                </span>
              </div>

              <!-- Time Posted -->
              <div class="absolute top-3 right-3">
                <span class="bg-black/60 text-white text-xs px-2 py-1 rounded flex items-center gap-1">
                  <i class="ph-fill ph-clock"></i>
                  {{ \Carbon\Carbon::parse($post->last_reposted_at ?? $post->created_at)->diffForHumans() }}
                </span>
              </div>

              <!-- View Details Icon -->
              <div class="absolute bottom-3 right-3">
                <span
                  class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-500 text-white shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <i class="ph ph-arrow-up-right"></i>
                </span>
              </div>

              <!-- Pet Name and Location Overlay -->
              <div
                class="absolute bottom-0 left-0 right-0 p-4 text-white bg-black/40 transform translate-y-0 group-hover:translate-y-0 transition-transform duration-300">
                <h3 class="text-xl font-bold mb-1">{{ ucwords($post->pet_name) }}</h3>
                <p class="text-sm opacity-90 flex items-center gap-1">
                  <i class="ph-fill ph-map-pin"></i>
                  {{ $post->last_seen_location }}
                </p>
                <p class="text-xs opacity-80 mt-1">
                  Last seen: {{ \Carbon\Carbon::parse($post->last_seen_date)->format('M d, Y') }}
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Empty State -->
      <div id="emptyState" class="hidden text-center py-16">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 text-orange-600 mb-4">
          <i class="ph-fill ph-paw-print text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Missing Pets Found</h3>
        <p class="text-gray-600 mb-6">Hopefully all missing pets have been found and reunited with their families!</p>
        <a href="/report/missing-pet"
          class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-yellow-400 text-white hover:text-black rounded-lg font-medium transition duration-300">
          <i class="ph-fill ph-plus-circle"></i> Report a Missing Pet
        </a>
      </div>

      <!-- Pagination -->
      @if($recentPosts->hasPages())
      <div class="mt-10 flex justify-center">
        {{ $recentPosts->links() }}
      </div>
      @endif
    </div>
  </section>

  <!-- Card Detail Modal -->
  <div id="cardModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4">
    <button id="closeModal"
      class="absolute top-4 right-4 text-white hover:text-orange-400 text-4xl leading-none">&times;</button>

    <div
      class="relative max-w-2xl w-full bg-white rounded-lg shadow-xl overflow-hidden max-h-[90vh] overflow-y-auto scrollbar-hidden">
      <!-- Image Section -->
      <div class="relative h-80 overflow-hidden bg-gray-200">
        <img id="modalImage" src="" alt="Pet image" class="w-full h-full object-cover" />

        <!-- Badge -->
        <div class="absolute top-3 left-3">
          <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
            <i class="ph-fill ph-warning"></i> MISSING
          </span>
        </div>
      </div>

      <!-- Content Section -->
      <div class="p-6">
        <!-- Pet Name and Basic Info -->
        <div class="mb-4">
          <h2 id="modalPetName" class="text-3xl font-bold text-gray-900 mb-2"></h2>
          <p id="modalLastSeen" class="text-sm text-gray-600 flex items-start gap-2">
            <i class="ph-fill ph-map-pin text-red-500 flex-shrink-0 mt-0.5"></i>
            <span></span>
          </p>
          <p id="modalDate" class="text-xs text-gray-500 mt-1"></p>
        </div>

        <!-- Description -->
        <div class="mb-6">
          <h3 class="font-semibold text-gray-800 mb-2">Message/Description</h3>
          <p id="modalDescription" class="text-sm text-gray-700 leading-relaxed"></p>
        </div>

        <!-- Photo Gallery -->
        <div id="photoGallery" class="mb-6 hidden">
          <h3 class="font-semibold text-gray-800 mb-3">Pet Photos</h3>
          <div class="grid grid-cols-3 gap-2" id="photoGrid"></div>
        </div>

        <!-- Contact Section -->
        <div class="bg-orange-50 p-4 rounded-lg border border-orange-100 mb-4">
          <h3 class="font-semibold text-orange-900 mb-2 flex items-center">
            <i class="ph-fill ph-phone text-orange-600 mr-2"></i>Contact Owner
          </h3>
          <p id="modalOwner" class="text-sm text-gray-800 font-medium mb-2"></p>

          <!-- Phone number display - visible if logged in -->
          <div id="phoneDisplay" class="hidden">
            <p class="text-sm text-gray-800 font-mono bg-white px-3 py-2 rounded border border-orange-200 mb-3">
              <span id="modalPhoneDisplay"></span>
            </p>
            <a id="modalPhoneBtn" href=""
              class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500 hover:bg-yellow-400 text-white hover:text-black text-sm font-medium rounded-lg transition duration-300">
              <i class="ph-fill ph-phone"></i> Call Now
            </a>
          </div>

          <!-- Login prompt - visible if not logged in -->
          <div id="loginPrompt" class="hidden">
            <p class="text-sm text-gray-700 mb-3">Log in to view the contact number</p>
            <a href="{{ route('login') }}"
              class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-300">
              <i class="ph-fill ph-sign-in"></i> Log In to View Number
            </a>
          </div>
        </div>

        <!-- Additional Info -->
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="font-semibold text-gray-800 mb-3">Report Information</h3>
          <div class="text-sm text-gray-600 space-y-2">
            <p><span class="font-medium text-gray-800">Posted:</span> <span id="modalPosted"></span></p>
            <p><span class="font-medium text-gray-800">Last Updated:</span> <span id="modalUpdated"></span></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};

    document.addEventListener('DOMContentLoaded', function () {
      // Header spacer
      const header = document.getElementById('main-header');
      const mainContent = document.getElementById('mainContent');
      const adminIndicator = document.getElementById('adminIndicator');

      const EXTRA_TOP_SPACING_PX = 8;

      function computeHeights() {
        const headerHeight = header ? header.offsetHeight : 0;
        const adminHeight = adminIndicator ? adminIndicator.offsetHeight : 0;
        return { headerHeight, adminHeight };
      }

      function updateHeaderSpacer() {
        if (!mainContent) return;
        const { headerHeight, adminHeight } = computeHeights();
        const totalTop = (headerHeight || 0) + (adminHeight || 0);

        mainContent.style.marginTop = '0px';
        mainContent.style.paddingTop = `${(totalTop + EXTRA_TOP_SPACING_PX) * .8}px`;
        mainContent.style.paddingBottom = `${(totalTop + EXTRA_TOP_SPACING_PX * .8)}px`;
      }

      updateHeaderSpacer();
      window.addEventListener('resize', updateHeaderSpacer);

      if (window.ResizeObserver) {
        const ro = new ResizeObserver(updateHeaderSpacer);
        if (header) ro.observe(header);
        if (adminIndicator) ro.observe(adminIndicator);
      }

      // Search/Filter functionality
      const searchFilter = document.getElementById('searchFilter');
      const missingCards = document.querySelectorAll('.missing-card');
      const resultCount = document.getElementById('resultCount');
      const emptyState = document.getElementById('emptyState');

      function updateResultCount() {
        const visibleCards = Array.from(missingCards).filter(card =>
          !card.classList.contains('hidden')
        ).length;

        if (resultCount) {
          resultCount.textContent = `${visibleCards} missing pet${visibleCards !== 1 ? 's' : ''} found`;
        }

        if (emptyState) {
          emptyState.classList.toggle('hidden', visibleCards > 0);
        }
      }

      if (searchFilter) {
        searchFilter.addEventListener('input', function() {
          const searchTerm = this.value.toLowerCase();

          missingCards.forEach(card => {
            const petName = card.getAttribute('data-pet-name');
            const location = card.getAttribute('data-location');

            const matches = petName.includes(searchTerm) || location.includes(searchTerm);
            card.classList.toggle('hidden', !matches);
          });

          updateResultCount();
        });
      }

      updateResultCount();

      // Modal functionality
      const modal = document.getElementById('cardModal');
      const closeModal = document.getElementById('closeModal');

      closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      });

      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });
    });

    function openCardModal(card) {
      const modal = document.getElementById('cardModal');
      const petName = card.querySelector('h3').textContent;
      const location = card.getAttribute('data-location');
      const contact = card.getAttribute('data-contact');
      const owner = card.getAttribute('data-owner');
      const description = card.getAttribute('data-description');
      const posted = card.getAttribute('data-posted');
      const updated = card.getAttribute('data-updated');
      const image = card.querySelector('img').src;

      document.getElementById('modalImage').src = image;
      document.getElementById('modalPetName').textContent = petName;
      document.getElementById('modalLastSeen').querySelector('span').textContent = location;

      const lastSeenText = card.querySelector('.text-xs').textContent.replace('Last seen: ', '');
      document.getElementById('modalDate').textContent = `Last seen: ${lastSeenText}`;

      document.getElementById('modalDescription').textContent = description;
      document.getElementById('modalOwner').textContent = owner;
      document.getElementById('modalPosted').textContent = posted;
      document.getElementById('modalUpdated').textContent = updated;

      // Handle phone display based on auth
      const phoneDisplay = document.getElementById('phoneDisplay');
      const loginPrompt = document.getElementById('loginPrompt');
      const modalPhoneDisplay = document.getElementById('modalPhoneDisplay');
      const modalPhoneBtn = document.getElementById('modalPhoneBtn');

      if (isAuthenticated) {
        phoneDisplay.classList.remove('hidden');
        loginPrompt.classList.add('hidden');
        modalPhoneDisplay.textContent = contact;
        modalPhoneBtn.href = `tel:${contact}`;
      } else {
        phoneDisplay.classList.add('hidden');
        loginPrompt.classList.remove('hidden');
      }

      // Handle photos
      const photoGrid = document.getElementById('photoGrid');
      const photoGallery = document.getElementById('photoGallery');

      try {
        const photos = JSON.parse(card.getAttribute('data-photos') || '[]');
        if (photos.length > 0) {
          photoGrid.innerHTML = '';
          photos.forEach(photo => {
            const img = document.createElement('img');
            img.src = "{{ asset('storage/') }}/" + photo;
            img.className = 'w-full h-24 object-cover rounded-lg border border-gray-200 cursor-pointer hover:border-orange-400 transition';
            img.addEventListener('click', () => {
              document.getElementById('modalImage').src = img.src;
            });
            photoGrid.appendChild(img);
          });
          photoGallery.classList.remove('hidden');
        } else {
          photoGallery.classList.add('hidden');
        }
      } catch (e) {
        photoGallery.classList.add('hidden');
      }

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  </script>
</x-layout>
