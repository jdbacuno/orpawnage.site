<x-layout>
  <!-- START OF THE SECTION -->
  <section class="py-20 bg-white">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <!-- Pet Header -->
      <div class="flex flex-wrap justify-between items-center gap-3 mt-2 mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
          {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
        </h2>
        <span class="bg-yellow-500 text-black py-1 px-3 rounded-full text-2xl font-bold shadow-sm">
          {{ $pet->species === 'feline' ? '🐱 Cat' : '🐶 Dog' }} #{{ $pet->pet_number }}
        </span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start mb-4">
        <!-- LEFT SIDE: Pet Image -->
        <div class="overflow-hidden rounded-lg shadow-md h-fit">
          <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
            class="w-full h-auto max-h-[500px] object-cover transition-transform duration-500 hover:scale-105" />
        </div>

        <!-- RIGHT SIDE: Pet Information Card (fixed height) -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm h-fit">
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

      <!-- Bottom: Adoption Form -->
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

        <h3 class="text-lg font-semibold text-gray-800 mb-6 pb-3 border-b border-gray-200 flex items-center">
          <i class="ph-fill ph-clipboard-text mr-2 text-orange-500"></i>Adoption Application Form
        </h3>

        <form method="POST" action="/services/{{ $pet->slug }}/adoption-form" id="applicationForm"
          enctype="multipart/form-data">
          @csrf

          <!-- Personal Information -->
          <div class="mb-6">
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
                  placeholder="Your contact number" value="{{ auth()->user()->contact_number }}" readonly required />
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

          <!-- Pet Information + Documentation + Oath -->
          <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
              <i class="ph-fill ph-paw-print mr-2"></i>Pet Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

              <!-- Left Column: Reason -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Why do you want to adopt?</label>
                <textarea name="reason_for_adoption"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  rows="10" placeholder="Explain why you want to adopt this pet"
                  required>{{ old('reason_for_adoption') }}</textarea>
                <x-form-error name="reason_for_adoption" />
              </div>

              <!-- Right Column: Veterinarian + Existing Pets + Docs + Oath -->
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

                <!-- Documentation -->
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Upload Valid ID <span
                      class="text-red-500">*</span></label>
                  <input type="file" name="valid_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                    required />
                  <x-form-error name="valid_id" />
                  <details class="rounded-md text-sm text-gray-600 mt-2">
                    <summary class="cursor-pointer font-medium text-orange-600">Accepted Valid IDs</summary>
                    <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                      <strong>Primary IDs:</strong>
                      <ul class="list-disc list-inside ml-4 mt-1">
                        <li>Philippine Identification (PhilID/ePhilID)</li>
                        <li>Passport</li>
                        <li>Driver's License</li>
                        <li>UMID</li>
                        <li>PRC ID</li>
                        <li>Voter's ID</li>
                      </ul>
                      <strong class="block mt-2">Secondary IDs:</strong>
                      <ul class="list-disc list-inside ml-4 mt-1">
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

                <!-- Oath Declaration -->
                <div class="p-4 bg-orange-50 rounded-lg border border-orange-100">
                  <h4 class="text-sm font-medium text-orange-800 mb-2 flex items-center">
                    <i class="ph-fill ph-hand-soap mr-2"></i>Oath Declaration
                  </h4>
                  <div class="text-sm text-gray-700 leading-relaxed">
                    I, <span id="inserted_name" class="font-semibold text-orange-600">[Your Full Name]</span>, do
                    solemnly
                    swear that I will take good care of my adopted pet, and he/she will not stray in the street again. I
                    will take him/her to a veterinarian for regular check-ups and/or vaccination.
                    <br><br>
                    Issued this <span id="oath_day" class="font-semibold text-orange-600">[Day]</span> day of <span
                      id="oath_month" class="font-semibold text-orange-600">[Month]</span>, 20<span id="oath_year"
                      class="font-semibold text-orange-600">[YY]</span>, at the Angeles City Veterinary Office - Animal
                    Shelter, Angeles City Pampanga.
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button type="submit"
              class="w-full sm:w-fit px-5 mt-2 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-500 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <i class="ph-fill ph-paw-print mr-2"></i>Submit Adoption Request
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>

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
  </script>
</x-layout>