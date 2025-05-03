<x-layout>
  <!-- START OF THE SECTION -->
  <section class="py-20 bg-white">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <a href="/services/adopt-a-pet"
        class="text-white font-bold hover:text-blue-500 text-lg inline-flex items-center rounded-full pl-2 pr-4 bg-blue-500 hover:outline hover:bg-white hover:outline-blue-500">
        <i class="ph-fill ph-caret-left"></i><span>Back</span>
      </a>
      <h2 class="text-2xl font-bold text-gray-900 mt-4 mb-4">
        {{ $pet->species === 'feline' ? 'Cat' : 'Dog' }} #{{ $pet->pet_number }} {{ strtolower($pet->pet_name)
        !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
      </h2>
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 overflow-hidden">
        <!-- LEFT SIDE: Pet Image and Pet Information -->
        <div class="h-full w-full flex flex-col gap-y-4">
          {{-- Pet Image --}}
          <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
            class="w-full h-auto object-cover rounded-lg" />

          <!-- Adoption Process -->
          <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h3 class="font-bold text-lg text-blue-800 mb-4">Adoption Process Steps</h3>

            <!-- Tab Navigation -->
            <div class="flex space-x-2 mb-4" id="language-tabs">
              <button data-tab="english"
                class="tab-btn bg-white px-3 py-1 rounded border border-blue-300 text-blue-700 font-medium hover:bg-blue-100 active">English</button>
              <button data-tab="tagalog"
                class="tab-btn bg-white px-3 py-1 rounded border border-blue-300 text-blue-700 font-medium hover:bg-blue-100">Taglish</button>
              <button data-tab="kapampangan"
                class="tab-btn bg-white px-3 py-1 rounded border border-blue-300 text-blue-700 font-medium hover:bg-blue-100">Kapampangan</button>
            </div>

            <!-- Tab Contents -->
            <div id="tab-content-english" class="tab-content">
              <!-- English content goes here (same as your original English list) -->
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Complete this form</span> with accurate personal information and adoption
                  details.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  After submission, you'll receive a <span class="font-medium">confirmation email that you need to
                    confirm within 24
                    hours</span>.
                  <span class="text-red-600">Failure to confirm within this period will automatically cancel your
                    application.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Once confirmed, you'll receive another email with the estimated preparation time for your pet. Please
                  wait for the
                  <span class="font-medium">scheduling email</span> to proceed.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  When you receive the scheduling email, you must <span class="font-medium">set a pickup date within 48
                    hours</span>.
                  <span class="text-red-600">No response within this timeframe will cancel your application.</span>
                  Available dates will
                  be within 7 business days from the scheduling email date.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  On your scheduled date, bring:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>A valid government-issued ID</li>
                    <li>Your transaction confirmation email</li>
                  </ul>
                  <span class="text-red-600">Failure to pick up within 3 business days after your scheduled date will
                    cancel the adoption.</span>
                </li>
                <li>
                  At pickup, we'll take <span class="font-medium">an official photo</span> of you with your new pet
                  holding an adoption
                  information board. This may be shared on the City Information Office's official channels.
                </li>
              </ol>
            </div>

            <div id="tab-content-tagalog" class="tab-content hidden">
              <!-- Tagalog content goes here (same as your original Tagalog list) -->
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Kumpletuhin ang form na ito</span> ng may tamang personal na impormasyon at
                  detalye ng pag-aadopt.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Pagkatapos i-submit, makakatanggap ka ng <span class="font-medium">confirmation email na kailangan
                    mong i-confirm sa loob ng 24
                    oras</span>.
                  <span class="text-red-600">Ang hindi pag-confirm sa loob ng panahong ito ay awtomatikong magkakansela
                    ng iyong aplikasyon.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Kapag na-confirm na, makakatanggap ka ng isa pang email na naglalaman ng estimated time kung gaano
                  katagal i-prepare ang iyong ina-adopt na pet. Hintayin ang
                  <span class="font-medium">email para sa schedule</span> bago magpatuloy.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Kapag natanggap mo na ang email para sa schedule, kailangan mong <span class="font-medium">mag-set ng
                    pickup date sa loob ng 48 oras</span>.
                  <span class="text-red-600">Ang hindi pagtugon sa loob ng panahong ito ay awtomatikong magkakansela ng
                    iyong
                    aplikasyon.</span> Ang mga available na petsa ay sa loob ng 7 working days ng aming opisina mula sa
                  petsa ng
                  email.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Sa iyong nakatakdang petsa, dalhin ang:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>Valid na government ID</li>
                    <li>Ang iyong transaction confirmation email</li>
                  </ul>
                  <span class="text-red-600">Ang hindi pag-pick up sa loob ng 3 working days ng aming opisina pagkatapos
                    ng
                    nakatakdang pickup date ay awtomatikong magkakansela ng iyong application.</span>
                </li>
                <li>
                  Sa oras ng pickup, kukunan ka ng <span class="font-medium">opisyal na larawan</span> kasama ang iyong
                  bagong alaga na may hawak na adoption
                  information board. I-popost po namin ito sa opisyal na channels ng City Information Office.
                </li>
              </ol>
            </div>

            <div id="tab-content-kapampangan" class="tab-content hidden">
              <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                <li class="pb-2 border-b border-blue-100">
                  <span class="font-medium">Kumpletuan me ining form</span> gamit ing personal a impormasyun um ampo ing
                  detalye ning kekang pamag-adopt.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Kaybat meng i-submit, <span class="font-medium">makatanggap kang email ning kumpirmasyun a kailangan
                    mung i-confirm kilub ning 24
                    oras</span>.
                  <span class="text-red-600">Nung e ka makakumpirma keng kilub ning panaun ayni, automatic yang
                    makansela ing kekang aplikasyun.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Nung mekumpirma ne, <span class="font-medium">makatanggap kang aliwang email</span> a ating makalageng
                  estimated time kung angga kang kapilan ka manaya king preparation mi para keng ayampunan mung animal.
                  <span class="font-medium">Paki-panayan mu ing email ning pamag-schedule.</span>
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Potang atanggap mu ne ing email ning pamag-schedule, <span class="font-medium">kailangan meng i-set
                    ing
                    pickup date kilub ning 48 oras</span>.
                  <span class="text-red-600">Alang pakibat keng kilub ning panaun ayni, automatiku yang makansela ing
                    kekang
                    aplikasyun.</span>
                  Deng available a petsa atyu la kilub ning 7 aldo a atyu kami keng office mi (e kayabe ing Sabado
                  ampong Domingo) manibat keng petsa ning email.
                </li>
                <li class="pb-2 border-b border-blue-100">
                  Keng kekang makatakda a petsa, magdala kang:
                  <ul class="list-disc list-inside ml-5 mt-1">
                    <li>Metung a valid a ID a pepalwal ning gubyernu</li>
                    <li>Ing kekang email ning kumpirmasyun keng transaksyon</li>
                  </ul>
                  <span class="text-red-600">Nung e ka makapick up kilub ning atlung aldo a atyu kami king office mi (e
                    kayabe ing Sabado ampong Domingo) kaybat ning kekang schedule
                    date, automatikung yang makansela ing kekang
                    aplikasyun.</span>
                </li>
                <li>
                  Keng pickup, <span class="font-medium">kuanan mi ing opisyal a litrato mu</span> kayabe ing bayung
                  animal mung tatalan ampo ing detalye yu a makasulat keng adoption information board.
                  I-post mi ya ini kareng opisyal a channels ning City Information Office.
                </li>
              </ol>
            </div>

          </div>
        </div>

        <!-- RIGHT SIDE: User Information -->
        <div class="p-6 sm:pb-6 rounded-xl bg-gray-50 border border-gray-300 shadow-md">
          @if (session('success'))
          <div id="alert-3" class="flex items-center p-4 mb-3 text-green-800 rounded-lg bg-green-50 sm:col-span-7"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              {!! session('success') !!}
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
              data-dismiss-target="#alert-3" aria-label="Close" id="triggerElement">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          @if (session('error_request'))
          <div id="alert-3" class="flex items-center p-4 mb-3 text-red-800 rounded-lg bg-red-50 sm:col-span-7"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              {{ session('error_request') }}
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 "
              data-dismiss-target="#alert-3" aria-label="Close" id="triggerElement">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          @if (session('submission_error'))
          <div id="alert-3" class="flex items-center p-4 mb-3 text-red-800 rounded-lg bg-red-50 sm:col-span-7"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              {{ session('submission_error') }}
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 "
              data-dismiss-target="#alert-3" aria-label="Close" id="triggerElement">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          <!-- Toggle Button for Pet Information with Caret Icon -->
          <div class="flex items-center justify-between font-semibold text-lg text-gray-600 mb-2">

            <span>Pet Information</span>

            @php
            $timeAgo = \Carbon\Carbon::parse($pet->created_at)->diffForHumans();
            @endphp

            <span class="italic font-normal text-sm text-right">Added {{ $timeAgo }}</span>
          </div>

          <!-- Pet Details (Initially Visible) -->
          <div id="petDetails" class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-300">
            <div>
              <label class="text-sm font-medium text-gray-600">Species</label>
              <input type="text" value="{{ ucfirst($pet->species) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Age</label>
              <input type="text"
                value="{{ $pet->age }} {{ $pet->age == 1 ? Str::singular($pet->age_unit) : Str::plural($pet->age_unit) }} old"
                readonly class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Sex</label>
              <input type="text" value="{{ ucfirst($pet->sex) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Reproductive Status</label>
              <input type="text" value="{{ ucfirst($pet->reproductive_status) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Color</label>
              <input type="text" value="{{ ucfirst($pet->color) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600">Source</label>
              <input type="text" value="{{ ucfirst($pet->source) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900" />
            </div>
          </div>

          <!-- User Details -->
          <span class="flex items-center text-lg font-semibold text-gray-600 mb-2">
            Fill out this form with your information:
          </span>

          <div id="userDetails">
            <form method="POST" action="/services/{{ $pet->slug }}/adoption-form" id="applicationForm"
              enctype="multipart/form-data">
              @csrf

              <!-- Form Fields -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                  <label class="text-sm font-medium text-gray-600">Name</label>
                  <input type="text" name="full_name"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                    placeholder="Enter your full name" value="{{ old('full_name') }}" required />
                  <x-form-error name="full_name" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Email Address</label>
                  <input type="email" name="email"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100"
                    placeholder="Enter your email address" value="{{ auth()->user()->email }}" readonly required />
                  <x-form-error name="email" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Age</label>
                  <input type="number" name="age"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                    placeholder="Enter your age" value="{{ old('age') }}" required />
                  <x-form-error name="age" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Birthdate</label>
                  <input type="date" name="birthdate"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                    value="{{ old('birthdate') }}" required min="1900-01-01" max="2099-12-31" />
                  <x-form-error name="birthdate" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Contact Number</label>
                  <input type="text" name="contact_number"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 bg-gray-100"
                    placeholder="Contact number" value="{{ auth()->user()->contact_number }}" readonly required />
                  <x-form-error name="contact_number" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Residential Address</label>
                  <input type="text" name="address"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                    placeholder="Enter your address" value="{{ old('address') }}" required />
                  <x-form-error name="address" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Civil Status</label>
                  <select name="civil_status"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                    required>
                    <option value="" disabled {{ old('civil_status') ? '' : 'selected' }}>Select Civil Status</option>
                    <option value="Single" {{ old('civil_status')=='Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ old('civil_status')=='Married' ? 'selected' : '' }}>Married</option>
                    <option value="Divorced" {{ old('civil_status')=='Divorced' ? 'selected' : '' }}>Divorced</option>
                  </select>
                  <x-form-error name="civil_status" />
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600">Citizenship</label>
                  <input type="text" name="citizenship"
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                    placeholder="Enter your citizenship" value="{{ old('citizenship') }}" required />
                  <x-form-error name="citizenship" />
                </div>
              </div>

              <!-- Additional Information -->
              <div class="mb-4">
                <label class="text-sm font-medium text-gray-600">Why do you want to adopt a pet?</label>
                <textarea name="reason_for_adoption"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  rows="3" required>{{ old('reason_for_adoption') }}</textarea>
                <x-form-error name="reason_for_adoption" />
              </div>

              <div class="mb-4">
                <label class="text-sm font-medium text-gray-600">Do you visit a Veterinarian?</label>
                <select name="visit_veterinarian"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  required>
                  <option value="" disabled {{ old('visit_veterinarian') ? '' : 'selected' }}>Select an option</option>
                  <option value="Yes" {{ old('visit_veterinarian')=='Yes' ? 'selected' : '' }}>Yes</option>
                  <option value="No" {{ old('visit_veterinarian')=='No' ? 'selected' : '' }}>No</option>
                  <option value="Sometimes" {{ old('visit_veterinarian')=='Sometimes' ? 'selected' : '' }}>Sometimes
                  </option>
                </select>
                <x-form-error name="visit_veterinarian" />
              </div>

              <div class="mb-4">
                <label class="text-sm font-medium text-gray-600">Do you have any pet(s) in your house? How many?</label>
                <input type="number" name="existing_pets"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter number and type of pets (if any)" value="{{ old('existing_pets') }}" required />
                <x-form-error name="existing_pets" />
              </div>

              <div class="mb-4">
                <label class="text-sm font-medium text-gray-600">Upload Valid ID <span
                    class="text-red-600">*</span></label>
                <input type="file" name="valid_id"
                  class="w-full py-0 border rounded-lg file:bg-gray-400 file:border-0 file:text-white focus:border-black"
                  required />
                <x-form-error name="valid_id" />
                <details class="rounded-md text-sm text-gray-700 mt-2 mb-6">
                  <summary class="cursor-pointer font-medium text-orange-600 text-right ">Accepted Valid IDs</summary>
                  <div class="mt-2">
                    <strong>Primary IDs:</strong>
                    <ul class="list-disc list-inside ml-2">
                      <li>Philippine Identification (PhilID/ePhilID)</li>
                      <li>Passport</li>
                      <li>Driver's License</li>
                      <li>UMID</li>
                      <li>PRC ID</li>
                      <li>Voter's ID</li>
                    </ul>
                    <strong class="block mt-2">Secondary IDs:</strong>
                    <ul class="list-disc list-inside ml-2">
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
                </details>
              </div>

              <div class="mb-4">
                <div
                  class="w-full border border-gray-300 rounded-lg p-3 text-sm text-gray-900 bg-gray-100 min-h-[140px]">
                  I, <span id="inserted_name" class="font-semibold text-orange-600">[Your Full Name]</span>, do solemnly
                  swear, that I will take good care of my adopted pet, and he/she will not stray in the street again.
                  And,
                  that I will
                  take him/her to a Veterinarian for regular check-up and/or vaccination.
                  <br><br>
                  Issued this
                  <span id="oath_day" class="font-semibold text-orange-600">[Day]</span>
                  day of
                  <span id="oath_month" class="font-semibold text-orange-600">[Month]</span>,
                  20<span id="oath_year" class="font-semibold text-orange-600">[YY]</span>,
                  at the Angeles City Veterinary Office - Animal Shelter, Angeles City Pampanga.
                </div>
              </div>

              <div class="mb-4">
                <!-- Submit Button -->
                <button type="submit"
                  class="w-full mt-6 bg-orange-500 text-white font-medium rounded-full py-3 hover:bg-yellow-500 hover:text-black transition duration-300 flex items-center justify-center">
                  <i class="ph-fill ph-paw-print mr-2"></i> Adopt this {{ $pet->species === 'feline' ? 'Cat' : 'Dog' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- END OF THE SECTION -->

  <script>
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

    // ADOPTION PROCESS TABS
    document.addEventListener('DOMContentLoaded', function () {
      const tabButtons = document.querySelectorAll(".tab-btn");
      const tabContents = document.querySelectorAll(".tab-content");

      tabButtons.forEach(button => {
        button.addEventListener("click", () => {
          const tab = button.getAttribute("data-tab");

          // Remove active class from all buttons
          tabButtons.forEach(btn => btn.classList.remove("active", "bg-blue-100"));
          button.classList.add("active", "bg-blue-100");

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