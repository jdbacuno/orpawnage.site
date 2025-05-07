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
          <span class="text-white sm:text-gray-800 block mb-2 sm:mb-3">E mu ne agyung sesen?</span>
          <span class="text-yellow-300 sm:text-yellow-500 block mb-6 sm:mb-8 animate-pulse">Ipa-adopt mu kekami.</span>

          <span class="text-white sm:text-gray-800 block mb-2 sm:mb-3">Atin kang arakap a aliwang ayup?</span>
          <span class="text-yellow-300 sm:text-yellow-500 block animate-pulse">Pwede meng i-surrender.</span>
        </h1>

        <p class="mt-8 text-lg sm:text-xl text-white/90 sm:text-gray-600 max-w-lg leading-relaxed">
          Find your pet a new family to love or surrender stray animals to our care.
        </p>

        <div class="mt-10 flex flex-col sm:flex-row gap-4">
          <a href="#surrenderForm"
            class="px-8 py-3 bg-yellow-500 hover:bg-yellow-400 text-black font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center">
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
  <section class="bg-gray-50 py-6 sm:py-10 px-6 sm:px-10">
    <div class="max-w-4xl mx-auto">
      <div class="text-3xl md:text-4xl font-bold text-left text-gray-900 mb-8 space-y-2">
        <h2 class="text-gray-800">Can no longer take care of a pet? <span class="text-yellow-500">Rehome.</span>
        </h2>
        <h2 class="text-gray-800">In possession of a wild or stray animal? <span
            class="text-yellow-500">Surrender.</span></h2>
      </div>
      <div class="prose prose-lg text-gray-700">
        <p>
          We understand that circumstances change, and sometimes pet owners can no longer provide the care their animals
          need.
          Our surrender program ensures these pets find new loving homes or receive proper care in our shelter.
        </p>
        <p>
          If you've found a stray animal or have a wild animal in your possession, our trained staff can safely take
          them in
          and provide the necessary medical care and rehabilitation.
        </p>
      </div>
    </div>
  </section>
  <!-- ========== END OF RESPONSIVE TEXT SECTION ========== -->

  <!-- ========== START OF SURRENDER REQUEST FORM SECTION ========== -->
  <section class="pt-6 pb-10 px-4 sm:px-6 relative overflow-hidden bg-gray-50" id="surrenderForm">
    <div class="max-w-4xl mx-auto">
      <div class="rounded-xl bg-white border border-gray-200 p-6 sm:p-8 shadow-sm">
        <!-- Form Header -->
        <div class="mb-8">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500 mr-2" viewBox="0 0 24 24"
              fill="currentColor">
              <path
                d="M19 7h-.82l-1.7-4.68A2.008 2.008 0 0 0 14.6 1H12v2h2.6l1.46 4h-4.94l-1.13-3.1-.79-2.2A2.008 2.008 0 0 0 7.6 1H5v2h2.6l.8 2.2L9.6 7H4.6L3.4 4.2 2.6 2H0v2h2.4l4 11H3v3h1c0 1.66 1.34 3 3 3s3-1.34 3-3h5c0 1.66 1.34 3 3 3s3-1.34 3-3h3v-3h-3.4l.8-2H19v-3h-2v3h-1.6l-4-11H19V7zm-9 11H8c0 .55-.45 1-1 1s-1-.45-1-1H5v-1h5v1zm5 0h-3v-1h3v1zm0-2H7.4l-.8-2h12.8l-.8 2z" />
            </svg>
            Surrender Request Form
          </h2>
          <p class="text-gray-600">Please fill out all required fields to submit your surrender request.</p>
        </div>

        <form action="#" method="POST" class="space-y-8">
          <!-- Surrenderer's Information -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
              </svg>
              Surrenderer's Information
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
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z"
                  clip-rule="evenodd" />
              </svg>
              Animal's Information
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
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                  clip-rule="evenodd" />
              </svg>
              Documentation
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Upload Valid ID <span class="text-red-500">*</span>
                </label>
                <input type="file" name="valid_id"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                  required />
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

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Animal Photo <span class="text-red-500">*</span>
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
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                  clip-rule="evenodd" />
              </svg>
              Declaration
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
              class="w-full sm:w-fit px-8 py-3 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-500 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
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
</x-layout>