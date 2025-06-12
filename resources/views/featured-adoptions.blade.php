<x-layout>
  <section class="relative custom-gradient flex items-center justify-center min-h-screen" id="mainContent">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">Successful Adoptions</h1>
        <p class="max-w-2xl mx-auto mt-4 text-lg text-gray-700">
          See our happy pets who found their forever homes
        </p>
      </div>

      <!-- Month/Year Dropdown Filter -->
      @if ($featuredPets->count() > 0)
      <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
        <div class="w-full sm:w-auto">
          <select id="monthFilter"
            class="block w-full pl-4 pr-8 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            <option value="all">All Months</option>
            @foreach($months as $month)
            <option value="{{ $month['value'] }}">{{ $month['name'] }}</option>
            @endforeach
          </select>
        </div>

        <div class="w-full sm:w-auto">
          <select id="yearFilter"
            class="block w-full pl-4 pr-8 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
          </select>
        </div>
      </div>
      @endif

      <!-- Gallery Grid -->
      <div class="mt-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 gallery-grid">
          @foreach($featuredPets as $month => $images)
          @foreach($images as $image)
          <div
            class="gallery-item overflow-hidden rounded-lg shadow-md group cursor-pointer transition-all duration-300 hover:shadow-lg"
            data-src="{{ asset('storage/' . $image->image_path) }}" data-month="{{ date('n', strtotime($month)) }}"
            data-year="{{ date('Y', strtotime($month)) }}">
            <div class="relative aspect-square">
              <img src="{{ asset('storage/' . $image->image_path) }}" alt="Featured adoption"
                class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105"
                loading="lazy">
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300">
              </div>
            </div>
          </div>
          @endforeach
          @endforeach
        </div>
      </div>
      @if($totalImages > $initialLimit)
      <div class="mt-8 text-center">
        <button id="loadMoreBtn"
          class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-md font-medium transition-colors duration-200">
          Load More
        </button>
      </div>
      @endif
    </div>
  </section>

  <!-- Image Modal -->
  <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90 p-4">
    <div class="relative max-w-6xl max-h-[90vh]">
      <button id="closeModal"
        class="absolute -top-12 right-0 text-white hover:text-orange-400 text-4xl">&times;</button>
      <img id="modalImage" class="max-w-full max-h-[80vh] object-contain" src="" alt="Enlarged adoption photo">
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
              mainContent.style.paddingTop = `${headerHeight * .3}px`;
              mainContent.style.paddingBottom = `${headerHeight * .5}px`;
          }
      }

      // Initial update
      updateHeaderSpacer();

      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);

      // Modal functionality
      const modal = document.getElementById('imageModal');
      const modalImg = document.getElementById('modalImage');
      const closeModal = document.getElementById('closeModal');
      
      document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', function() {
          const imgSrc = this.getAttribute('data-src');
          modalImg.src = imgSrc;
          modal.classList.remove('hidden');
          modal.classList.add('flex');
          document.body.style.overflow = 'hidden';
        });
      });

      closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
      });

      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
          document.body.style.overflow = 'auto';
        }
      });

      // Month/Year filter functionality
      const yearFilter = document.getElementById('yearFilter');
      const monthFilter = document.getElementById('monthFilter');
      
      function applyFilters() {
        const selectedYear = yearFilter.value;
        const selectedMonth = monthFilter.value;
        
        document.querySelectorAll('.gallery-item').forEach(item => {
          const itemYear = item.getAttribute('data-year');
          const itemMonth = item.getAttribute('data-month');
          
          const yearMatch = selectedYear === 'all' || itemYear === selectedYear;
          const monthMatch = selectedMonth === 'all' || itemMonth === selectedMonth;
          
          if (yearMatch && monthMatch) {
            item.classList.remove('hidden');
          } else {
            item.classList.add('hidden');
          }
        });
      }
      
      yearFilter.addEventListener('change', applyFilters);
      monthFilter.addEventListener('change', applyFilters);
      
      // When year changes, update available months
      yearFilter.addEventListener('change', function() {
        const selectedYear = this.value;
        
        // Reset month filter
        monthFilter.value = 'all';
        
        if (selectedYear === 'all') {
          // Enable all month options
          Array.from(monthFilter.options).forEach(option => {
            option.disabled = false;
          });
        } else {
          // Disable months that don't have data for selected year
          const availableMonths = new Set();
          document.querySelectorAll(`.gallery-item[data-year="${selectedYear}"]`).forEach(item => {
            availableMonths.add(item.getAttribute('data-month'));
          });
          
          Array.from(monthFilter.options).forEach(option => {
            option.disabled = option.value !== 'all' && !availableMonths.has(option.value);
          });
        }
        
        applyFilters();
      });

      // Load More functionality
      const loadMoreBtn = document.getElementById('loadMoreBtn');
      if (loadMoreBtn) {
          let currentPage = 0; // Start from 0 to match skip logic
          const perPage = 12;
          
          loadMoreBtn.addEventListener('click', async function() {
              currentPage++;
              loadMoreBtn.disabled = true;
              loadMoreBtn.textContent = 'Loading...';
              
              try {
                  const response = await fetch(`/featured-adoptions/load-more?page=${currentPage}`);
                  
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  
                  const html = await response.text();
                  
                  if (html.trim() === '') {
                      // No more content to load
                      loadMoreBtn.style.display = 'none';
                      return;
                  }
                  
                  // Create a temporary container to parse the HTML
                  const tempDiv = document.createElement('div');
                  tempDiv.innerHTML = html;
                  
                  // Get the main container where new content should be appended
                  const galleryContainer = document.querySelector('.gallery-grid');
                  
                  // Append the new content
                  galleryContainer.insertAdjacentHTML('beforeend', html);
                  
                  // Reattach event listeners to new items for modal
                  attachModalListenersToNewItems();
                  
                  // Check if we've loaded all items
                  const loadedItems = document.querySelectorAll('.gallery-item').length;
                  if (loadedItems >= {{ $totalImages }}) {
                      loadMoreBtn.style.display = 'none';
                  } else {
                      loadMoreBtn.disabled = false;
                      loadMoreBtn.textContent = 'Load More';
                  }
                  
              } catch (error) {
                  console.error('Error loading more images:', error);
                  loadMoreBtn.disabled = false;
                  loadMoreBtn.textContent = 'Load More';
                  // Optional: Show error message to user
              }
          });
      }
        
        function attachModalListenersToNewItems() {
            document.querySelectorAll('.gallery-item').forEach(item => {
                if (!item.hasAttribute('data-modal-listener')) {
                    item.setAttribute('data-modal-listener', 'true');
                    item.addEventListener('click', function() {
                        const imgSrc = this.getAttribute('data-src');
                        modalImg.src = imgSrc;
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    });
                }
            });
        }
    });
  </script>
</x-layout>