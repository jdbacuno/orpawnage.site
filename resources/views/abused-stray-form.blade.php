<x-layout>
  <section class="relative w-full min-h-screen bg-cover bg-center flex items-center justify-center pt-20 pb-10"
    style="background-image: url('{{ asset('images/rescue.jpg') }}')">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- Centered Form Card -->
    <div class="relative z-10 w-full max-w-4xl m-4">
      <div class="p-6 rounded-xl bg-gray-50/90 border border-gray-300 shadow-md backdrop-blur-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-6 pb-3 border-b border-gray-200 flex items-center">
          <i class="ph-fill ph-warning-circle mr-2 text-orange-500"></i>Report an Incident of Abused/Stray Animal
        </h3>

        <!-- Success Alert -->
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

        <!-- Form Start -->
        <form id="reportForm" action="/report/abused-stray-animal" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-6">
            <!-- Reporter Information -->
            <div class="mb-6">
              <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-user-circle mr-2"></i>Reporter's Information
              </h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Full Name (Optional)</label>
                  <input type="text" name="full_name" value="{{ old('full_name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Your full name" />
                  <x-form-error name="full_name" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Contact Number</label>
                  <input type="tel" name="contact_no" value="{{ auth()->user()->contact_number }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100" readonly
                    required />
                  <x-form-error name="contact_no" />
                </div>
              </div>
            </div>

            <!-- Incident Information -->
            <div class="mb-6">
              <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-map-pin mr-2"></i>Incident Information
              </h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Location of Incident</label>
                  <input type="text" name="incident_location" value="{{ old('incident_location') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Where the incident occurred" required />
                  <x-form-error name="incident_location" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Date of Incident</label>
                  <input type="date" name="incident_date" value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    required />
                  <x-form-error name="incident_date" />
                </div>
              </div>
            </div>

            <!-- Animal Information -->
            <div class="mb-6">
              <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-paw-print mr-2"></i>Animal Information
              </h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Type of Animal</label>
                  <input type="text" name="species" value="{{ old('species') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="e.g. dog, cat, monkey..." required />
                  <x-form-error name="species" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Condition of Animal</label>
                  <input type="text" name="animal_condition" value="{{ old('animal_condition') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    placeholder="Animal's current condition" required />
                  <x-form-error name="animal_condition" />
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-600 mb-1">Additional Notes</label>
                  <textarea name="additional_notes"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    rows="4" placeholder="Provide additional details about the incident"
                    required>{{ old('additional_notes') }}</textarea>
                  <x-form-error name="additional_notes" />
                </div>
              </div>
            </div>

            <!-- Photo Upload -->
            <div class="mb-6">
              <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                <i class="ph-fill ph-camera mr-2"></i>Photo Evidence
              </h4>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Upload Photo of Incident</label>
                <input type="file" name="incident_photo" id="incident_photo"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                  required />
                <x-form-error name="incident_photo" />

                <!-- Image Preview -->
                <div class="mt-3">
                  <img id="image_preview" src="#" alt="Image Preview"
                    class="hidden max-w-full h-48 object-contain rounded-lg border border-gray-300" />
                </div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button type="submit"
              class="w-full sm:w-fit px-5 mt-2 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-500 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <i class="ph-fill ph-warning mr-2"></i>Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- JavaScript for Image Preview -->
  <script>
    document.getElementById('incident_photo').addEventListener('change', function (event) {
      const preview = document.getElementById('image_preview');
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
      } else {
        preview.src = '#';
        preview.classList.add('hidden');
      }
    });
  </script>
</x-layout>