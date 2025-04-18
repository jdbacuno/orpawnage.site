<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="bg-gray-60 mt-10 py-10 sm:py-20">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8 lg:flex lg:items-center lg:gap-x-6">
      <!-- LEFT SIDE CONTENT -->
      <div class="lg:w-1/2 sm:mb-10 mb-0 text-left sm:text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">
          Lorem ipsum dolor
          <span class="text-orange-500">Or<span class="text-yellow-500">PAW</span>nage</span>
        </h1>
        <p class="mt-4 text-gray-600">
          Browse through hundreds of pets looking for a new home. Give them
          a second chance at life.
        </p>

        <!-- SEARCH BAR -->
        <div class="mt-6">
          <form class=" mx-auto" id="applicationForm">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
              </div>
              <input type="search" id="default-search"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-orange-500 focus:border-orange-500"
                placeholder="Search by species, color, etc..." required />
              <button type="submit"
                class="text-white absolute end-2.5 bottom-2.5 bg-orange-500 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-400/60 font-medium rounded-full text-sm px-4 py-2">
                Search
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- RIGHT SIDE IMAGE -->
      <div class="lg:w-1/2">
        <img src="{{ asset('images/catdogBG.jpg') }}" alt="Pet Adoption Hero Image"
          class="hidden sm:block w-full sm:max-w-[500px] mx-auto rounded-xl shadow-lg" />
      </div>
    </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="bg-yellow-400/30 py-8 sm:py-12">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Header Section -->
      <div class="text-black flex flex-col items-center mb-6 gap-10" id="pets">
        <h2 class="text-3xl sm:text-4xl font-extrabold mr-auto text-black">
          Available Pets for Adoption
        </h2>
        <!-- Filters Section -->
        <div class="flex flex-wrap gap-4 items-center mr-auto">
          <form id="filterForm" class="flex flex-wrap gap-4">
            <!-- Species Filter -->
            <select name="species"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[120px]">
              <option value="">All Species</option>
              <option value="feline">Cats</option>
              <option value="canine">Dogs</option>
            </select>

            <!-- Gender Filter -->
            <select name="sex"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[120px]">
              <option value="">All Genders</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>

            <!-- Reproductive Status Filter -->
            <select name="reproductive_status"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[200px]">
              <option value="">All Reproductive Statuses</option>
              <option value="intact">Intact</option>
              <option value="neutered">Neutered</option>
              <option value="unknown">Unknown</option>
            </select>

            <!-- Color Filter -->
            <select name="color"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[100px]">
              <option value="">All Colors</option>
              <option value="black">Black</option>
              <option value="white">White</option>
              <option value="gray">Gray</option>
              <option value="brown">Brown</option>
              <option value="brindle">Brindle</option>
              <option value="orange">Orange</option>
              <option value="calico">Calico</option>
              <option value="tabby">Tabby</option>
              <option value="bi-color">Bi-Color</option>
              <option value="tri-color">Tri-Color</option>
              <option value="others">Others</option>
            </select>

            <!-- Source Filter -->
            <select name="source"
              class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]">
              <option value="">All Sources</option>
              <option value="surrendered">Surrendered</option>
              <option value="rescued">Rescued</option>
              <option value="other">Other</option>
            </select>

            <!-- Combined Sort Dropdown -->
            <div>
              <select name="sort_by"
                class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]">
                <option value="">Sort By</option>
                <option value="latest">Newest Arrivals</option>
                <option value="oldest">Oldest Arrivals</option>
                <option value="youngest">Youngest First</option>
                <option value="oldest_age">Oldest First</option>
              </select>
            </div>

            <!-- Reset Filters Button -->
            <button type="button" id="resetFilters"
              class="bg-gray-200 hover:bg-gray-300 border border-black text-center text-gray-800 px-4 py-2.5 rounded-lg text-sm min-w-[150px]">
              Reset Filters
            </button>
          </form>
        </div>
      </div>

      <!-- Pet Cards Grid Container -->
      <div id="petsContainer">
        <!-- Pets will be loaded here via AJAX -->
      </div>

      <!-- Pagination Container -->
      <div id="paginationContainer" class="mt-8"></div>
    </div>
  </section>
  <!-- ========== END OF PET LISTING SECTION ========== -->

  <!-- Add jQuery (you can also use vanilla JS if preferred) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      // Function to load pets via AJAX
      function loadPets(page = 1) {
        const formData = $('#filterForm').serialize() + '&page=' + page;
        
        $.ajax({
          url: '/services/adopt-a-pet', // You'll need to create this route
          type: 'GET',
          data: formData,
          success: function(response) {
            $('#petsContainer').html(response.html);
            $('#paginationContainer').html(response.pagination);
            
            // Update URL without reloading
            const queryString = $('#filterForm').serialize();
            const newUrl = window.location.pathname + (queryString ? '?' + queryString : '') + '#pets';
            window.history.pushState({ path: newUrl }, '', newUrl);
          },
          error: function(xhr) {
            console.error('Error:', xhr.responseText);
            $('#petsContainer').html('<div class="text-center text-black mt-10"><p class="text-lg font-semibold">Error loading pets. Please try again.</p></div>');
          }
        });
      }
      
      // Initial load
      loadPets();
      
      // Filter form change event
      $('#filterForm select').on('change', function() {
        loadPets();
      });
      
      // Reset filters
      $('#resetFilters').on('click', function() {
        $('#filterForm')[0].reset();
        loadPets();
      });
      
      // Handle pagination clicks
      $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        loadPets(page);
      });
      
      // Search form submission
      $('#applicationForm').on('submit', function(e) {
        e.preventDefault();
        const searchTerm = $('#default-search').val();
        // You can add search functionality here if needed
        // For now, just reload with search term
        loadPets();
      });

      // Check for updates every 10 seconds
      setInterval(function() {
          loadPets($('.pagination .active').text() || 1);
        }, 10000); // 10 seconds
      });
  </script>
</x-layout>