<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative custom-gradient sm:bg-none" id="mainContent">

    <!-- Mobile background image -->
    <div class="sm:hidden absolute inset-0 w-full h-full overflow-hidden z-0">
      <img src="{{ asset('images/adopter.jpg') }}" alt="Adopt a Pet" class="w-full h-full object-cover brightness-50" />
    </div>

    <div class="relative z-10 max-w-screen-xl mx-auto px-4 md:px-8 lg:flex lg:items-center lg:gap-x-6">
      <!-- LEFT SIDE CONTENT -->
      <div class="lg:w-1/2 sm:mb-10 mb-0 text-left">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white sm:text-gray-900 leading-tight">
          <i class="ph-fill ph-paw-print text-yellow-500"></i> Browse pets
          at <span class="text-orange-500">OR<span class="text-yellow-500">PAW</span>NAGE</span>
          Adopt. Don't shop.
        </h1>
        <p class="mt-4 text-white sm:text-gray-600">
          Browse through these pets looking for a new home. Give them
          a second chance at life.
        </p>

        <!-- Adoption Process (Interactive Stepper + Accordion) -->
        <div class="my-6 p-6 bg-gray-50/80 backdrop-blur-lg rounded-lg border border-yellow-500">
          <div class="flex items-center justify-between flex-wrap gap-3">
            <h3 class="font-bold text-lg text-black" id="processTitle">
              <i class="ph-fill ph-paw-print text-orange-500"></i> Adoption Process
            </h3>
            <div class="flex space-x-2 overflow-x-auto scrollbar-hidden" id="language-tabs">
              <button data-tab="english"
                class="tab-btn bg-white px-3 py-1 rounded border border-yellow-400 text-black font-medium hover:bg-yellow-300 active">English</button>
              <button data-tab="tagalog"
                class="tab-btn bg-white px-3 py-1 rounded border border-yellow-400 text-black font-medium hover:bg-yellow-300">Taglish</button>
              <button data-tab="kapampangan"
                class="tab-btn bg-white px-3 py-1 rounded border border-yellow-400 text-black font-medium hover:bg-yellow-300">Kapampangan</button>
            </div>
          </div>

          <!-- Stepper -->
          <div class="mt-4">
            <div class="hidden sm:flex items-center justify-between">
              <div class="flex-1 h-2 bg-gray-200 rounded-full mr-3">
                <div id="processProgress" class="h-2 bg-orange-500 rounded-full" style="width: 16.67%"></div>
              </div>
              <span id="processStepLabel" class="text-xs text-gray-600">Step 1 of 6</span>
            </div>
            <div class="mt-2 hidden sm:grid grid-cols-6 gap-2 text=[11px] text-gray-700">
              <div class="text-center">Apply</div>
              <div class="text-center">Confirm</div>
              <div class="text-center">Prepare</div>
              <div class="text-center">Schedule</div>
              <div class="text-center">Bring</div>
              <div class="text-center">Pickup Photo</div>
            </div>
          </div>

          <!-- Accordion Steps per language (fixed height on desktop to avoid layout shift) -->
          <div class="mt-4 sm:h-96 sm:overflow-y-auto sm:pr-1 scrollbar-hidden">
            <!-- English -->
            <div id="tab-content-english" class="tab-content">
              <div class="space-y-2">
                <details class="process-step" data-step="1" open>
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">1) Apply</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        <span class="font-medium">Complete this form</span> with accurate personal information and
                        adoption details.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="2">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">2) Confirm</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        After submission, you'll receive a <span class="font-medium">confirmation email that you need to
                          confirm within 24 hours</span>.
                        <span class="text-red-400 font-medium">Failure to confirm within this period will automatically
                          cancel your application.</span>
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="3">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">3) Prepare</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Once confirmed, you'll receive another email with the estimated preparation time for your pet.
                        Please wait for the <span class="font-medium">scheduling email</span> to proceed.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="4">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">4) Schedule</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        When you receive the scheduling email, you must <span class="font-medium">set a pickup date
                          within 48 hours</span>.
                        <span class="text-red-400 font-medium">No response within this timeframe will cancel your
                          application.</span> Available dates will be within 7 business days from the scheduling email
                        date.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="5">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">5) Bring</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        On your scheduled date, bring:
                        <ul class="list-disc list-inside ml-5 mt-1">
                          <li>A valid government-issued ID</li>
                          <li>Your transaction confirmation email</li>
                        </ul>
                        <span class="text-red-400 font-medium">Failure to pick up within 3 business days after your
                          scheduled date will cancel the adoption.</span>
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="6">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">6) Pickup</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li>
                        At pickup, we'll take <span class="font-medium">an official photo</span> of you with your new
                        pet holding an adoption information board. This may be shared on the City Information Office's
                        official channels.
                      </li>
                    </ol>
                  </div>
                </details>
              </div>
            </div>

            <!-- Tagalog -->
            <div id="tab-content-tagalog" class="tab-content hidden">
              <div class="space-y-2">
                <details class="process-step" data-step="1" open>
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">1) Mag-apply</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        <span class="font-medium">Kumpletuhin ang form na ito</span> ng may tamang personal na
                        impormasyon at detalye ng pag-aadopt.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="2">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">2) Kumpirma</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Pagkatapos i-submit, makakatanggap ka ng <span class="font-medium">confirmation email na
                          kailangan mong i-confirm sa loob ng 24 oras</span>.
                        <span class="text-red-400 font-medium">Ang hindi pag-confirm sa loob ng panahong ito ay
                          awtomatikong magkakansela ng iyong aplikasyon.</span>
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="3">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">3) Paghahanda</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Kapag na-confirm na, makakatanggap ka ng isa pang email na naglalaman ng estimated time kung
                        gaano katagal i-prepare ang iyong ina-adopt na pet. Hintayin ang <span class="font-medium">email
                          para sa schedule</span> bago magpatuloy.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="4">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">4) Schedule</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Kapag natanggap mo na ang email para sa schedule, kailangan mong <span
                          class="font-medium">mag-set ng pickup date sa loob ng 48 oras</span>.
                        <span class="text-red-400 font-medium">Ang hindi pagtugon sa loob ng panahong ito ay
                          awtomatikong magkakansela ng iyong aplikasyon.</span> Ang mga available na petsa ay sa loob ng
                        7 working days ng aming opisina mula sa petsa ng email.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="5">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">5) Dalhin</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
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
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="6">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">6) Pickup</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li>
                        Sa oras ng pickup, kukunan ka ng <span class="font-medium">opisyal na larawan</span> kasama ang
                        iyong bagong alaga na may hawak na adoption information board. I-popost po namin ito sa opisyal
                        na channels ng City Information Office.
                      </li>
                    </ol>
                  </div>
                </details>
              </div>
            </div>

            <!-- Kapampangan -->
            <div id="tab-content-kapampangan" class="tab-content hidden">
              <div class="space-y-2">
                <details class="process-step" data-step="1" open>
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">1) Mag-apply</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        <span class="font-medium">Kumpletuan me ining form</span> gamit ing kekang personal a
                        impormasyun ampo ing detalye ning kekang pamag-adopt.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="2">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">2) Kumpirma</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Kaybat meng i-submit, <span class="font-medium">makatanggap kang email ning kumpirmasyun a
                          kailangan mung i-confirm kilub ning 24 oras</span>.
                        <span class="text-red-400 font-medium">Nung e ka makakumpirma keng kilub ning panaun ayni,
                          automatic yang makansela ing kekang aplikasyun.</span>
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="3">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">3) Pagsasanaya</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Nung mekumpirma ne, <span class="font-medium">makatanggap kang aliwang email</span> a ating
                        makalageng estimated time kung angga kang kapilan ka manaya king preparation mi para keng
                        ayampunan mung animal. <span class="font-medium">Paki-panayan mu ing email ning
                          pamag-schedule.</span>
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="4">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">4) Schedule</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Potang atanggap mu ne ing email ning pamag-schedule, <span class="font-medium">kailangan meng
                          i-set ing pickup date kilub ning 48 oras</span>.
                        <span class="text-red-400 font-medium">Alang pakibat keng kilub ning panaun ayni, automatiku
                          yang makansela ing kekang aplikasyun.</span> Deng available a petsa atyu la kilub ning 7 aldo
                        a atyu kami keng office mi (e kayabe ing Sabado ampong Domingo) manibat keng petsa ning email.
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="5">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">5) Dalhin</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Keng kekang makatakda a petsa, magdala kang:
                        <ul class="list-disc list-inside ml-5 mt-1">
                          <li>Metung a valid a ID a pepalwal ning gubyernu</li>
                          <li>Ing kekang email ning kumpirmasyun keng transaksyon</li>
                        </ul>
                        <span class="text-red-400 font-medium">Nung e ka makapick up kilub ning atlung aldo a atyu kami
                          king office mi (e kayabe ing Sabado ampong Domingo) kaybat ning kekang schedule date,
                          automatikung yang makansela ing kekang aplikasyun.</span>
                      </li>
                    </ol>
                  </div>
                </details>
                <details class="process-step" data-step="6">
                  <summary class="cursor-pointer p-3 bg-white rounded border flex items-center justify-between">
                    <span class="font-medium text-gray-800">6) Pickup</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ol class="list-decimal list-inside space-y-2 leading-7">
                      <li>
                        Keng pickup, <span class="font-medium">kuanan mi ing opisyal a litrato mu</span> kayabe ing
                        bayung animal mung tatalan ampo ing detalye yu a makasulat keng adoption information board.
                        I-post mi ya ini kareng opisyal a channels ning City Information Office.
                      </li>
                    </ol>
                  </div>
                </details>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE IMAGE -->
      <div class="lg:w-1/2 relative">
        <div class="hidden sm:block w-full sm:max-w-[500px] mx-auto relative">
          <!-- Main Image -->
          <img src="{{ asset('images/adopter.jpg') }}" alt="Pet Adoption Hero Image"
            class="w-full rounded-xl brightness-[.75] relative z-10" />

          <!-- Paw Print Corner Accents -->
          <div class="absolute -top-12 -left-12 -rotate-45 text-yellow-500 z-20">
            <i class="ph-fill ph-paw-print text-8xl"></i>
          </div>
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
    // ADOPTION PROCESS TABS + STEPPER PROGRESS SYNC
    document.addEventListener('DOMContentLoaded', function () {
      const tabButtons = document.querySelectorAll(".tab-btn");
      const tabContents = document.querySelectorAll(".tab-content");
      const processTitle = document.querySelector('#processTitle');
      const steps = document.querySelectorAll('.process-step');
      const progress = document.getElementById('processProgress');
      const label = document.getElementById('processStepLabel');
      const total = 6;

      function setActiveTab(tab) {
        if (tab === 'english') processTitle.textContent = 'Adoption Process';
        if (tab === 'tagalog') processTitle.textContent = 'Proseso sa Pag-aadopt';
        if (tab === 'kapampangan') processTitle.textContent = 'Prosesu king Pamag-adopt';

        tabButtons.forEach(btn => btn.classList.remove("active", "bg-yellow-100"));
        document.querySelector(`[data-tab="${tab}"]`).classList.add("active", "bg-yellow-100");

        tabContents.forEach(content => content.classList.add("hidden"));
        document.getElementById(`tab-content-${tab}`).classList.remove("hidden");
      }

      function updateProgress(step) {
        const pct = Math.max(16.67, Math.min(100, (step / total) * 100));
        progress.style.width = pct + '%';
        label.textContent = `Step ${step} of ${total}`;
      }

      document.body.addEventListener('toggle', function(e) {
        const details = e.target.closest('details.process-step');
        if (!details || !details.open) return;
        const current = Number(details.getAttribute('data-step')) || 1;
        updateProgress(current);
      }, true);

      // Defaults
      setActiveTab('english');
      updateProgress(1);

      tabButtons.forEach(button => {
        button.addEventListener("click", () => setActiveTab(button.getAttribute("data-tab")));
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

  <script>
    // Simple toggler for badge text/description
    function changeText(el) {
      const original = el.getAttribute('data-original-text') || el.textContent.trim();
      const desc = el.getAttribute('data-description') || '';
      // Store original once
      if (!el.getAttribute('data-original-text')) {
        el.setAttribute('data-original-text', original);
      }
      const showingDesc = el.getAttribute('data-showing') === 'desc';
      if (showingDesc) {
        el.textContent = el.getAttribute('data-original-text');
        el.setAttribute('data-showing', 'orig');
      } else {
        el.textContent = desc;
        el.setAttribute('data-showing', 'desc');
      }
    }
  </script>

  @livewireScripts
</x-layout>