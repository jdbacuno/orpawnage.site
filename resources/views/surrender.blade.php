<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative h-[70vh] min-h-[500px] flex items-center justify-center bg-gray-900 overflow-hidden"
    id="mainContent">
    <!-- Background image with darker overlay -->
    <div class="absolute inset-0 w-full h-full">
      <img src="{{ asset('images/surrender.jpg') }}" alt="Adopt a Pet"
        class="w-full h-full object-cover object-center brightness-50" />
      <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <!-- Content container -->
    <div class="container mx-auto px-6 sm:px-8 relative z-10 text-center">
      <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
          <span class="block">Rehome. Surrender. Rescue.</span>
          <span class="text-yellow-400 block">We're Here to Help</span>
        </h1>

        <p class="text-lg sm:text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
          Whether you're rehoming a pet, surrendering any animal, or getting an animal
          rescued, we're here to help.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4" id="scrollIntoNextSection">
          <a href="#elementToScrollInto"
            class="px-8 py-3 bg-white/10 hover:bg-yellow-500/20 text-black text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center border border-white/20">
            <i class="ph-fill ph-arrow-circle-down mr-2"></i>Start the Process
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF RESPONSIVE TEXT SECTION ========== -->
  <section class="bg-gray-100 pt-12 pb-6 px-6 sm:px-8" id="startTheProcess">
    <div class="max-w-5xl mx-auto text-center mb-10">
      <h2 class="text-3xl sm:text-4xl font-bold text-gray-800">Need Help With an Animal?</h2>
      <p class="mt-4 text-gray-600">Whether you're rehoming a pet, surrendering any animal, or getting an animal
        rescued, we're here to help.</p>
    </div>

    <div class="grid sm:grid-cols-2 gap-6 max-w-4xl mx-auto">
      <!-- Rehome Card -->
      <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col items-center text-center">
        <div class="bg-yellow-100 text-yellow-500 rounded-full p-3 mb-4">
          <!-- Heroicon: Home -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5M9 21V12h6v9" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Rehome a Pet</h3>
        <p class="text-gray-600">
          Can't care for your pet anymore? We'll help find them a loving new home or proper shelter care.
        </p>
      </div>

      <!-- Surrender Card -->
      <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col items-center text-center">
        <div class="bg-yellow-100 text-yellow-500 rounded-full p-3 mb-4">
          <!-- Heroicon: Paw Print -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4.5 12.5a1.5 1.5 0 112.9-.8 1.5 1.5 0 01-2.9.8zm14.5 0a1.5 1.5 0 10-2.9-.8 1.5 1.5 0 002.9.8zM8 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm8 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm-4 10c3 0 5-2 5-3.5S15 12 12 12s-5 1.5-5 2.5S9 18 12 18z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Surrender an Animal</h3>
        <p class="text-gray-600">
          Have a wild or stray animal? Our team can take them in and provide care and rehabilitation.
        </p>
      </div>
    </div>
  </section>
  <!-- ========== END OF RESPONSIVE TEXT SECTION ========== -->

  <!-- ========== START OF SURRENDER REQUEST FORM SECTION ========== -->
  <section class="pt-6 pb-10 px-4 sm:px-6 relative overflow-hidden bg-gray-100">
    <div class="max-w-4xl mx-auto">
      <div class="rounded-xl bg-white border border-gray-200 p-6 sm:p-8 shadow-md">
        <!-- Form Header -->
        <div class="mb-8">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 flex items-center">
            <i class="ph-fill ph-clipboard-text mr-2 text-orange-500"></i>Surrender/Rehome Application Form
          </h2>
          <p class="text-gray-600">Please fill out all required fields to submit your surrender request.</p>
        </div>

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

        <form method="POST" action="/services/surrender" id="surrenderForm" enctype="multipart/form-data"
          class="space-y-8">
          @csrf

          <!-- Surrenderer's Information -->
          <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-user-circle mr-2"></i>Surrenderer's Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="surrenderer-name" class="block text-sm font-medium text-gray-700 mb-1">
                  Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="surrenderer-name" name="full_name" placeholder="Enter your full name"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('full_name', auth()->user()->full_name ?? '') }}" required />
                <x-form-error name="full_name" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Email
                </label>
                <input type="email" name="email"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100"
                  value="{{ auth()->user()->email }}" readonly required />
                <x-form-error name="email" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Birthdate <span class="text-red-500">*</span>
                </label>
                <input type="date" name="birthdate" id="birthdate"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('birthdate') }}" required max="{{ date('Y-m-d') }}"
                  onchange="calculateAge(this.value)" />
                <x-form-error name="birthdate" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Age
                </label>
                <input type="number" name="age" id="age"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100"
                  placeholder="Auto-calculated" value="{{ old('age') }}" readonly required />
                <x-form-error name="age" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Contact Number <span class="text-red-500">*</span>
                </label>
                <input type="text" name="contact_number"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100"
                  value="{{ auth()->user()->contact_number ?: 'Not Set (Please update in Account Settings)' }}" readonly
                  required />
                <x-form-error name="contact_number" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Address <span class="text-red-500">*</span>
                </label>
                <input type="text" name="address"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your residential address" value="{{ old('address') }}" required />
                <x-form-error name="address" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Civil Status <span class="text-red-500">*</span>
                </label>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Citizenship <span class="text-red-500">*</span>
                </label>
                <input type="text" name="citizenship"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your citizenship" value="{{ old('citizenship') }}" required />
                <x-form-error name="citizenship" />
              </div>
            </div>
          </div>

          <!-- Animal's Information -->
          <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-paw-print mr-2"></i>Animal's Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                  Animal's Name (Optional)
                </label>
                <input type="text" id="name" name="pet_name" placeholder="Enter the animal's name"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('pet_name') }}" />
                <x-form-error name="pet_name" />
              </div>

              <div>
                <label for="species" class="block text-sm font-medium text-gray-700 mb-1">
                  Species <span class="text-red-500">*</span>
                </label>
                <input type="text" id="species" name="species" placeholder="Enter the type of animal"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('pet_name') }}" />
                <x-form-error name="species" />
              </div>

              <div>
                <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">
                  Breed (Optional)
                </label>
                <input type="text" id="breed" name="breed" placeholder="Enter the breed if known"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('breed') }}" />
                <x-form-error name="breed" />
              </div>

              <div>
                <label for="sex" class="block text-sm font-medium text-gray-700 mb-1">
                  Sex <span class="text-red-500">*</span>
                </label>
                <select id="sex" name="sex"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="" disabled selected>Select the sex</option>
                  <option value="Male" {{ old('sex')=='Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ old('sex')=='Female' ? 'selected' : '' }}>Female</option>
                  <option value="Unknown" {{ old('sex')=='Unknown' ? 'selected' : '' }}>Unknown</option>
                </select>
                <x-form-error name="sex" />
              </div>

              <div class="md:col-span-2">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">
                  Reason for Surrendering <span class="text-red-500">*</span>
                </label>
                <textarea id="reason" name="reason" placeholder="Please explain why you're surrendering this animal"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  rows="4" required>{{ old('reason') }}</textarea>
                <x-form-error name="reason" />
              </div>
            </div>
          </div>

          <!-- Documentation -->
          <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-file mr-2"></i>Documentation
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <!-- Valid ID Upload -->
                <div class="mb-4">
                  <div class="flex justify-between items-center mb-1">
                    <label class="block text-sm font-medium text-gray-600">Upload Valid ID <span
                        class="text-red-500">*</span></label>
                    <button type="button" onclick="openValidIdModal()"
                      class="text-sm text-orange-600 hover:text-orange-700 font-medium cursor-pointer">
                      View Accepted Valid IDs
                    </button>
                  </div>
                  <input type="file" name="valid_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                    required />
                  <x-form-error name="valid_id" />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Animal Photos (Max 5) <span class="text-red-500">*</span>
                </label>

                <!-- Hidden Input -->
                <input type="file" name="animal_photos[]" id="animal_photos_input" multiple accept="image/*"
                  class="hidden" required />

                <!-- Preview Container -->
                <div id="animalPhotosPreviews" class="my-2 grid grid-cols-3 gap-2"></div>

                <!-- Add More Button -->
                <button type="button" id="addAnimalPhotosBtn"
                  class="px-4 py-2 bg-orange-100 text-orange-700 text-sm font-medium rounded-md border border-orange-300 hover:bg-orange-200 transition w-fit flex items-center gap-2">
                  <i class="ph-fill ph-plus-circle"></i> Add Animal Photos
                </button>

                <p class="text-xs text-gray-500 mt-1">Please upload clear photos of the animal you're surrendering.</p>
                <x-form-error name="animal_photos" />
              </div>
            </div>
          </div>

          <!-- Declaration -->
          <div class="p-4 bg-orange-50 rounded-lg border border-orange-100">
            <h4 class="text-sm font-medium text-orange-800 mb-2 flex items-center">
              <i class="ph-fill ph-hand-palm mr-2"></i>Declaration
            </h4>
            <div class="text-sm text-gray-700 leading-relaxed">
              <p class="mb-3">I certify that the information provided in this surrender form is true and accurate to the
                best of my knowledge.</p>
              <p>I understand that by surrendering this animal, I am transferring all rights of ownership to the
                shelter, and I will not be able to reclaim the animal once the surrender process is complete.</p>
            </div>
            <div class="mt-4 flex items-center">
              <input type="checkbox" id="declaration" name="declaration" required
                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded" checked>
              <label for="declaration" class="ml-2 block text-sm text-gray-700">
                I agree to the terms above <span class="text-red-500">*</span>
              </label>
            </div>
            <x-form-error name="declaration" />
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button type="submit"
              class="w-full sm:w-fit px-8 py-3 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                  clip-rule="evenodd" />
              </svg>
              Submit Surrender Request
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- ========== END OF SURRENDER REQUEST FORM SECTION ========== -->

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

  <script>
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
    }
    
    // Calculate age if birthdate exists on page load
    document.addEventListener('DOMContentLoaded', function() {
      const birthdate = document.getElementById('birthdate').value;
      if (birthdate) {
        calculateAge(birthdate);
      }
    });

    function openValidIdModal() {
      document.getElementById('validIdModal').classList.remove('hidden');
    }

    function closeValidIdModal() {
      document.getElementById('validIdModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
      function updateHeaderSpacer() {
        const header = document.getElementById('main-header');
        const mainContent = document.getElementById('mainContent');
        
        if (header && mainContent) {
          const headerHeight = header.offsetHeight;
          mainContent.style.marginTop = `${headerHeight}px`;
        }
      }
    
      // Initial update
      updateHeaderSpacer();
    
      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);
    });

    // Scroll to form section when clicking "Start the Process" button
    document.addEventListener('DOMContentLoaded', function () {
      const scrollButtons = document.querySelectorAll('[href="#elementToScrollInto"]');
      const elementToScrollInto = document.getElementById('startTheProcess');

      scrollButtons.forEach(button => {
        button.addEventListener('click', function (e) {
          e.preventDefault();
          
          if (elementToScrollInto) {
            const offset = window.innerHeight * 0.1; // 10% of viewport height
            const elementPosition = elementToScrollInto.getBoundingClientRect().top + window.scrollY;
            
            window.scrollTo({
              top: elementPosition - offset,
              behavior: 'smooth'
            });
          }
        });
      });
    });

     // Function to handle image uploads and previews
    function setupImageUpload(inputId, previewContainerId, addButtonId, maxFiles = 5) {
      const input = document.getElementById(inputId);
      const previewContainer = document.getElementById(previewContainerId);
      const addMoreBtn = document.getElementById(addButtonId);
      const dataTransfer = new DataTransfer();

      addMoreBtn.addEventListener('click', () => input.click());

      input.addEventListener('change', (event) => {
        const newFiles = Array.from(event.target.files);

        if (dataTransfer.files.length + newFiles.length > maxFiles) {
          alert(`You can upload a maximum of ${maxFiles} images.`);
          return;
        }

        newFiles.forEach((file, index) => {
          if (!file.type.match('image.*')) return;

          const reader = new FileReader();
          reader.onload = function (e) {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'relative';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'h-24 w-full object-cover rounded-lg border border-gray-300';

            const removeBtn = document.createElement('i');
            removeBtn.className = 'absolute top-[-3px] right-[-1px] text-white rounded-full p-1 text-sm ph-fill ph-x-circle hover:text-red-400 cursor-pointer';
            removeBtn.onclick = function () {
              previewDiv.remove();

              // Remove from DataTransfer
              const updated = new DataTransfer();
              for (let i = 0; i < dataTransfer.items.length; i++) {
                if (dataTransfer.items[i].getAsFile() !== file) {
                  updated.items.add(dataTransfer.items[i].getAsFile());
                }
              }

              dataTransfer.items.clear();
              for (let i = 0; i < updated.items.length; i++) {
                dataTransfer.items.add(updated.items[i].getAsFile());
              }

              input.files = dataTransfer.files;
            };

            previewDiv.appendChild(img);
            previewDiv.appendChild(removeBtn);
            previewContainer.appendChild(previewDiv);
          };
          reader.readAsDataURL(file);

          dataTransfer.items.add(file);
        });

        input.files = dataTransfer.files;
      });
    }

    // Initialize the animal photos upload field
    document.addEventListener('DOMContentLoaded', function() {
      setupImageUpload('animal_photos_input', 'animalPhotosPreviews', 'addAnimalPhotosBtn');
      
      // Keep your existing initialization code
      const birthdate = document.getElementById('birthdate').value;
      if (birthdate) {
        calculateAge(birthdate);
      }
    });
  </script>
</x-layout>