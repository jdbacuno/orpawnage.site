<x-layout>
  <!-- START OF THE SECTION -->
  <section class="bg-white" id="mainContent">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Pet Header -->
      <div class="flex flex-wrap justify-between items-center gap-3 mt-2 mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
          {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
        </h2>
        <span class="bg-yellow-400 text-black py-1 px-3 rounded-full text-2xl font-bold shadow-sm">
          {{ $pet->species === 'feline' ? '🐱 Cat' : '🐶 Dog' }} #{{ $pet->pet_number }}
        </span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start mb-10">
        <!-- LEFT SIDE: Pet Image and Details -->
        <div>
          <!-- Pet Image -->
          <div class="overflow-hidden rounded-lg shadow-md h-fit cursor-pointer"
            onclick="openImageModal('{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}', '{{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}')">
            <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
              class="w-full h-auto max-h-[500px] object-cover transition-transform duration-500 hover:scale-105" />
          </div>

          <!-- Pet Information Card -->
          <div class="mt-6 bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm h-fit">
            @if($hasPendingApplication)
            <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <i class="ph-fill ph-warning text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-3">
                  <p class="text-sm text-yellow-700">
                    You currently have an ongoing adoption application.
                    <a href="/transactions/adoption-status"
                      class="font-medium underline text-yellow-700 hover:text-yellow-600">
                      View your current application</a>.
                    Please wait until it's completed or rejected before submitting a new request.
                  </p>
                </div>
              </div>
            </div>
            @endif

            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
              <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="ph-fill ph-paw-print mr-2 text-orange-500"></i>Pet Details
              </h3>
              @php
              $timeAgo = \Carbon\Carbon::parse($pet->created_at)->diffForHumans();
              @endphp
              <span class="bg-black/10 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                <i class="ph-fill ph-clock mr-1"></i> Added {{ $timeAgo }}
              </span>
            </div>

            <!-- Badge Grid -->
            <div class="grid grid-cols-2 gap-3">
              <!-- Species -->
              @php
              $speciesIcon = match ($pet->species) {
              'canine' => 'dog',
              'feline' => 'cat',
              default => 'paw-print'
              };
              @endphp

              <div class="bg-blue-50 text-blue-800 px-4 py-3 rounded-lg border border-blue-100 flex flex-col">
                <p class="text-xs font-medium text-blue-600 flex items-center">
                  <i class="ph-fill ph-{{ $speciesIcon }} mr-1"></i> Species
                </p>
                <p class="font-medium mt-1">{{ ucfirst($pet->species) }}</p>
              </div>

              <!-- Age -->
              <div class="bg-purple-50 text-purple-800 px-4 py-3 rounded-lg border border-purple-100 flex flex-col">
                <p class="text-xs font-medium text-purple-600 flex items-center">
                  <i class="ph-fill ph-cake mr-1"></i> Age
                </p>
                <p class="font-medium mt-1">
                  {{ $pet->age }} {{ $pet->age == 1 ? Str::singular($pet->age_unit) : Str::plural($pet->age_unit) }}
                </p>
              </div>

              <!-- Sex -->
              <div
                class="{{ $pet->sex == 'male' ? 'bg-blue-50 text-blue-800 border-blue-100' : 'bg-pink-50 text-pink-800 border-pink-100' }} px-4 py-3 rounded-lg border flex flex-col">
                <p
                  class="text-xs font-medium {{ $pet->sex == 'male' ? 'text-blue-600' : 'text-pink-600' }} flex items-center">
                  <i class="ph-fill ph-{{ $pet->sex == 'male' ? 'gender-male' : 'gender-female' }} mr-1"></i> Sex
                </p>
                <p class="font-medium mt-1">{{ ucfirst($pet->sex) }}</p>
              </div>

              <!-- Reproductive Status -->
              @php
              $isNeutered = $pet->reproductive_status === 'neutered';
              $isIntact = $pet->reproductive_status === 'intact';
              $isCanine = $pet->species === 'canine';
              $isFeline = $pet->species === 'feline';

              $bgClass = $isNeutered ? 'bg-green-50 text-green-800 border-green-100' : 'bg-amber-50 text-amber-800
              border-amber-100';
              $textColor = $isNeutered ? 'text-green-600' : 'text-amber-600';
              $icon = match (true) {
              $isNeutered => 'scissors',
              $isIntact && $isCanine => 'dog',
              $isIntact && $isFeline => 'cat',
              default => 'question'
              };
              @endphp

              <div class="{{ $bgClass }} px-4 py-3 rounded-lg border flex flex-col">
                <p class="text-xs font-medium {{ $textColor }} flex items-center">
                  <i class="ph-fill ph-{{ $icon }} mr-1"></i>
                  Reproductive
                </p>
                <p class="font-medium mt-1">{{ ucfirst($pet->reproductive_status) }}</p>
              </div>

              <!-- Color -->
              <div class="bg-indigo-50 text-indigo-800 px-4 py-3 rounded-lg border border-indigo-100 flex flex-col">
                <p class="text-xs font-medium text-indigo-600 flex items-center">
                  <i class="ph-fill ph-palette mr-1"></i> Color
                </p>
                <p class="font-medium mt-1">{{ ucfirst($pet->color) }}</p>
              </div>

              <!-- Source -->
              <div class="bg-gray-50 text-gray-800 px-4 py-3 rounded-lg border border-gray-200 flex flex-col">
                <p class="text-xs font-medium text-gray-600 flex items-center">
                  <i class="ph-fill ph-buildings mr-1"></i> Source
                </p>
                <p class="font-medium mt-1">{{ ucfirst($pet->source) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- RIGHT SIDE: Adoption Process Card -->
        <div class="p-6 bg-gray-50/80 backdrop-blur-lg rounded-lg border border-yellow-500 shadow-md">
          <div class="flex items-center justify-between flex-wrap gap-3">
            <h3 class="font-bold text-lg text-black" id="processTitle">
              <i class="ph-fill ph-paw-print text-orange-500"></i> Adoption Process
            </h3>
            <div class="flex space-x-2 overflow-x-auto scrollbar-hidden" id="language-tabs">
              <button data-tab="english"
                class="tab-btn bg-white px-4 py-1.5 rounded-full border border-yellow-400 text-black font-medium hover:bg-yellow-300 active">English</button>
              <button data-tab="tagalog"
                class="tab-btn bg-white px-4 py-1.5 rounded-full border border-yellow-400 text-black font-medium hover:bg-yellow-300">Taglish</button>
              <button data-tab="kapampangan"
                class="tab-btn bg-white px-4 py-1.5 rounded-full border border-yellow-400 text-black font-medium hover:bg-yellow-300">Kapampangan</button>
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
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">1) Apply</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        <span class="font-medium">Complete this form</span> with accurate personal information and
                        adoption details.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="2">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">2) Confirm</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        After submission, you'll receive a <span class="font-medium">confirmation email that you need to
                          confirm within 24 hours</span>.
                        <span class="text-red-400 font-medium">Failure to confirm within this period will automatically
                          cancel your application.</span>
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="3">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">3) Prepare</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Once confirmed, you'll receive another email with the estimated preparation time for your pet.
                        Please wait for the <span class="font-medium">scheduling email</span> to proceed.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="4">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">4) Schedule</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        When you receive the scheduling email, you must <span class="font-medium">set a pickup date
                          within 48 hours</span>.
                        <span class="text-red-400 font-medium">No response within this timeframe will cancel your
                          application.</span> Available dates will be within 7 business days from the scheduling email
                        date.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="5">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">5) Bring</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        On your scheduled date, bring:
                        <ul class="list-disc list-inside ml-5 mt-1">
                          <li>A valid government-issued ID</li>
                          <li>Your transaction confirmation email</li>
                        </ul>
                        <span class="text-red-400 font-medium">Failure to pick up within 3 business days after your
                          scheduled date will cancel the adoption.</span>
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="6">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">6) Pickup</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li>
                        At pickup, we'll take <span class="font-medium">an official photo</span> of you with your new
                        pet holding an adoption information board. This may be shared on the City Information Office's
                        official channels.
                      </li>
                    </ul>
                  </div>
                </details>
              </div>
            </div>

            <!-- Tagalog -->
            <div id="tab-content-tagalog" class="tab-content hidden">
              <div class="space-y-2">
                <details class="process-step" data-step="1" open>
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">1) Mag-apply</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        <span class="font-medium">Kumpletuhin ang form na ito</span> ng may tamang personal na
                        impormasyon at detalye ng pag-aadopt.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="2">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">2) Kumpirma</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Pagkatapos i-submit, makakatanggap ka ng <span class="font-medium">confirmation email na
                          kailangan mong i-confirm sa loob ng 24 oras</span>.
                        <span class="text-red-400 font-medium">Ang hindi pag-confirm sa loob ng panahong ito ay
                          awtomatikong magkakansela ng iyong aplikasyon.</span>
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="3">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">3) Paghahanda</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Kapag na-confirm na, makakatanggap ka ng isa pang email na naglalaman ng estimated time kung
                        gaano katagal i-prepare ang iyong ina-adopt na pet. Hintayin ang <span class="font-medium">email
                          para sa schedule</span> bago magpatuloy.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="4">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">4) Schedule</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Kapag natanggap mo na ang email para sa schedule, kailangan mong <span
                          class="font-medium">mag-set ng pickup date sa loob ng 48 oras</span>.
                        <span class="text-red-400 font-medium">Ang hindi pagtugon sa loob ng panahong ito ay
                          awtomatikong magkakansela ng iyong aplikasyon.</span> Ang mga available na petsa ay sa loob ng
                        7 working days ng aming opisina mula sa petsa ng email.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="5">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">5) Dalhin</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
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
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="6">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">6) Pickup</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li>
                        Sa oras ng pickup, kukunan ka ng <span class="font-medium">opisyal na larawan</span> kasama ang
                        iyong bagong alaga na may hawak na adoption information board. I-popost po namin ito sa opisyal
                        na channels ng City Information Office.
                      </li>
                    </ul>
                  </div>
                </details>
              </div>
            </div>

            <!-- Kapampangan -->
            <div id="tab-content-kapampangan" class="tab-content hidden">
              <div class="space-y-2">
                <details class="process-step" data-step="1" open>
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">1) Mag-apply</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        <span class="font-medium">Kumpletuan me ining form</span> gamit ing kekang personal a
                        impormasyun ampo ing detalye ning kekang pamag-adopt.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="2">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">2) Kumpirma</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Kaybat meng i-submit, <span class="font-medium">makatanggap kang email ning kumpirmasyun a
                          kailangan mung i-confirm kilub ning 24 oras</span>.
                        <span class="text-red-400 font-medium">Nung e ka makakumpirma keng kilub ning panaun ayni,
                          automatic yang makansela ing kekang aplikasyun.</span>
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="3">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">3) Pagsasanaya</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Nung mekumpirma ne, <span class="font-medium">makatanggap kang aliwang email</span> a ating
                        makalageng estimated time kung angga kang kapilan ka manaya king preparation mi para keng
                        ayampunan mung animal. <span class="font-medium">Paki-panayan mu ing email ning
                          pamag-schedule.</span>
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="4">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">4) Schedule</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Potang atanggap mu ne ing email ning pamag-schedule, <span class="font-medium">kailangan meng
                          i-set ing pickup date kilub ning 48 oras</span>.
                        <span class="text-red-400 font-medium">Alang pakibat keng kilub ning panaun ayni, automatiku
                          yang makansela ing kekang aplikasyun.</span> Deng available a petsa atyu la kilub ning 7 aldo
                        a atyu kami keng office mi (e kayabe ing Sabado ampong Domingo) manibat keng petsa ning email.
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="5">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">5) Dala</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li class="pb-2 border-b border-blue-100">
                        Keng kekang makatakda a petsa, magdala kang:
                        <ul class="list-disc list-inside ml-5 mt-1">
                          <li>Metung a valid a ID a pepalwal ning gubyernu</li>
                          <li>Ing kekang email ning kumpirmasyun keng transaksyun</li>
                        </ul>
                        <span class="text-red-400 font-medium">Nung e ka makapick up kilub ning atlung aldo a atyu kami
                          king office mi (e kayabe ing Sabado ampong Domingo) kaybat ning kekang schedule date,
                          automatikung yang makansela ing kekang aplikasyun.</span>
                      </li>
                    </ul>
                  </div>
                </details>
                <details class="process-step" data-step="6">
                  <summary class="cursor-pointer p-3 bg-white rounded-full border flex items-center justify-between">
                    <span class="font-medium text-gray-800">6) Pickup</span>
                    <i class="ph-fill ph-caret-down text-gray-500"></i>
                  </summary>
                  <div class="p-3 text-sm text-gray-700">
                    <ul class="list-disc list-inside space-y-2 leading-7">
                      <li>
                        Keng pickup, <span class="font-medium">kuanan mi ing opisyal a litrato mu</span> kayabe ing
                        bayung animal mung tatalan ampo ing detalye yu a makasulat keng adoption information board.
                        I-post mi ya ini kareng opisyal a channels ning City Information Office.
                      </li>
                    </ul>
                  </div>
                </details>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom: Adoption Form (Wizard) -->
      <div class="p-6 rounded-xl bg-gray-50 border border-gray-300 shadow-md">
        <!-- Alerts -->
        @if (session('success'))
        <div id="alert-3"
          class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 border-l-4 border-green-400"
          role="alert">
          <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
          </svg>
          <span class="sr-only">Info</span>
          <div class="ms-3 text-sm font-medium">
            {!! session('success') !!}
          </div>
          <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
            data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
          </button>
        </div>
        @endif

        @if (session('error_request') || session('submission_error'))
        <div id="alert-3" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 border-l-4 border-red-400"
          role="alert">
          <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
          </svg>
          <span class="sr-only">Info</span>
          <div class="ms-3 text-sm font-medium">
            {{ session('error_request') ?? session('submission_error') }}
          </div>
          <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
            data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
          </button>
        </div>
        @endif

        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
          <i class="ph-fill ph-clipboard-text mr-2 text-orange-500"></i>Adoption Application Form
        </h3>

        <!-- Stepper -->
        <div class="mb-4">
          <div class="flex items-center justify-between">
            <div class="flex-1 h-2 bg-gray-200 rounded-full mr-3">
              <div id="adoptProgress" class="h-2 bg-orange-500 rounded-full" style="width: 25%"></div>
            </div>
            <span id="adoptStepLabel" class="text-xs text-gray-600">Step 1 of 4</span>
          </div>
          <div class="mt-2 grid grid-cols-4 gap-2 text-[11px] text-gray-600">
            <div class="text-center">Personal</div>
            <div class="text-center">Pet Qs</div>
            <div class="text-center">Documents</div>
            <div class="text-center">Oath & Submit</div>
          </div>
        </div>

        <form method="POST" action="/services/{{ $pet->slug }}/adoption-form" id="applicationForm"
          enctype="multipart/form-data">
          @csrf

          <!-- Step 1: Personal Information -->
          <div class="adopt-step" data-step="1">
            <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
              <i class="ph-fill ph-user-circle mr-2"></i>Personal Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
                <input type="text" name="full_name"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your full name" value="{{ old('full_name') }}" required />
                <x-form-error name="full_name" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100"
                  placeholder="Your email" value="{{ auth()->user()->email }}" readonly required />
                <x-form-error name="email" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Birthdate</label>
                <input type="date" name="birthdate" id="birthdate"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('birthdate') }}" required max="{{ date('Y-m-d') }}"
                  onchange="calculateAge(this.value)" />
                <x-form-error name="birthdate" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Age</label>
                <input type="number" name="age" id="age"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100"
                  placeholder="Auto-calculated" value="{{ old('age') }}" readonly required />
                <x-form-error name="age" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Contact Number</label>
                <input type="text" name="contact_number"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100"
                  placeholder="Your contact number"
                  value="{{ auth()->user()->contact_number ?: 'Not Set (Please update in Account Settings)' }}" readonly
                  required />
                <x-form-error name="contact_number" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                <input type="text" name="address"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your residential address" value="{{ old('address') }}" required />
                <x-form-error name="address" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Civil Status</label>
                <select name="civil_status"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="" disabled {{ old('civil_status') ? '' : 'selected' }}>Select status</option>
                  <option value="Single" {{ old('civil_status')=='Single' ? 'selected' : '' }}>Single</option>
                  <option value="Married" {{ old('civil_status')=='Married' ? 'selected' : '' }}>Married</option>
                  <option value="Divorced" {{ old('civil_status')=='Divorced' ? 'selected' : '' }}>Divorced</option>
                </select>
                <x-form-error name="civil_status" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Citizenship</label>
                <input type="text" name="citizenship"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your citizenship" value="{{ old('citizenship') }}" required />
                <x-form-error name="citizenship" />
              </div>
            </div>
          </div>


          <!-- Step 2: Pet-related Questions -->
          <div class="adopt-step hidden" data-step="2">
            <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
              <i class="ph-fill ph-paw-print mr-2"></i>Pet Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Why do you want to adopt?</label>
                <textarea name="reason_for_adoption"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  rows="8" placeholder="Explain why you want to adopt this pet"
                  required>{{ old('reason_for_adoption') }}</textarea>
                <x-form-error name="reason_for_adoption" />
              </div>
              <div class="flex flex-col gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Do you visit a Veterinarian?</label>
                  <select name="visit_veterinarian"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    required>
                    <option value="" disabled {{ old('visit_veterinarian') ? '' : 'selected' }}>Select option</option>
                    <option value="Yes" {{ old('visit_veterinarian')=='Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ old('visit_veterinarian')=='No' ? 'selected' : '' }}>No</option>
                    <option value="Sometimes" {{ old('visit_veterinarian')=='Sometimes' ? 'selected' : '' }}>Sometimes
                    </option>
                  </select>
                  <x-form-error name="visit_veterinarian" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Do you have any pet(s) in your house? How
                    many?</label>
                  <input type="number" name="existing_pets"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Number of pets you currently have" value="{{ old('existing_pets') }}" required />
                  <x-form-error name="existing_pets" />
                </div>
              </div>
            </div>
          </div>

          <!-- Step 3: Documents -->
          <div class="adopt-step hidden" data-step="3">
            <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
              <i class="ph-fill ph-identification-card mr-2"></i>Documents
            </h4>
            <div>
              <div class="flex justify-between items-center mb-1">
                <label class="block text-sm font-medium text-gray-600">Upload Valid ID <span
                    class="text-red-500">*</span></label>
                <button type="button" onclick="openValidIdModal()"
                  class="text-sm text-orange-600 hover:text-orange-700 font-medium cursor-pointer">View Accepted Valid
                  IDs</button>
              </div>
              <input type="file" name="valid_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                required />
              <x-form-error name="valid_id" />
            </div>
          </div>

          <!-- Step 4: Oath & Submit -->
          <div class="adopt-step hidden" data-step="4">
            <div class="p-4 bg-orange-50 rounded-lg border border-orange-100">
              <h4 class="text-sm font-medium text-orange-800 mb-2 flex items-center">
                <i class="ph-fill ph-hand-palm mr-2"></i>Oath Declaration
              </h4>
              <div class="text-sm text-gray-700 leading-relaxed">
                I, <span id="inserted_name" class="font-semibold text-orange-600">[Your Full Name]</span>, do solemnly
                swear that I will take good care of my adopted pet, and he/she will not stray in the street again. I
                will take him/her to a veterinarian for regular check-ups and/or vaccination.
                <br><br>
                Issued this <span id="oath_day" class="font-semibold text-orange-600">[Day]</span> day of <span
                  id="oath_month" class="font-semibold text-orange-600">[Month]</span>, 20<span id="oath_year"
                  class="font-semibold text-orange-600">[YY]</span>, at the Orpawnage Angeles Main Office - Animal
                Shelter, Angeles City Pampanga.
              </div>
            </div>

            <div class="flex justify-end mt-4">
              <button type="submit" id="submitAdoption"
                class="px-5 mt-2 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                <i class="ph-fill ph-paw-print mr-2"></i>Submit Adoption Request
              </button>
            </div>
          </div>

          <!-- Wizard Controls -->
          <div class="mt-4 flex items-center justify-between">
            <button type="button" id="adoptPrev"
              class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-40"
              disabled>
              Back
            </button>
            <button type="button" id="adoptNext"
              class="px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              Next
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>

  <!-- Valid ID Modal -->
  <div id="validIdModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-1">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full space-y-4 relative max-h-[90vh] overflow-y-auto">
      <!-- Close Button -->
      <button onclick="closeValidIdModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold">Accepted Valid IDs</h2>

      <div class="text-sm text-gray-600 space-y-4">
        <div>
          <strong class="block mb-2">Primary IDs:</strong>
          <ul class="list-disc list-inside ml-4 space-y-1">
            <li>Philippine Identification (PhilID/ePhilID)</li>
            <li>Passport</li>
            <li>Driver's License</li>
            <li>UMID</li>
            <li>PRC ID</li>
            <li>Voter's ID</li>
          </ul>
        </div>

        <div>
          <strong class="block mb-2">Secondary IDs:</strong>
          <ul class="list-disc list-inside ml-4 space-y-1">
            <li>PhilHealth ID</li>
            <li>Postal ID</li>
            <li>Senior Citizen ID</li>
            <li>PWD ID</li>
            <li>School ID</li>
            <li>TIN</li>
            <li>Company ID</li>
            <li>Baptismal Certificate</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  {{-- FULL IMAGE VIEW MODAL --}}
  <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative w-auto">
      <!-- Full Size Image -->
      <img id="modalImage" src="" alt="Full size pet image"
        class="w-full h-auto max-h-[90vh] object-contain rounded-lg">

      <!-- Image Caption -->
      <div class="text-center mt-2 text-white">
        <span id="imageCaption" class="text-lg"></span>
      </div>
    </div>
  </div>

  <script>
    // Wizard logic for Adoption form
    (function() {
      const steps = Array.from(document.querySelectorAll('.adopt-step'));
      const nextBtn = document.getElementById('adoptNext');
      const prevBtn = document.getElementById('adoptPrev');
      const progress = document.getElementById('adoptProgress');
      const label = document.getElementById('adoptStepLabel');
      const total = steps.length || 4;
      let current = 1;

      function showStep(step) {
        steps.forEach(s => s.classList.add('hidden'));
        const active = steps.find(s => s.getAttribute('data-step') === String(step));
        if (active) active.classList.remove('hidden');

        const pct = Math.max(25, Math.min(100, (step / total) * 100));
        progress.style.width = pct + '%';
        label.textContent = `Step ${step} of ${total}`;

        prevBtn.disabled = step === 1;
        nextBtn.classList.toggle('hidden', step === total);
      }

      function validateStep(step) {
        const container = steps.find(s => s.getAttribute('data-step') === String(step));
        if (!container) return true;
        const requiredInputs = container.querySelectorAll('[required]');
        for (const input of requiredInputs) {
          if (input.type === 'file') {
            if (!input.files || input.files.length === 0) {
              input.reportValidity();
              return false;
            }
          } else if (!input.value) {
            input.reportValidity();
            return false;
          }
        }
        return true;
      }

      nextBtn?.addEventListener('click', () => {
        if (!validateStep(current)) return;
        current = Math.min(total, current + 1);
        showStep(current);
      });
      prevBtn?.addEventListener('click', () => {
        current = Math.max(1, current - 1);
        showStep(current);
      });

      showStep(current);
    })();
    // OATH DATA AUTO-FILL
    document.addEventListener('DOMContentLoaded', function () {
      const fullNameInput = document.querySelector('input[name="full_name"]');
      const oathNameSpan = document.getElementById('inserted_name');

      fullNameInput.addEventListener('input', () => {
        oathNameSpan.textContent = fullNameInput.value.trim() || '[Your Full Name]';
      });

      function getOrdinal(n) {
        const s = ["th", "st", "nd", "rd"],
              v = n % 100;
        return n + (s[(v - 20) % 10] || s[v] || s[0]);
      }

      const today = new Date();
      document.getElementById('oath_day').textContent = getOrdinal(today.getDate());
      document.getElementById('oath_month').textContent = today.toLocaleString('default', { month: 'long' });
      document.getElementById('oath_year').textContent = String(today.getFullYear()).slice(-2);
    });

    function calculateAge(birthdate) {
      if (!birthdate) return;
      
      const today = new Date();
      const birthDate = new Date(birthdate);
      
      // Calculate age
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      
      // Update age field
      document.getElementById('age').value = age;
      
      // Update oath declaration with name if available
      const fullName = document.querySelector('input[name="full_name"]').value;
      if (fullName) {
        document.getElementById('inserted_name').textContent = fullName;
      }
      
      // Update oath date
      const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      
      document.getElementById('oath_day').textContent = days[today.getDay()];
      document.getElementById('oath_month').textContent = months[today.getMonth()];
      document.getElementById('oath_year').textContent = today.getFullYear().toString().slice(-2);
    }
    
    // Calculate age if birthdate exists on page load
    document.addEventListener('DOMContentLoaded', function() {
      const birthdate = document.getElementById('birthdate').value;
      if (birthdate) {
        calculateAge(birthdate);
      }
      
      // Also update name in oath if exists
      const fullName = document.querySelector('input[name="full_name"]').value;
      if (fullName) {
        document.getElementById('inserted_name').textContent = fullName;
      }
    });
    
    // Update name in oath when typing
    document.querySelector('input[name="full_name"]').addEventListener('input', function() {
      document.getElementById('inserted_name').textContent = this.value || '[Your Full Name]';
    });

    document.addEventListener('DOMContentLoaded', function() {
     function updateHeaderSpacer() {
         const header = document.getElementById('main-header');
         const mainContent = document.getElementById('mainContent');
         
         if (header && mainContent) {
             const headerHeight = header.offsetHeight;
             mainContent.style.marginTop = `${headerHeight}px`;
             mainContent.style.paddingTop = `${headerHeight * .25}px`;
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
        if (tab === 'tagalog') processTitle.textContent = 'Proseso sa Adoption';
        if (tab === 'kapampangan') processTitle.textContent = 'Prosesu king Adoption';

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
        if (!details) return;

        if (details.open) {
          // Close all other details
          document.querySelectorAll('.process-step').forEach(otherDetails => {
            if (otherDetails !== details) {
              otherDetails.open = false;
            }
          });

          const current = Number(details.getAttribute('data-step')) || 1;
          updateProgress(current);

          // Highlight active step
          document.querySelectorAll('.process-step summary').forEach(sum => sum.classList.remove('bg-yellow-100', 'border-yellow-400'));
          const activeSummary = details.querySelector('summary');
          activeSummary.classList.add('bg-yellow-100', 'border-yellow-400');
        }
      }, true);

      // Defaults
      setActiveTab('english');
      updateProgress(1);

      // Ensure first accordion is open and highlighted
      const firstDetails = document.querySelector('.process-step[data-step="1"]');
      if (firstDetails && !firstDetails.open) {
        firstDetails.open = true;
      }
      const initialSummary = document.querySelector('.process-step[data-step="1"] summary');
      if (initialSummary) {
        initialSummary.classList.add('bg-yellow-100', 'border-yellow-400');
      }

      tabButtons.forEach(button => {
        button.addEventListener("click", () => setActiveTab(button.getAttribute("data-tab")));
      });
    });
  </script>
</x-layout>