<x-layout>
  <!-- ========== START OF SECTION ========== -->
  <section class="flex flex-col md:flex-row gap-x-6 min-h-screen pt-10 sm:pt-2">
    <!-- Left Side: Form -->
    <div class="w-full md:w-1/2 flex justify-center items-center px-2 pt-6 sm:p-4">
      <div class="max-w-2xl w-full bg-white p-6">
        <h2 class="text-3xl font-bold text-orange-400 mb-6 text-left">
          Report an Incident of Abused/Stray Animal
        </h2>
        <form action="/admin/abused-or-stray-pets" method="POST" enctype="multipart/form-data">
          @csrf

          @if(session('success'))
          <div id="alert-3"
            class="flex items-center px-4 py-2 mb-1 text-green-800 rounded-lg bg-green-50 sm:col-span-7 success w-full"
            role="alert">
            <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
            </svg>
            <div class="ms-3 text-sm font-medium">
              {{ session('success') }}
            </div>
            <button type="button"
              class="ms-auto bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
              data-dismiss-target="#alert-3" aria-label="Close">
              <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          <!-- Two-column layout -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Reporter's Info -->
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-500 mb-1">Reporter's Information</h3>

              <div>
                <label class="block text-gray-700 font-medium">Reporter's Name (Optional)</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}"
                  class="w-full p-3 border rounded-md focus:border-orange-500" placeholder="Fullname (optional)" />
                <x-form-error name="full_name" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Contact No.</label>
                <input type="tel" name="contact_no" value="{{ old('contact_no') }}"
                  class="w-full p-3 border rounded-md focus:border-orange-500" placeholder="Contact number" required />
                <x-form-error name="contact_no" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Location of Incident</label>
                <input type="text" name="incident_location" value="{{ old('incident_location') }}"
                  class="w-full p-3 border rounded-md focus:border-orange-500" placeholder="Location of Incident"
                  required />
                <x-form-error name="incident_location" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Date of Incident</label>
                <input type="date" name="incident_date" value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}"
                  class="w-full p-3 border rounded-md focus:border-orange-500" required />
                <x-form-error name="incident_date" />
              </div>
            </div>

            <!-- Animal Info -->
            <div class="space-y-4">
              <h3 class="text-sm font-semibold text-gray-500 mb-1">Animal's Information</h3>

              <div>
                <label class="block text-gray-700 font-medium">Type of Animal</label>
                <input type="text" name="species" value="{{ old('species') }}"
                  class="w-full p-3 border rounded-md focus:border-orange-500" placeholder="e.g. dog, cat, monkey..."
                  required />
                <x-form-error name="species" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Condition of Animal</label>
                <input type="text" name="animal_condition" value="{{ old('animal_condition') }}"
                  class="w-full p-3 border rounded-md focus:border-orange-500" placeholder="Condition of Animal"
                  required />
                <x-form-error name="animal_condition" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Additional Notes</label>
                <textarea name="additional_notes" class="w-full p-3 border rounded-md focus:border-orange-500"
                  placeholder="Additional notes" required>{{ old('additional_notes') }}</textarea>
                <x-form-error name="additional_notes" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Upload a Photo of Proof (if there's any)</label>
                <input type="file" name="incident_photo"
                  class="w-full py-0 border rounded-md focus:border-orange-500 file:bg-gray-400 file:border-0 file:text-white"
                  required />
                <x-form-error name="incident_photo" />
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-center md:justify-end">
            <button type="submit"
              class="w-full md:w-auto bg-orange-400 text-white font-medium py-3 px-6 rounded-md hover:bg-yellow-500 transition">
              Submit Report
            </button>
          </div>
        </form>

      </div>
    </div>

    <!-- Right Side: Full-Screen Image -->
    <div class="w-full md:w-1/2">
      <img src="{{ asset('images/black-dog.jpg') }}" alt="Missing Pet" class="w-full h-full object-cover" />
    </div>
  </section>
  <!-- ========== END OF SECTION ========== -->
</x-layout>