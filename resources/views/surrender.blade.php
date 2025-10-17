<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative min-h-[70vh] flex items-center justify-center bg-gray-900 overflow-hidden" id="mainContent">
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

  <!-- ========== START OF PROCESS STEPS SECTION ========== -->
  <section class="bg-gray-100 pt-12 pb-6 px-6 sm:px-8" id="startTheProcess">
    <div class="max-w-5xl mx-auto text-center mb-10">
      <h2 class="text-3xl sm:text-4xl font-bold text-gray-800">Surrender Process</h2>
      <p class="mt-4 text-gray-600">Follow these simple steps to surrender or rehome an animal safely and responsibly.
      </p>
    </div>

    <div class="max-w-4xl mx-auto">
      <div class="bg-white shadow-md rounded-2xl p-8">
        <div class="space-y-6">
          <!-- Step 1 -->
          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                1
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Submit Application Form</h3>
              <p class="text-gray-600">Fill out and submit the surrender application form below with all required
                information and documents.</p>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                2
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Confirm Within 24 Hours</h3>
              <p class="text-gray-600">You must confirm your application within 24 hours of submission. Applications not
                confirmed will be automatically cancelled.</p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                3
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Application Review & Contact</h3>
              <p class="text-gray-600">Once reviewed, our team will call you to determine if you can bring the pet to
                the City Vet Office, or if the City Vet will come to retrieve the animal (especially for wild animals).
              </p>
            </div>
          </div>

          <!-- Step 4 -->
          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                4
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Prepare for Drop-off</h3>
              <p class="text-gray-600">If you're bringing the pet to the office, prepare your transaction number and
                valid ID for verification purposes.</p>
            </div>
          </div>

          <!-- Step 5 -->
          <div class="flex gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                5
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Surrender Complete</h3>
              <p class="text-gray-600">After the animal has been surrendered, you will receive an email confirmation
                that the surrender process is complete.</p>
            </div>
          </div>
        </div>

        <!-- Important Notice -->
        <div class="mt-8 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
          <div class="flex items-start gap-3">
            <i class="ph-fill ph-warning text-yellow-600 text-xl mt-0.5"></i>
            <div>
              <h4 class="text-sm font-semibold text-yellow-800 mb-1">Important Reminder</h4>
              <p class="text-sm text-yellow-700">By surrendering the animal, you transfer all ownership rights to the
                shelter and cannot reclaim the animal once the process is complete.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ========== END OF PROCESS STEPS SECTION ========== -->

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

        <!-- Form Stepper -->
        <div class="mb-4">
          <div class="flex items-center justify-between">
            <div class="flex-1 h-2 bg-gray-200 rounded-full mr-3">
              <div id="surrenderProgress" class="h-2 bg-orange-500 rounded-full" style="width: 25%"></div>
            </div>
            <span id="surrenderStepLabel" class="text-xs text-gray-600">Step 1 of 4</span>
          </div>
          <div class="mt-2 grid grid-cols-4 gap-2 text-[11px] text-gray-600">
            <div class="text-center">Your Info</div>
            <div class="text-center">Animal</div>
            <div class="text-center">Documents</div>
            <div class="text-center">Declaration</div>
          </div>
        </div>

        <form method="POST" action="/services/surrender" id="surrenderForm" enctype="multipart/form-data"
          class="space-y-6">
          @csrf

          @guest
          <x-login-required-banner />
          @endguest

          <!-- Step 1: Surrenderer's Information -->
          <div class="surrender-step" data-step="1">
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
                  value="{{ old('full_name') }}" required />
                <x-form-error name="full_name" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Email
                </label>
                @auth
                <input type="email" name="email"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100"
                  value="{{ auth()->user()->email }}" readonly required />
                @endauth

                @guest
                <input type="email" name="email" placeholder="Your email"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm" value="{{ old('email') }}"
                  required />
                @endguest
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
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your contact number (e.g., 09123456789)" value="{{ old('contact_number') }}" required />
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

          <!-- Step 2: Animal's Information -->
          <div class="surrender-step hidden" data-step="2">
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
                  value="{{ old('pet_name') }}" required />
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

          <!-- Step 3: Documentation -->
          <div class="surrender-step hidden" data-step="3">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-file mr-2"></i>Documentation
            </h3>

            <!-- Privacy Notice for Valid ID -->
            <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <i class="ph-fill ph-shield-check text-blue-600 text-xl"></i>
                </div>
                <div class="ml-3">
                  <h5 class="text-sm font-semibold text-blue-800 mb-1">Your Privacy is Protected</h5>
                  <p class="text-xs text-blue-700 leading-relaxed">
                    Your ID is used solely for identity verification and eligibility confirmation. We do not share,
                    sell, or use your ID for any other purpose. All documents are securely stored and handled in
                    accordance with our <a href="/privacy-policy" class="underline font-medium hover:text-blue-900"
                      target="_blank">Privacy Policy</a>.
                  </p>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <!-- Valid ID Upload -->
                <div class="mb-4">
                  <div class="flex justify-between items-center mb-1">
                    <label class="block text-sm font-medium text-gray-600">Upload Image of Valid ID (must be 5MB or
                      below) <span class="text-red-500">*</span></label>
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
                  Animal Photos (Max 5 and file size must be 5MB or below for each image) <span
                    class="text-red-500">*</span>
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
                @if($errors->has('animal_photos') || $errors->has('files') ||
                collect($errors->getMessages())->keys()->contains(fn($key) => str_starts_with($key, 'animal_photos.')))
                <div class="mt-1 text-sm text-red-600">
                  {{ $errors->first('animal_photos') ?: $errors->first('files') ?: 'One or more photos are too large or
                  invalid. Please check file sizes and formats.' }}
                </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Step 4: Declaration & Submit -->
          <div class="surrender-step hidden" data-step="4">
            <div class="p-4 bg-orange-50 rounded-lg border border-orange-100">
              <h4 class="text-sm font-medium text-orange-800 mb-2 flex items-center">
                <i class="ph-fill ph-hand-palm mr-2"></i>Declaration
              </h4>
              <div class="text-sm text-gray-700 leading-relaxed">
                <p class="mb-3">I certify that the information provided in this surrender form is true and accurate to
                  the best of my knowledge.</p>
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
              <x-form-error name="declaration" />
            </div>

            <!-- Terms and Conditions Agreement -->
            <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
              <div class="flex items-start gap-3">
                <input type="checkbox" name="terms_agreement" id="terms_agreement"
                  class="mt-1 w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2"
                  required />
                <label for="terms_agreement" class="text-sm text-gray-700 leading-relaxed">
                  I have read and agree to the <a href="/terms-and-conditions" target="_blank"
                    class="text-orange-600 hover:text-orange-700 font-medium underline">Terms and Conditions</a> and
                  <a href="/privacy-policy" target="_blank"
                    class="text-orange-600 hover:text-orange-700 font-medium underline">Privacy Policy</a> of
                  OrPAWnage. I understand that the information I provide will be used solely for processing my
                  surrender application and verifying my identity. <span class="text-red-500">*</span>
                </label>
              </div>
              <x-form-error name="terms_agreement" />
            </div>

            <div class="flex justify-end mt-4">
              @auth
              <button type="submit" id="surrenderSubmit"
                class="px-8 py-3 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                    clip-rule="evenodd" />
                </svg>
                Submit Surrender Application
              </button>
              @endauth

              @guest
              <button type="button" disabled
                class="px-8 py-3 bg-gray-500 text-white text-sm font-medium rounded-lg cursor-not-allowed opacity-50 flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                    clip-rule="evenodd" />
                </svg>
                Login to Submit
              </button>
              @endguest
            </div>
          </div>

          <!-- Wizard Controls -->
          <div class="mt-4 flex items-center justify-between">
            <button type="button" id="surrenderPrev"
              class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-40"
              disabled>
              Back
            </button>
            <button type="button" id="surrenderNext"
              class="px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              Next
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

  <!-- Minor Age Modal -->
  <div id="minorAgeModal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-1">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full space-y-4 relative max-h-[90vh] overflow-y-auto">
      <!-- Close Button -->
      <button onclick="closeMinorAgeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold">Assistance Required</h2>

      <div class="text-sm text-gray-600 space-y-2">
        <p>Since you are under 18 years old, you will need assistance from a parent or guardian to proceed with the
          surrender application.</p>
      </div>

      <div class="flex justify-end">
        <button onclick="closeMinorAgeModal()"
          class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-yellow-400 hover:text-black transition">
          OK
        </button>
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

      if (age < 18) {
        document.getElementById('minorAgeModal').classList.remove('hidden');
      }
    }

    function closeMinorAgeModal() {
      document.getElementById('minorAgeModal').classList.add('hidden');
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

    document.addEventListener('DOMContentLoaded', function () {
      const header = document.getElementById('main-header');
      const mainContent = document.getElementById('mainContent');
      const adminIndicator = document.getElementById('adminIndicator');

      const EXTRA_TOP_SPACING_PX = 8;

      function computeHeights() {
        const headerHeight = header ? header.offsetHeight : 0;
        const adminHeight = adminIndicator ? adminIndicator.offsetHeight : 0;
        return { headerHeight, adminHeight };
      }

      function updateHeaderSpacer() {
        if (!mainContent) return;
        const { headerHeight, adminHeight } = computeHeights();
        const totalTop = headerHeight + adminHeight;

        // mainContent.style.marginTop = '0px';
        mainContent.style.marginTop = `${(totalTop + EXTRA_TOP_SPACING_PX) * .5}px`;
        mainContent.style.paddingTop = `${totalTop + EXTRA_TOP_SPACING_PX}px`;
        mainContent.style.paddingBottom = `${totalTop + EXTRA_TOP_SPACING_PX}px`;
      }

      updateHeaderSpacer();
      window.addEventListener('resize', updateHeaderSpacer);

      if (window.ResizeObserver) {
        const ro = new ResizeObserver(updateHeaderSpacer);
        if (header) ro.observe(header);
        if (adminIndicator) ro.observe(adminIndicator);
      }
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

    // Wizard logic for Surrender form
    (function() {
      const steps = Array.from(document.querySelectorAll('.surrender-step'));
      const nextBtn = document.getElementById('surrenderNext');
      const prevBtn = document.getElementById('surrenderPrev');
      const submitBtn = document.getElementById('surrenderSubmit');
      const progress = document.getElementById('surrenderProgress');
      const label = document.getElementById('surrenderStepLabel');
      const termsCheckbox = document.getElementById('terms_agreement');
      const declarationCheckbox = document.getElementById('declaration');
      const total = steps.length || 4;
      let current = 1;

      function showStep(step) {
        steps.forEach(s => s.classList.add('hidden'));
        const active = steps.find(s => s.getAttribute('data-step') === String(step));
        if (active) active.classList.remove('hidden');

        const pct = Math.max(25, Math.min(100, (step / total) * 100));
        progress.style.width = pct + '%';
        label.textContent = `Step ${step} of ${total}`;

        prevBtn.disabled = step === 1;
        nextBtn.classList.toggle('hidden', step === total);

        // Enable/disable submit button based on both checkboxes
        if (step === total && submitBtn && termsCheckbox && declarationCheckbox) {
          submitBtn.disabled = !(termsCheckbox.checked && declarationCheckbox.checked);
        }
      }

      function validateStep(step) {
        const container = steps.find(s => s.getAttribute('data-step') === String(step));
        if (!container) return true;
        const requiredInputs = container.querySelectorAll('[required]');
        for (const input of requiredInputs) {
          if (input.type === 'file') {
            if (!input.files || input.files.length === 0) {
              input.reportValidity();
              return false;
            }
          } else if (input.type === 'checkbox') {
            if (!input.checked) {
              input.reportValidity();
              return false;
            }
          } else if (!input.value) {
            input.reportValidity();
            return false;
          }
        }
        return true;
      }

      nextBtn?.addEventListener('click', () => {
        if (!validateStep(current)) return;
        current = Math.min(total, current + 1);
        showStep(current);
      });

      prevBtn?.addEventListener('click', () => {
        current = Math.max(1, current - 1);
        showStep(current);
      });

      // Listen to both checkboxes changes
      if (termsCheckbox && declarationCheckbox && submitBtn) {
        const updateSubmitButton = () => {
          submitBtn.disabled = !(termsCheckbox.checked && declarationCheckbox.checked);
        };

        termsCheckbox.addEventListener('change', updateSubmitButton);
        declarationCheckbox.addEventListener('change', updateSubmitButton);
      }

      showStep(current);
    })();
  </script>
</x-layout>
