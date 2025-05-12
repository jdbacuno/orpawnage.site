<x-layout>
  <!-- ========== START OF MISSING PET REPORT SECTION ========== -->
  <section class="relative min-h-screen flex items-center justify-center mt-4 pt-20 pb-10">
    <!-- Background Image -->
    <div class="absolute inset-0">
      <img src="{{ asset('images/missing.jpeg') }}" alt="Missing Pet Background"
        class="w-full h-full object-cover brightness-75" />
    </div>

    <!-- Form Container -->
    <div class="relative z-10 w-full max-w-3xl mx-4">
      <div class="p-6 rounded-xl bg-gray-50/90 border border-gray-300 shadow-md backdrop-blur-sm">
        <!-- Alerts -->
        @if(session('success'))
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

        <h3 class="text-lg font-semibold text-gray-800 mb-6 pb-3 border-b border-gray-200 flex items-center">
          <i class="ph-fill ph-magnifying-glass mr-2 text-orange-500"></i>Missing Pet Report Form
        </h3>

        <form action="/report/missing-pet" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Add this note -->
          <div class="mb-6 p-4 bg-orange-50 border-l-4 border-orange-400 rounded-lg">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-orange-700">
                  <strong>Please note:</strong> Our team does not actively search for missing pets. Once your report is
                  reviewed and approved, it will be shared with other registered users on this website via email to help
                  spread awareness. You may also contact us through our official Facebook page, <strong>Angeles City
                    Veterinary
                    Office</strong>, to request that your missing pet poster be posted on their page.
                </p>
              </div>
            </div>
          </div>

          <!-- Two-column grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Owner Info -->
            <div>
              <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-user-circle mr-2"></i>Owner's Information
              </h4>

              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Owner's Name</label>
                  <input type="text" name="owner_name" value="{{ old('owner_name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Full name" required />
                  <x-form-error name="owner_name" />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Contact Number</label>
                  <input type="tel" name="contact_no" value="{{ old('contact_no') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Contact number" required />
                  <x-form-error name="contact_no" />
                </div>

                <!-- Added Valid ID Field -->
                <div>
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
            </div>

            <!-- Pet Info -->
            <div>
              <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-paw-print mr-2"></i>Pet's Information
              </h4>

              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Pet's Name</label>
                  <input type="text" name="pet_name" value="{{ old('pet_name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Pet's name" required />
                  <x-form-error name="pet_name" />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Last Seen Location</label>
                  <input type="text" name="last_seen_location" value="{{ old('last_seen_location') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Location" required />
                  <x-form-error name="last_seen_location" />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Last Seen Date</label>
                  <input type="date" name="last_seen_date" value="{{ old('last_seen_date') }}" max="{{ date('Y-m-d') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    required />
                  <x-form-error name="last_seen_date" />
                </div>
              </div>
            </div>
          </div>

          <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
              <i class="ph-fill ph-note-pencil mr-2"></i>Additional Details
            </h4>

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Pet Description</label>
                <textarea name="pet_description"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  rows="4" placeholder="Breed, color, distinguishing marks, etc."
                  required>{{ old('pet_description') }}</textarea>
                <x-form-error name="pet_description" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Upload Pet's Photo <span
                    class="text-red-500">*</span></label>
                <input type="file" name="pet_photo"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                  required />
                <x-form-error name="pet_photo" />
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button type="submit"
              class="w-full sm:w-fit px-5 mt-2 bg-orange-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <i class="ph-fill ph-paper-plane-tilt mr-2"></i>Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- ========== END OF MISSING PET REPORT SECTION ========== -->

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
</x-layout>