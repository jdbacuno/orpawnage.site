<x-layout>
  <section class="relative w-full min-h-screen bg-cover bg-center flex items-center justify-center pt-20 pb-10"
    style="background-image: url('{{ asset('images/rescue.jpg') }}')">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- Centered Form Card -->
    <div
      class="relative z-10 w-full max-w-4xl bg-white/80 backdrop-blur-md rounded-xl shadow-xl border border-gray-200 p-8 sm:p-10 m-4">
      <h2 class="text-2xl sm:text-3xl font-bold text-black mb-6 text-left">
        Report an Incident of Abused/Stray Animal
      </h2>

      <!-- Success Alert -->
      @if(session('success'))
      <div id="alert-3" class="flex items-center px-4 py-2 mb-4 text-green-800 rounded-lg bg-green-50 w-full"
        role="alert">
        <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
        </svg>
        <div class="ms-3 text-sm font-medium">{!! session('success') !!}</div>
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

      <!-- Form Start -->
      <form id="reportForm" action="/report/abused-stray-animal" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <!-- Reporter Info -->
          <div class="space-y-2">
            <h3 class="text-sm font-semibold text-gray-500 mb-1">Reporter's Information</h3>
            <div>
              <label class="block text-gray-700 font-medium">Reporter's Name (Optional)</label>
              <input type="text" name="full_name" value="{{ old('full_name') }}"
                class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="Fullname (optional)" />
              <x-form-error name="full_name" />
            </div>
            <div>
              <label class="block font-medium text-gray-700">Contact No.</label>
              <input type="tel" name="contact_no" value="{{ auth()->user()->contact_number }}"
                class="w-full px-3 py-2 rounded-lg border text-gray-900 bg-gray-200" readonly required />
              <x-form-error name="contact_no" />
            </div>
            <div>
              <label class="block text-gray-700 font-medium">Location of Incident</label>
              <input type="text" name="incident_location" value="{{ old('incident_location') }}"
                class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="Location of Incident"
                required />
              <x-form-error name="incident_location" />
            </div>
            <div>
              <label class="block text-gray-700 font-medium">Date of Incident</label>
              <input type="date" name="incident_date" value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}"
                class="w-full px-3 py-2 rounded-lg border focus:border-black" required />
              <x-form-error name="incident_date" />
            </div>
          </div>

          <!-- Animal Info -->
          <div class="space-y-2">
            <h3 class="text-sm font-semibold text-gray-500 mb-1">Animal's Information</h3>
            <div>
              <label class="block text-gray-700 font-medium">Type of Animal</label>
              <input type="text" name="species" value="{{ old('species') }}"
                class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="e.g. dog, cat, monkey..."
                required />
              <x-form-error name="species" />
            </div>
            <div>
              <label class="block text-gray-700 font-medium">Condition of Animal</label>
              <input type="text" name="animal_condition" value="{{ old('animal_condition') }}"
                class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="Condition of Animal"
                required />
              <x-form-error name="animal_condition" />
            </div>
            <div>
              <label class="block text-gray-700 font-medium">Additional Notes</label>
              <textarea name="additional_notes" class="w-full px-3 py-2 rounded-lg border focus:border-black"
                placeholder="Additional notes" required>{{ old('additional_notes') }}</textarea>
              <x-form-error name="additional_notes" />
            </div>
            <div>
              <label class="block text-gray-700 font-medium">Upload a Photo of Proof (if there's any)</label>
              <input type="file" name="incident_photo" id="incident_photo"
                class="w-full py-0 border rounded-lg border focus:border-black file:bg-gray-400 file:border-0 file:text-white"
                required />
              <x-form-error name="incident_photo" />

              <!-- Image Preview -->
              <div class="mt-2">
                <img id="image_preview" src="#" alt="Image Preview"
                  class="hidden w-40 h-40 object-cover rounded border border-gray-300" />
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button type="submit"
            class="w-full md:w-auto bg-orange-600 text-white font-medium py-3 px-6 rounded-lg hover:bg-yellow-500 hover:text-black transition">
            Submit Report
          </button>
        </div>
      </form>
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