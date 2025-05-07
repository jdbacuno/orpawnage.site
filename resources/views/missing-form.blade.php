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
              class="w-full sm:w-fit px-5 mt-2 bg-orange-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-yellow-500 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <i class="ph-fill ph-paper-plane-tilt mr-2"></i>Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- ========== END OF MISSING PET REPORT SECTION ========== -->
</x-layout>