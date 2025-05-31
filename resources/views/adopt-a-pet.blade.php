<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative custom-gradient sm:bg-none diagonal" id="mainContent">

    <!-- Mobile background image -->
    <div class="sm:hidden absolute inset-0 w-full h-full overflow-hidden z-0">
      <img src="{{ asset('images/home_image-3.jpg') }}" alt="Adopt a Pet"
        class="w-full h-full object-cover brightness-50" />
    </div>

    <div class="relative z-10 max-w-screen-xl mx-auto px-4 md:px-8 lg:flex lg:items-start lg:gap-x-6">
      <!-- LEFT SIDE CONTENT -->
      <div class="lg:w-1/2 sm:mb-10 mb-0 text-left">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white sm:text-gray-900 leading-tight">
          <i class="ph-fill ph-paw-print text-yellow-500"></i> Browse pets
          at <span class="text-orange-400">Or<span class="text-yellow-500">PAW</span>nage</span>
          Adopt. Don't shop.
        </h1>
        <p class="mt-4 text-white sm:text-gray-600">
          Browse through these pets looking for a new home. Give them
          a second chance at life.
        </p>

        <!-- Adoption Process -->
        <div class="my-6 p-6 bg-gray-50/80 backdrop-blur-lg rounded-lg border border-yellow-500 text-justify">
          <h3 class="font-bold text-lg text-black mb-4" id="processTitle"><i
              class="ph-fill ph-paw-print text-orange-500"></i> Adoption Process</h3>

          <!-- Tab Navigation -->
          <div class="flex space-x-2 mb-4 overflow-x-auto scrollbar-hidden" id="language-tabs">
            <button data-tab="english"
              class="tab-btn bg-white px-3 py-1 rounded border border-yellow-400 text-black font-medium hover:bg-yellow-300 active">English</button>
            <button data-tab="tagalog"
              class="tab-btn bg-white px-3 py-1 rounded border border-yellow-400 text-black font-medium hover:bg-yellow-300">Taglish</button>
            <button data-tab="kapampangan"
              class="tab-btn bg-white px-3 py-1 rounded border border-yellow-400 text-black font-medium hover:bg-yellow-300">Kapampangan</button>
          </div>

          <!-- Tab Contents Container with Fixed Height and Scroll -->
          <div class="h-96 overflow-y-auto scrollbar-hidden">
            <!-- English content -->
            <div id="tab-content-english" class="tab-content">
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700 leading-7">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Complete this form</span> with accurate personal information and adoption
                  details.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  After submission, you'll receive a <span class="font-medium">confirmation email that you need to
                    confirm within 24 hours</span>.
                  <span class="text-red-400 font-medium">Failure to confirm within this period will automatically cancel
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
                  <span class="text-red-400 font-medium">No response within this timeframe will cancel your
                    application.</span>
                  Available dates will be within 7 business days from the scheduling email date.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  On your scheduled date, bring:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>A valid government-issued ID</li>
                    <li>Your transaction confirmation email</li>
                  </ul>
                  <span class="text-red-400 font-medium">Failure to pick up within 3 business days after your scheduled
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
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700 leading-7">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Kumpletuhin ang form na ito</span> ng may tamang personal na impormasyon at
                  detalye ng pag-aadopt.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Pagkatapos i-submit, makakatanggap ka ng <span class="font-medium">confirmation email na kailangan
                    mong i-confirm sa loob ng 24 oras</span>.
                  <span class="text-red-400 font-medium">Ang hindi pag-confirm sa loob ng panahong ito ay awtomatikong
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
                  <span class="text-red-400 font-medium">Ang hindi pagtugon sa loob ng panahong ito ay awtomatikong
                    magkakansela ng iyong aplikasyon.</span> Ang mga available na petsa ay sa loob ng 7 working days ng
                  aming opisina mula sa petsa ng email.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Sa iyong nakatakdang petsa, dalhin ang:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>Valid na government ID</li>
                    <li>Ang iyong transaction confirmation email</li>
                  </ul>
                  <span class="text-red-400 font-medium">Ang hindi pag-pick up sa loob ng 3 working days ng aming
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
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700 leading-7">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Kumpletuan me ining form</span> gamit ing kekang personal a impormasyun ampo
                  ing detalye ning kekang pamag-adopt.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Kaybat meng i-submit, <span class="font-medium">makatanggap kang email ning kumpirmasyun a kailangan
                    mung i-confirm kilub ning 24 oras</span>.
                  <span class="text-red-400 font-medium">Nung e ka makakumpirma keng kilub ning panaun ayni, automatic
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
                  <span class="text-red-400 font-medium">Alang pakibat keng kilub ning panaun ayni, automatiku yang
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
                  <span class="text-red-400 font-medium">Nung e ka makapick up kilub ning atlung aldo a atyu kami king
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
  <section class="bg-gray-50 py-8 sm:py-12 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">


      <!-- Livewire Component -->
      @livewire('pet-listing')
    </div>
  </section>
  <!-- ========== END OF PET LISTING SECTION ========== -->

  <script>
    // ADOPTION PROCESS TABS
    document.addEventListener('DOMContentLoaded', function () {
      const tabButtons = document.querySelectorAll(".tab-btn");
      const tabContents = document.querySelectorAll(".tab-content");
      const processTitle = document.querySelector('#processTitle');

      // Set English as default active tab on initial load
      document.querySelector('[data-tab="english"]').classList.add("active", "bg-yellow-100");
      document.getElementById("tab-content-english").classList.remove("hidden");

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
          tabButtons.forEach(btn => btn.classList.remove("active", "bg-yellow-100"));
          button.classList.add("active", "bg-yellow-100");

          // Show correct tab
          tabContents.forEach(content => {
            content.classList.add("hidden");
          });
          document.getElementById(`tab-content-${tab}`).classList.remove("hidden");
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
     function updateHeaderSpacer() {
         const header = document.getElementById('main-header');
         const mainContent = document.getElementById('mainContent');
         
         if (header && mainContent) {
             const headerHeight = header.offsetHeight;
             mainContent.style.marginTop = `${headerHeight}px`;
             mainContent.style.paddingTop = `${headerHeight * .3}px`;
             mainContent.style.paddingBottom = `${headerHeight * .25}px`;
         }
     }
    
     // Initial update
     updateHeaderSpacer();
    
     // Update on window resize
     window.addEventListener('resize', updateHeaderSpacer);
    });
  </script>

  @livewireScripts
</x-layout>