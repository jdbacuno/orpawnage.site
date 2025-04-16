<x-layout>
  <!-- ========== START OF SECTION ========== -->
  <section class="bg-yellow-500/30 flex flex-col md:flex-row gap-x-6 min-h-screen pt-10 sm:pt-2">
    <!-- Left Side: Form -->
    <div class="w-full md:w-1/2 flex justify-center items-center px-2 pt-6 sm:p-4">
      <div class="max-w-2xl w-full p-6">
        <h2 class="text-3xl font-bold text-black mb-6 text-left">
          Report a Missing Pet
        </h2>
        <form action="/report/missing-pet" method="POST" enctype="multipart/form-data">
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
              {!! session('success') !!}
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
            <!-- Owner's Info -->
            <div class="space-y-2">
              <h3 class="text-sm font-semibold text-gray-500 mb-1">Owner's Information</h3>

              <div>
                <label class="block text-gray-700 font-medium">Owner's Name</label>
                <input type="text" name="owner_name" value="{{ old('owner_name') }}"
                  class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="Full name" required />
                <x-form-error name="owner_name" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Contact No.</label>
                <input type="tel" name="contact_no" value="{{ old('contact_no') }}"
                  class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="Contact number" required />
                <x-form-error name="contact_no" />
              </div>
            </div>

            <!-- Pet Info -->
            <div class="space-y-2">
              <h3 class="text-sm font-semibold text-gray-500 mb-1">Pet's Information</h3>

              <div>
                <label class="block text-gray-700 font-medium">Pet's Name</label>
                <input type="text" name="pet_name" value="{{ old('pet_name') }}"
                  class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="Pet's name" required />
                <x-form-error name="pet_name" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Last Seen Location</label>
                <input type="text" name="last_seen_location" value="{{ old('last_seen_location') }}"
                  class="w-full px-3 py-2 rounded-lg border focus:border-black" placeholder="Location" required />
                <x-form-error name="last_seen_location" />
              </div>

              <div>
                <label class="block text-gray-700 font-medium">Last Seen Date</label>
                <input type="date" name="last_seen_date" value="{{ old('last_seen_date') }}" max="{{ date('Y-m-d') }}"
                  class="w-full px-3 py-2 rounded-lg border focus:border-black" required />
                <x-form-error name="last_seen_date" />
              </div>
            </div>
          </div>

          <div class="mb-2">
            <label class="block text-gray-700 font-medium">Pet Description</label>
            <textarea name="pet_description" class="w-full px-3 py-2 rounded-lg border focus:border-black"
              placeholder="Breed, color, distinguishing marks, etc." required>{{ old('pet_description') }}</textarea>
            <x-form-error name="pet_description" />
          </div>

          <div class="mb-6">
            <label class="block text-gray-700 font-medium">Upload Pet's Photo</label>
            <input type="file" name="pet_photo"
              class="w-full py-0 border rounded-lg border focus:border-black file:bg-gray-400 file:border-0 file:text-white"
              required />
            <x-form-error name="pet_photo" />
          </div>

          <!-- Submit Button -->
          <div class="flex justify-center md:justify-end">
            <button type="submit"
              class="w-full md:w-auto bg-orange-600 text-white font-medium py-3 px-6 rounded-lg hover:bg-orange-400 transition">
              Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Right Side: Full-Screen Image (Hidden on mobile) -->
    <div class="hidden md:block w-full md:w-1/2">
      <img src="{{ asset('images/missing.jpeg') }}" alt="Missing Pet" class="w-full h-full object-cover" />
    </div>
  </section>
  <!-- ========== END OF SECTION ========== -->
</x-layout>