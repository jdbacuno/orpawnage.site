<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="h-screen flex items-center bg-gradient-to-r from-orange-50 to-yellow-50 sm:bg-none relative">
    <!-- Mobile background image -->
    <div class="sm:hidden absolute inset-0 w-full h-full overflow-hidden">
      <img src="{{ asset('images/surrender.jpg') }}" alt="Adopt a Pet"
        class="w-full h-full object-cover brightness-50" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 w-full h-full container mx-auto relative z-10">
      <!-- LEFT SIDE: Pet Image (Desktop only) -->
      <div class="h-full w-full overflow-hidden hidden sm:block">
        <img src="{{ asset('images/surrender.jpg') }}" alt="Adopt a Pet"
          class="w-full h-full object-cover object-center" />
      </div>

      <!-- RIGHT SIDE: Slogan and CTA -->
      <div class="flex flex-col justify-center items-start px-6 sm:px-12 lg:px-16 py-12 sm:py-0">
        <h1 class="text-2xl sm:text-5xl lg:text-4xl font-bold leading-tight tracking-tight">
          <span class="text-white sm:text-gray-800 block mb-2 sm:mb-3">Can't care for your pet anymore?</span>
          <span class="text-yellow-300 sm:text-yellow-500 block mb-6 sm:mb-8 animate-pulse">Rehome.</span>

          <span class="text-white sm:text-gray-800 block mb-2 sm:mb-3">Have a wild or stray animal?</span>
          <span class="text-yellow-300 sm:text-yellow-500 block animate-pulse">Surrender.</span>
        </h1>

        <p class="mt-8 text-lg sm:text-xl text-white/90 sm:text-gray-600 max-w-lg leading-relaxed">
          Find your pet a new family to love or surrender stray animals to our care.
        </p>

        <div class="mt-10 flex flex-col sm:flex-row gap-4 cursor-pointer" id="scrollIntoNextSection">
          <a
            class="px-8 py-3 bg-yellow-400 hover:bg-yellow-500 text-black font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                clip-rule="evenodd" />
            </svg> Rehome or Surrender
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF RESPONSIVE TEXT SECTION ========== -->
  <section class="bg-gray-100 pt-12 pb-6 px-6 sm:px-8" id="elementToScrollInto">
    <div class="max-w-5xl mx-auto text-center mb-10">
      <h2 class="text-3xl sm:text-4xl font-bold text-gray-800">Need Help With an Animal?</h2>
      <p class="mt-4 text-gray-600">Whether you're rehoming a pet or surrendering a stray, we're here to help.</p>
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
          Can't care for your pet anymore? We’ll help find them a loving new home or proper shelter care.
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

        <form action="#" method="POST" class="space-y-8" id="surrenderForm">
          <!-- Surrenderer's Information -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-user-circle mr-2"></i>Surrenderer's Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="surrenderer-name" class="block text-sm font-medium text-gray-700 mb-1">
                  Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="surrenderer-name" name="surrenderer_name" placeholder="Enter your full name"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required />
              </div>

              <div>
                <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">
                  Contact No. <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="contact" name="contact_no" placeholder="Enter your contact number"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required />
              </div>

              <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                  Address <span class="text-red-500">*</span>
                </label>
                <input type="text" id="address" name="address" placeholder="Enter your complete address"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required />
              </div>
            </div>
          </div>

          <!-- Animal's Information -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-paw-print mr-2"></i>Animal's Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                  Animal's Name (Optional)
                </label>
                <input type="text" id="name" name="name" placeholder="Enter the animal's name"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400" />
              </div>

              <div>
                <label for="species" class="block text-sm font-medium text-gray-700 mb-1">
                  Species <span class="text-red-500">*</span>
                </label>
                <input type="text" id="species" name="species" placeholder="Dog, Cat, Bird, etc."
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required />
              </div>

              <div>
                <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">
                  Breed (Optional)
                </label>
                <input type="text" id="breed" name="breed" placeholder="Enter the breed if known"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400" />
              </div>

              <div>
                <label for="sex" class="block text-sm font-medium text-gray-700 mb-1">
                  Sex <span class="text-red-500">*</span>
                </label>
                <select id="sex" name="sex"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="" disabled selected>Select the sex</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Unknown">Unknown</option>
                </select>
              </div>

              <div class="md:col-span-2">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">
                  Reason for Surrendering <span class="text-red-500">*</span>
                </label>
                <textarea id="reason" name="reason" placeholder="Please explain why you're surrendering this animal"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  rows="4" required></textarea>
              </div>
            </div>
          </div>

          <!-- Documentation -->
          <div class="space-y-6">
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
                  Latest Animal Photo <span class="text-red-500">*</span>
                </label>
                <input type="file" name="animal_photo" accept="image/*"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                  required />
                <p class="text-xs text-gray-500 mt-1">Please upload a clear photo of the animal you're surrendering.</p>
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
                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
              <label for="declaration" class="ml-2 block text-sm text-gray-700">
                I agree to the terms above <span class="text-red-500">*</span>
              </label>
            </div>
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
    document.addEventListener('DOMContentLoaded', function () {
      const scrollIntoNextSection = document.getElementById('scrollIntoNextSection');
      const elementToScrollInto = document.getElementById('elementToScrollInto');

      scrollIntoNextSection.addEventListener('click', function () {
        const offset = window.innerHeight * 0.1; // 10% of the viewport height
        const elementPosition = elementToScrollInto.getBoundingClientRect().top + window.scrollY;

        window.scrollTo({
          top: elementPosition - offset,
          behavior: 'smooth'
        });
      });
    });
  </script>
</x-layout>