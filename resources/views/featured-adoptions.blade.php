<x-layout>
  <!-- Hero -->
  <section id="mainContent" class="relative bg-gradient-to-b from-orange-50 to-white">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 py-16">
      <div class="text-center">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-medium">
          <i class="ph-fill ph-paw-print"></i>
          Celebrating Matches
        </span>
        <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Successful Adoptions</h1>
        <p class="max-w-2xl mx-auto mt-3 text-lg text-gray-600">
          Smiles, wagging tails, and purrs—these are the moments we live for.
        </p>
      </div>

      <!-- Filters and Result Count -->
      <div class="mt-10 flex flex-col items-center gap-4">
        @if ($featuredPets->count() > 0)
        <div class="w-full flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3">
          <div class="w-full sm:w-auto">
            <label for="monthFilter" class="sr-only">Month</label>
            <div class="relative">
              <select id="monthFilter"
                class="appearance-none block w-full pl-4 pr-10 py-2.5 text-base bg-white border border-gray-200 rounded-full shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <option value="all">All Months</option>
                @foreach($months as $month)
                <option value="{{ $month['value'] }}">{{ $month['name'] }}</option>
                @endforeach
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                <i class="ph ph-caret-down"></i>
              </div>
            </div>
          </div>

          <div class="w-full sm:w-auto">
            <label for="yearFilter" class="sr-only">Year</label>
            <div class="relative">
              <select id="yearFilter"
                class="appearance-none block w-full pl-4 pr-10 py-2.5 text-base bg-white border border-gray-200 rounded-full shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <option value="all">All Year</option>
                @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                <i class="ph ph-caret-down"></i>
              </div>
            </div>
          </div>
        </div>
        @endif

        <div class="text-sm text-gray-600" id="resultsMeta">
          <span id="resultCount"></span>
        </div>
      </div>

      <!-- Masonry Gallery -->
      <div class="mt-10">
        <div class="gallery-grid columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 [column-fill:_balance]">
          @php $__idx = 0; @endphp
          @foreach($featuredPets as $month => $images)
          @foreach($images as $image)
          <div class="mb-4 break-inside-avoid" style="break-inside: avoid;">
            <div
              class="gallery-item relative overflow-hidden rounded-xl shadow-sm group cursor-pointer transition-all duration-300 hover:shadow-lg"
              data-index="{{ $__idx }}"
              data-src="{{ asset('storage/' . $image->image_path) }}" data-month="{{ date('n', strtotime($month)) }}"
              data-year="{{ date('Y', strtotime($month)) }}">
              <img src="{{ asset('storage/' . $image->image_path) }}" alt="Featured adoption"
                class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white/90 text-gray-800 backdrop-blur">
                  {{ date('M Y', strtotime($month)) }}
                </span>
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-orange-500 text-white shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <i class="ph ph-magnifying-glass"></i>
                </span>
              </div>
            </div>
          </div>
          @php $__idx++; @endphp
          @endforeach
          @endforeach
        </div>
      </div>

      <!-- Empty state -->
      <div id="emptyState" class="hidden text-center py-16">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 text-orange-600">
          <i class="ph-fill ph-image"></i>
        </div>
        <h3 class="mt-4 text-xl font-semibold text-gray-900">No photos found</h3>
        <p class="mt-1 text-gray-600">Try adjusting your filters to see more adoptions.</p>
      </div>

      @if($totalImages > $initialLimit)
      <div id="loadMoreWrapper" class="mt-8 text-center">
        <button id="loadMoreBtn" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition disabled:opacity-60 disabled:cursor-not-allowed">
          <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
          </svg>
          <span class="btn-text">Load More</span>
        </button>
      </div>
      @endif
    </div>
  </section>

  <!-- Image Modal -->
  <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4">
    <button id="closeModal" class="absolute top-4 right-4 text-white hover:text-orange-400 text-4xl leading-none">&times;</button>
    <button id="prevImage" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
      <i class="ph ph-caret-left text-2xl"></i>
    </button>
    <button id="nextImage" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
      <i class="ph ph-caret-right text-2xl"></i>
    </button>
    <div class="relative max-w-6xl max-h-[90vh]">
      <img id="modalImage" class="max-w-full max-h-[80vh] object-contain" src="" alt="Enlarged adoption photo">
      <div id="modalCaption" class="mt-3 text-center text-sm text-white/80"></div>
    </div>
  </div>

  <!-- ========== CTA SECTION ========== -->
  <section class="py-16 md:py-24 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-6">
        Ready to Make a Difference?
      </h2>
      <p class="text-gray-300 max-w-2xl mx-auto mb-8">
        Whether you want to adopt, volunteer, or support our mission, we'd love to have you join
        the OrPAWnage family.
      </p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="/services/adopt-a-pet"
          class="px-6 py-3 bg-orange-500 hover:bg-yellow-400 hover:text-black rounded-md font-medium transition-colors duration-200 flex items-center justify-center">
          <i class="ph-fill ph-paw-print mr-2"></i> Adopt a Pet
        </a>
        <a href="/donate"
          class="px-6 py-3 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 rounded-md font-medium transition-colors duration-200 flex items-center justify-center">
          <i class="ph-fill ph-hand-heart mr-2"></i> Donate Now
        </a>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function updateHeaderSpacer() {
        const header = document.getElementById('main-header');
        const mainContent = document.getElementById('mainContent');
        if (header && mainContent) {
          const headerHeight = header.offsetHeight;
          mainContent.style.marginTop = `${headerHeight}px`;
          mainContent.style.paddingTop = `${headerHeight * .2}px`;
        }
      }

      // Initial update
      updateHeaderSpacer();
      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);

      // Modal functionality with navigation
      const modal = document.getElementById('imageModal');
      const modalImg = document.getElementById('modalImage');
      const modalCaption = document.getElementById('modalCaption');
      const closeModal = document.getElementById('closeModal');
      const prevBtn = document.getElementById('prevImage');
      const nextBtn = document.getElementById('nextImage');
      let galleryItems = [];
      let currentIndex = -1;

      function rebuildGalleryList() {
        galleryItems = Array.from(document.querySelectorAll('.gallery-item'));
        updateResultCount();
      }

      function openModalByIndex(idx) {
        if (idx < 0 || idx >= galleryItems.length) return;
        currentIndex = idx;
        const item = galleryItems[currentIndex];
        const src = item.getAttribute('data-src');
        const y = item.getAttribute('data-year');
        const m = item.getAttribute('data-month');
        modalImg.src = src;
        modalCaption.textContent = formatMonthYear(m, y);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
      }

      function closeModalFn() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        currentIndex = -1;
      }

      function showPrev() { if (galleryItems.length) openModalByIndex((currentIndex - 1 + galleryItems.length) % galleryItems.length); }
      function showNext() { if (galleryItems.length) openModalByIndex((currentIndex + 1) % galleryItems.length); }

      function attachModalListenersToNewItems() {
        document.querySelectorAll('.gallery-item').forEach((item, idx) => {
          if (!item.hasAttribute('data-modal-listener')) {
            item.setAttribute('data-modal-listener', 'true');
            item.addEventListener('click', function() {
              const index = galleryItems.indexOf(item);
              openModalByIndex(index >= 0 ? index : 0);
            });
          }
        });
      }

      function formatMonthYear(month, year) {
        if (!month || !year || month === 'all' || year === 'all') return '';
        const d = new Date(parseInt(year, 10), parseInt(month, 10) - 1, 1);
        return d.toLocaleDateString(undefined, { month: 'long', year: 'numeric' });
      }

      closeModal.addEventListener('click', closeModalFn);
      prevBtn.addEventListener('click', showPrev);
      nextBtn.addEventListener('click', showNext);
      modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModalFn();
      });
      document.addEventListener('keydown', function(e) {
        if (modal.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeModalFn();
        if (e.key === 'ArrowLeft') showPrev();
        if (e.key === 'ArrowRight') showNext();
      });

      // Filters, Load More, and counters
      const yearFilter = document.getElementById('yearFilter');
      const monthFilter = document.getElementById('monthFilter');
      const loadMoreBtn = document.getElementById('loadMoreBtn');
      const loadMoreWrapper = document.getElementById('loadMoreWrapper');
      const galleryContainer = document.querySelector('.gallery-grid');
      const emptyState = document.getElementById('emptyState');
      const resultCount = document.getElementById('resultCount');
      let currentPage = 0;
      const perPage = 12;
      let isLoading = false;

      function updateResultCount() {
        const count = document.querySelectorAll('.gallery-item').length;
        if (resultCount) {
          const y = yearFilter ? yearFilter.value : 'all';
          const m = monthFilter ? monthFilter.value : 'all';
          const label = (y === 'all' && m === 'all') ? 'All time' : `${formatMonthYear(m, y) || 'Selected'}`;
          resultCount.textContent = `${count} photo${count === 1 ? '' : 's'} · ${label}`;
        }
        if (emptyState) emptyState.classList.toggle('hidden', count !== 0);
      }

      async function fetchAndRenderGallery(reset = false) {
        if (isLoading) return;
        isLoading = true;
        const spinner = loadMoreBtn ? loadMoreBtn.querySelector('svg') : null;
        const btnText = loadMoreBtn ? loadMoreBtn.querySelector('.btn-text') : null;
        if (reset) {
          currentPage = 0;
          galleryContainer.innerHTML = '';
        }
        const year = yearFilter ? yearFilter.value : 'all';
        const month = monthFilter ? monthFilter.value : 'all';
        const url = `/featured-adoptions/load-more?page=${currentPage}&year=${year}&month=${month}`;
        try {
          if (loadMoreBtn) { loadMoreBtn.disabled = true; if (spinner) spinner.classList.remove('hidden'); if (btnText) btnText.textContent = 'Loading...'; }
          const response = await fetch(url);
          if (!response.ok) throw new Error('Network response was not ok');
          const html = await response.text();
          if (reset && html.trim() === '') {
            if (loadMoreWrapper) loadMoreWrapper.style.display = 'none';
            rebuildGalleryList();
            updateResultCount();
            isLoading = false;
            if (loadMoreBtn) { loadMoreBtn.disabled = false; if (spinner) spinner.classList.add('hidden'); if (btnText) btnText.textContent = 'Load More'; }
            return;
          }
          galleryContainer.insertAdjacentHTML('beforeend', html);
          attachModalListenersToNewItems();
          rebuildGalleryList();
          // If less than perPage items returned, hide Load More
          if (!html.trim() || (html.match(/gallery-item/g) || []).length < perPage) {
            if (loadMoreWrapper) loadMoreWrapper.style.display = 'none';
          } else {
            if (loadMoreWrapper) loadMoreWrapper.style.display = 'block';
          }
        } catch (error) {
          console.error('Error loading images:', error);
        }
        isLoading = false;
        if (loadMoreBtn) { loadMoreBtn.disabled = false; if (spinner) spinner.classList.add('hidden'); if (btnText) btnText.textContent = 'Load More'; }
      }

      function onFilterChange() {
        fetchAndRenderGallery(true);
      }
      if (monthFilter) monthFilter.addEventListener('change', onFilterChange);
      if (yearFilter) yearFilter.addEventListener('change', function() {
        const selectedYear = this.value;
        if (monthFilter) monthFilter.value = 'all';
        if (selectedYear === 'all') {
          if (monthFilter) Array.from(monthFilter.options).forEach(option => { option.disabled = false; });
        } else {
          const availableMonths = new Set();
          document.querySelectorAll(`.gallery-item[data-year="${selectedYear}"]`).forEach(item => {
            availableMonths.add(item.getAttribute('data-month'));
          });
          if (monthFilter) Array.from(monthFilter.options).forEach(option => {
            option.disabled = option.value !== 'all' && !availableMonths.has(option.value);
          });
        }
        fetchAndRenderGallery(true);
      });

      if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', async function() {
          currentPage++;
          await fetchAndRenderGallery(false);
        });
      }

      // Initialize modal listeners and counts for SSR-rendered items
      attachModalListenersToNewItems();
      rebuildGalleryList();

      // Initial fetch for filters (if not showing all)
      if (yearFilter && monthFilter && (yearFilter.value !== 'all' || monthFilter.value !== 'all')) {
        fetchAndRenderGallery(true);
      }
    });
  </script>
</x-layout>