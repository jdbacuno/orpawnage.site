<x-layout>
  <!-- START OF THE SECTION -->
  <section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
      <a href="/services/adopt-a-pet"
        class="text-blue-500 font-bold hover:text-orange-500 text-lg inline-flex items-center">
        <i class="ph-fill ph-caret-left"></i> <span>Back</span>
      </a>
      <h2 class="text-4xl font-bold text-black mt-4 mb-4">
        Adoption Request Form
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 overflow-hidden">
        <!-- LEFT SIDE: Pet Image -->
        <div class="h-full w-full">
          {{-- asset('storage/' . $pet->image_path) --}}
          <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
            class="w-full h-auto object-cover" />
        </div>

        <!-- RIGHT SIDE: Pet Details and User Information -->
        <div class="px-0 sm:px-6 pt-0 sm:pb-6">


          @if (session('success'))
          <div id="alert-3"
            class="flex items-center p-4 mb-3 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 sm:col-span-7"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              {{ session('success') }}
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
              data-dismiss-target="#alert-3" aria-label="Close" id="triggerElement">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          @if (session('error_request'))
          <div id="alert-3"
            class="flex items-center p-4 mb-3 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 sm:col-span-7"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              {{ session('error_request') }}
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 "
              data-dismiss-target="#alert-3" aria-label="Close" id="triggerElement">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          @if (session('submission_error'))
          <div id="alert-3"
            class="flex items-center p-4 mb-3 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 sm:col-span-7"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              {{ session('submission_error') }}
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 "
              data-dismiss-target="#alert-3" aria-label="Close" id="triggerElement">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          <!-- Pet Details -->
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Adopt Pet#{{ $pet->pet_number }} {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : '' }}
          </h2>
          <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Species</label>
              <input type="text" value="{{ ucfirst($pet->species) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Age</label>
              <input type="text"
                value="{{ $pet->age }} {{ $pet->age == 1 ? Str::singular($pet->age_unit) : Str::plural($pet->age_unit) }} old"
                readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Sex</label>
              <input type="text" value="{{ ucfirst($pet->sex) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Reproductive Status</label>
              <input type="text" value="{{ ucfirst($pet->reproductive_status) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Color</label>
              <input type="text" value="{{ ucfirst($pet->color) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Source</label>
              <input type="text" value="{{ ucfirst($pet->source) }}" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 dark:bg-gray-700 dark:text-gray-300" />
            </div>
          </div>

          <!-- User Details -->
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            Your Information
          </h3>
          <form method="POST" action="/services/{{ $pet->slug }}/adoption-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="text-sm font-medium text-gray-600">Full Name</label>
                <input type="text" name="full_name"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your full name" value="{{ old('full_name') }}" required />
                <x-form-error name="full_name" />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Email Address</label>
                <input type="email" name="email"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your email address" value="{{ old('email') }}" required />
                <x-form-error name="email" />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Age</label>
                <input type="number" name="age"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your age" value="{{ old('age') }}" required />
                <x-form-error name="age" />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Birthdate</label>
                <input type="date" name="birthdate"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  value="{{ old('birthdate') }}" required min="1900-01-01" max="2099-12-31" />
                <x-form-error name="birthdate" />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Contact Number</label>
                <input type="text" name="contact_number"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your contact number" value="{{ old('contact_number') }}" required />
                <x-form-error name="contact_number" />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Residential Address</label>
                <input type="text" name="address"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your address" value="{{ old('address') }}" required />
                <x-form-error name="address" />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Civil Status</label>
                <select name="civil_status"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  required>
                  <option value="" disabled {{ old('civil_status') ? '' : 'selected' }}>Select Civil Status</option>
                  <option value="Single" {{ old('civil_status')=='Single' ? 'selected' : '' }}>Single</option>
                  <option value="Married" {{ old('civil_status')=='Married' ? 'selected' : '' }}>Married</option>
                  <option value="Divorced" {{ old('civil_status')=='Divorced' ? 'selected' : '' }}>Divorced</option>
                </select>
                <x-form-error name="civil_status" />
              </div>
              <div>
                <label class="text-sm font-medium text-gray-600">Citizenship</label>
                <input type="text" name="citizenship"
                  class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:border-orange-500"
                  placeholder="Enter your citizenship" value="{{ old('citizenship') }}" required />
                <x-form-error name="citizenship" />
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
              class="w-full mt-6 bg-orange-500 text-white font-medium rounded-lg py-3 hover:bg-yellow-500 transition duration-300">
              Submit Adoption Form
            </button>
          </form>

        </div>
      </div>

    </div>
  </section>
  <!-- END OF THE SECTION -->
</x-layout>