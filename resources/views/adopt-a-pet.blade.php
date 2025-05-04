<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="bg-gray-60 mt-10 py-10 sm:py-20">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8 lg:flex lg:items-start lg:gap-x-6">
      <!-- LEFT SIDE CONTENT -->
      <div class="lg:w-1/2 sm:mb-10 mb-0 text-left">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">
          <i class="ph-fill ph-paw-print text-yellow-500"></i> Browse pets
          at <span class="text-orange-500">Or<span class="text-yellow-500">PAW</span>nage</span>
          Adopt. Don't shop.
        </h1>
        <p class="mt-4 text-gray-600">
          Browse through these pets looking for a new home. Give them
          a second chance at life.
        </p>

        <!-- Adoption Process -->
        <div class="my-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
          <h3 class="font-bold text-lg text-black mb-4" id="processTitle"><i
              class="ph-fill ph-paw-print text-orange-500"></i> Adoption Process</h3>

          <!-- Tab Navigation -->
          <div class="flex space-x-2 mb-4" id="language-tabs">
            <button data-tab="english"
              class="tab-btn bg-white px-3 py-1 rounded border border-orange-300 text-black font-medium hover:bg-orange-300 active">English</button>
            <button data-tab="tagalog"
              class="tab-btn bg-white px-3 py-1 rounded border border-orange-300 text-black font-medium hover:bg-orange-300">Taglish</button>
            <button data-tab="kapampangan"
              class="tab-btn bg-white px-3 py-1 rounded border border-orange-300 text-black font-medium hover:bg-orange-300">Kapampangan</button>
          </div>

          <!-- Tab Contents Container with Fixed Height and Scroll -->
          <div class="h-96 overflow-y-auto scrollbar-hidden">
            <!-- English content -->
            <div id="tab-content-english" class="tab-content">
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Complete this form</span> with accurate personal information and adoption
                  details.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  After submission, you'll receive a <span class="font-medium">confirmation email that you need to
                    confirm within 24 hours</span>.
                  <span class="text-red-600 font-medium">Failure to confirm within this period will automatically cancel
                    your application.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Once confirmed, you'll receive another email with the estimated preparation time for your pet. Please
                  wait for the
                  <span class="font-medium">scheduling email</span> to proceed.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  When you receive the scheduling email, you must <span class="font-medium">set a pickup date within 48
                    hours</span>.
                  <span class="text-red-600 font-medium">No response within this timeframe will cancel your
                    application.</span>
                  Available dates will be within 7 business days from the scheduling email date.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  On your scheduled date, bring:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>A valid government-issued ID</li>
                    <li>Your transaction confirmation email</li>
                  </ul>
                  <span class="text-red-600 font-medium">Failure to pick up within 3 business days after your scheduled
                    date will cancel the adoption.</span>
                </li>
                <li>
                  At pickup, we'll take <span class="font-medium">an official photo</span> of you with your new pet
                  holding an adoption
                  information board. This may be shared on the City Information Office's official channels.
                </li>
              </ol>
            </div>

            <!-- Tagalog content -->
            <div id="tab-content-tagalog" class="tab-content hidden">
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Kumpletuhin ang form na ito</span> ng may tamang personal na impormasyon at
                  detalye ng pag-aadopt.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Pagkatapos i-submit, makakatanggap ka ng <span class="font-medium">confirmation email na kailangan
                    mong i-confirm sa loob ng 24 oras</span>.
                  <span class="text-red-600 font-medium">Ang hindi pag-confirm sa loob ng panahong ito ay awtomatikong
                    magkakansela ng iyong aplikasyon.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Kapag na-confirm na, makakatanggap ka ng isa pang email na naglalaman ng estimated time kung gaano
                  katagal i-prepare ang iyong ina-adopt na pet. Hintayin ang
                  <span class="font-medium">email para sa schedule</span> bago magpatuloy.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Kapag natanggap mo na ang email para sa schedule, kailangan mong <span class="font-medium">mag-set ng
                    pickup date sa loob ng 48 oras</span>.
                  <span class="text-red-600 font-medium">Ang hindi pagtugon sa loob ng panahong ito ay awtomatikong
                    magkakansela ng iyong aplikasyon.</span> Ang mga available na petsa ay sa loob ng 7 working days ng
                  aming opisina mula sa petsa ng email.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Sa iyong nakatakdang petsa, dalhin ang:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>Valid na government ID</li>
                    <li>Ang iyong transaction confirmation email</li>
                  </ul>
                  <span class="text-red-600 font-medium">Ang hindi pag-pick up sa loob ng 3 working days ng aming
                    opisina pagkatapos ng nakatakdang pickup date ay awtomatikong magkakansela ng iyong
                    application.</span>
                </li>
                <li>
                  Sa oras ng pickup, kukunan ka ng <span class="font-medium">opisyal na larawan</span> kasama ang iyong
                  bagong alaga na may hawak na adoption information board. I-popost po namin ito sa opisyal na channels
                  ng City Information Office.
                </li>
              </ol>
            </div>

            <!-- Kapampangan content -->
            <div id="tab-content-kapampangan" class="tab-content hidden">
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Kumpletuan me ining form</span> gamit ing kekang personal a impormasyun ampo
                  ing detalye ning kekang pamag-adopt.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Kaybat meng i-submit, <span class="font-medium">makatanggap kang email ning kumpirmasyun a kailangan
                    mung i-confirm kilub ning 24 oras</span>.
                  <span class="text-red-600 font-medium">Nung e ka makakumpirma keng kilub ning panaun ayni, automatic
                    yang makansela ing kekang aplikasyun.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Nung mekumpirma ne, <span class="font-medium">makatanggap kang aliwang email</span> a ating makalageng
                  estimated time kung angga kang kapilan ka manaya king preparation mi para keng ayampunan mung animal.
                  <span class="font-medium">Paki-panayan mu ing email ning pamag-schedule.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Potang atanggap mu ne ing email ning pamag-schedule, <span class="font-medium">kailangan meng i-set
                    ing pickup date kilub ning 48 oras</span>.
                  <span class="text-red-600 font-medium">Alang pakibat keng kilub ning panaun ayni, automatiku yang
                    makansela ing kekang aplikasyun.</span>
                  Deng available a petsa atyu la kilub ning 7 aldo a atyu kami keng office mi (e kayabe ing Sabado
                  ampong Domingo) manibat keng petsa ning email.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Keng kekang makatakda a petsa, magdala kang:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>Metung a valid a ID a pepalwal ning gubyernu</li>
                    <li>Ing kekang email ning kumpirmasyun keng transaksyon</li>
                  </ul>
                  <span class="text-red-600 font-medium">Nung e ka makapick up kilub ning atlung aldo a atyu kami king
                    office mi (e kayabe ing Sabado ampong Domingo) kaybat ning kekang schedule date, automatikung yang
                    makansela ing kekang aplikasyun.</span>
                </li>
                <li>
                  Keng pickup, <span class="font-medium">kuanan mi ing opisyal a litrato mu</span> kayabe ing bayung
                  animal mung tatalan ampo ing detalye yu a makasulat keng adoption information board. I-post mi ya ini
                  kareng opisyal a channels ning City Information Office.
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE IMAGE -->
      <div class="lg:w-1/2">
        <img src="{{ asset('images/home_image-3.jpg') }}" alt="Pet Adoption Hero Image"
          class="hidden sm:block w-full sm:max-w-[500px] mx-auto rounded-xl shadow-lg" />
      </div>
    </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF PET LISTING SECTION ========== -->
  <section class="bg-yellow-400/30 py-8 sm:py-12">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Header Section -->
      <div class="text-black flex flex-col items-center mb-6 gap-6" id="pets">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4 sm:gap-8">
          {{-- TITLE --}}
          <h2 class="text-3xl sm:text-4xl font-extrabold text-black sm:mr-auto">
            Available Pets for Adoption
          </h2>

          <!-- SEARCH BAR -->
          <div class="w-full sm:w-[350px]">
            <form class="w-full" id="applicationForm">
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

        <!-- Filters Section -->
        <div class="flex flex-wrap gap-4 items-center w-full">
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

  <script>
    // ADOPTION PROCESS TABS
    document.addEventListener('DOMContentLoaded', function () {
      const tabButtons = document.querySelectorAll(".tab-btn");
      const tabContents = document.querySelectorAll(".tab-content");
      const processTitle = document.querySelector('#processTitle');

      tabButtons.forEach(button => {
        button.addEventListener("click", () => {
          const tab = button.getAttribute("data-tab");

          if (tab === 'english') {
            processTitle.textContent = 'Adoption Process';
          } else if (tab === 'tagalog') {
            processTitle.textContent = 'Proseso sa Pag-aadopt';
          } else if (tab === 'kapampangan') {
            processTitle.textContent = 'Prosesu king Pamag-adopt';
          }

          // Remove active class from all buttons
          tabButtons.forEach(btn => btn.classList.remove("active", "bg-orange-100"));
          button.classList.add("active", "bg-orange-100");

          // Show correct tab
          tabContents.forEach(content => {
            content.classList.add("hidden");
          });
          document.getElementById(`tab-content-${tab}`).classList.remove("hidden");
        });
      });
    });
  </script>
</x-layout>