<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative min-h-[70vh] flex items-center justify-center bg-gray-900 overflow-hidden" id="mainContent">
    <!-- Background image with darker overlay -->
    <div class="absolute inset-0 w-full h-full">
      <img src="{{ asset('images/abuse-img.jpg') }}" alt="Animal Rescue"
        class="w-full h-full object-cover object-center brightness-50" />
      <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <!-- Content container -->
    <div class="container mx-auto px-6 sm:px-8 relative z-10 text-center">
      <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
          <span class="block">Witness Animal Abuse or Found a Stray?</span>
          <span class="text-yellow-400 block">Help Us Take Action</span>
        </h1>

        <p class="text-lg sm:text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
          Report incidents of animal abuse, illegal activities, or stray animals in need of rescue. Your report helps us protect vulnerable animals and bring them to safety.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a href="#reportForm"
            class="px-8 py-3 bg-orange-500 hover:bg-yellow-500 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center">
            <i class="ph-fill ph-warning-circle mr-2"></i>Report an Abuse or Request a Rescue
          </a>
          <a href="/featured-adoptions"
            class="px-8 py-3 bg-white/10 hover:bg-yellow-500/20 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center border border-white/20">
            <i class="ph-fill ph-heart mr-2"></i>See Featured Rescued Animals
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- ========== END OF HERO SECTION ========== -->

  <!-- ========== START OF REPORT FORM SECTION ========== -->
  <section class="pt-6 pb-10 px-4 sm:px-6 relative overflow-hidden bg-gray-100" id="reportForm">
    <div class="max-w-4xl mx-auto">
      <div class="rounded-xl bg-white border border-gray-200 p-6 sm:p-8 shadow-md">
        <!-- Form Header -->
        <div class="mb-8">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 flex items-center">
            <i class="ph-fill ph-warning-circle mr-2 text-orange-500"></i>Report an Incident
          </h2>
          <p class="text-gray-600">Fill out the form below to report animal abuse, illegal activities, or request rescue assistance for stray animals</p>
        </div>

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

        <!-- Error Alert -->
        @if ($errors->any())
        <div id="error-alert"
          class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 border-l-4 border-red-400" role="alert">
          <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
              clip-rule="evenodd" />
          </svg>
          <span class="sr-only">Error</span>
          <div class="ms-3 text-sm font-medium">
            Please review the form to check for any errors.
          </div>
          <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
            data-dismiss-target="#error-alert" aria-label="Close">
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
              <div id="abuseProgress" class="h-2 bg-orange-500 rounded-full" style="width: 25%"></div>
            </div>
            <span id="abuseStepLabel" class="text-xs text-gray-600">Step 1 of 4</span>
          </div>
          <div class="mt-2 grid grid-cols-4 gap-2 text-[11px] text-gray-600">
            <div class="text-center">Reporter Info</div>
            <div class="text-center">Incident Details</div>
            <div class="text-center">Documentation</div>
            <div class="text-center">Declaration</div>
          </div>
        </div>

        <!-- Form Start -->
        <form id="reportForm" action="{{ route('report.animal.abuse') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf

          @guest
          <x-login-required-banner />
          @endguest

          <!-- Step 1: Reporter's Information -->
          <div class="abuse-step" data-step="1">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-user-circle mr-2"></i>Reporter's Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name (Optional)</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your full name" />
                <x-form-error name="full_name" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number <span class="text-red-500">*</span></label>
                <input type="text" name="contact_no"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your contact number (e.g., 09123456789)" value="{{ old('contact_no') }}" required />
                <x-form-error name="contact_no" />
              </div>
            </div>
          </div>

          <!-- Step 2: Incident Information -->
          <div class="abuse-step hidden" data-step="2">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-map-pin mr-2"></i>Incident Information
            </h3>

            <!-- Notice -->
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm text-red-700">
                    <strong>Important Notice:</strong> While we review all reports, please understand that we may not be
                    able to immediately investigate or resolve every case due to resource limitations. Once submitted, our team will assess your report and may contact you for additional information. For urgent cases requiring immediate attention, please contact local authorities directly.
                  </p>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Where did it happen? <span class="text-red-500">*</span></label>
                <input type="text" name="incident_location" value="{{ old('incident_location') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Where the incident occurred" required />
                <x-form-error name="incident_location" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">When did it happen? <span class="text-red-500">*</span></label>
                <input type="date" name="incident_date" value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required />
                <x-form-error name="incident_date" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type of Animal <span class="text-red-500">*</span></label>
                <input type="text" name="species" value="{{ old('species') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="e.g. dog, cat, monkey..." required />
                <x-form-error name="species" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">What happened to the animal? <span class="text-red-500">*</span></label>
                <select name="animal_condition"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="" disabled selected>Select condition</option>
                  <option value="Illegal Meat Trading or Consumption" {{
                    old('animal_condition')=='Illegal Meat Trading or Consumption' ? 'selected' : '' }}>Illegal Meat
                    Trading/Consumption</option>
                  <option value="Wounded" {{ old('animal_condition')=='Wounded' ? 'selected' : '' }}>Wounded</option>
                  <option value="Physically Abused" {{ old('animal_condition')=='Physically Abused' ? 'selected' : '' }}>
                    Physically Abused</option>
                  <option value="Stray" {{ old('animal_condition')=='Stray' ? 'selected' : '' }}>Stray</option>
                  <option value="Other" {{ old('animal_condition')=='Other' ? 'selected' : '' }}>Other</option>
                </select>
                <x-form-error name="animal_condition" />
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes <span class="text-red-500">*</span></label>
                <textarea name="additional_notes"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  rows="4" placeholder="Provide additional details about the incident"
                  required>{{ old('additional_notes') }}</textarea>
                <x-form-error name="additional_notes" />
              </div>
            </div>
          </div>

          <!-- Step 3: Documentation -->
          <div class="abuse-step hidden" data-step="3">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
              <i class="ph-fill ph-camera mr-2"></i>Valid ID and Photos of Incident
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
                <div class="flex justify-between items-center mb-1">
                  <label class="block text-sm font-medium text-gray-700">Upload Image of Valid ID (must be 5MB or below)
                    <span class="text-red-500">*</span></label>
                  <button type="button" onclick="openValidIdModal()"
                    class="text-sm text-orange-600 hover:text-orange-700 font-medium cursor-pointer">View Accepted Valid
                    IDs</button>
                </div>
                <input type="file" name="valid_id" accept="image/*" required
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" />
                <x-form-error name="valid_id" />
              </div>

              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Photos of Incident and Its Location
                  (Max 5 and file size must be 5MB or below for each image) <span class="text-red-500">*</span></label>
                <input type="file" name="incident_photos[]" id="incident_photos_input" multiple accept="image/*"
                  class="hidden" required />
                <div id="imagePreviews" class="my-2 grid grid-cols-3 gap-2"></div>
                @if($errors->has('incident_photos') || $errors->has('files') ||
                collect($errors->getMessages())->keys()->contains(fn($key) => str_starts_with($key,
                'incident_photos.')))
                <div class="mt-1 text-sm text-red-600">
                  {{ $errors->first('incident_photos') ?: $errors->first('files') ?: 'One or more photos are too large
                  or invalid. Please check file sizes and formats.' }}
                </div>
                @endif
                <button type="button" id="addMoreBtn"
                  class="px-4 py-2 bg-orange-100 text-orange-700 text-sm font-medium rounded-md border border-orange-300 hover:bg-orange-200 transition w-fit flex items-center gap-2">
                  <i class="ph-fill ph-plus-circle"></i> Add More Photos
                </button>
              </div>
            </div>
          </div>

          <!-- Step 4: Declaration -->
          <div class="abuse-step hidden" data-step="4">
            <div class="p-4 bg-orange-50 rounded-lg border border-orange-100 mb-4">
              <h4 class="text-sm font-medium text-orange-800 mb-2 flex items-center">
                <i class="ph-fill ph-hand-palm mr-2"></i>Declaration
              </h4>
              <div class="text-sm text-gray-700 leading-relaxed">
                <p class="mb-3">I certify that the information provided is true and accurate. I understand that false reporting may result in legal consequences. Once submitted, our team will review this report and may contact me for additional information or to inform me of any actions taken.</p>
              </div>
            </div>

            <!-- Terms and Conditions Agreement -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-4">
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
                  report and verifying my identity. <span class="text-red-500">*</span>
                </label>
              </div>
              <x-form-error name="terms_agreement" />
            </div>

            <div class="flex justify-end">
              @auth
              <button type="submit" id="submitReport"
                class="px-8 py-3 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="ph-fill ph-paper-plane-tilt mr-2"></i>Submit Report
              </button>
              @endauth

              @guest
              <button type="button" disabled
                class="px-8 py-3 bg-gray-500 text-white text-sm font-medium rounded-lg cursor-not-allowed opacity-50 flex items-center justify-center shadow-md">
                <i class="ph-fill ph-paper-plane-tilt mr-2"></i>Login to Submit
              </button>
              @endguest
            </div>
          </div>

          <!-- Wizard Controls -->
          <div class="mt-4 flex items-center justify-between">
            <button type="button" id="abusePrev"
              class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-40"
              disabled>
              Back
            </button>
            <button type="button" id="abuseNext"
              class="px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              Next
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- ========== END OF REPORT FORM SECTION ========== -->

  <!-- Valid ID Modal -->
  <div id="validIdModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-1">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full space-y-4 relative max-h-[90vh] overflow-y-auto">
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
    // Valid ID Modal functions
    function openValidIdModal() {
      document.getElementById('validIdModal').classList.remove('hidden');
    }

    function closeValidIdModal() {
      document.getElementById('validIdModal').classList.add('hidden');
    }

    // Image preview functionality
    const input = document.getElementById('incident_photos_input');
    const previewContainer = document.getElementById('imagePreviews');
    const addMoreBtn = document.getElementById('addMoreBtn');
    const dataTransfer = new DataTransfer();

    addMoreBtn.addEventListener('click', () => input.click());

    input.addEventListener('change', (event) => {
      const newFiles = Array.from(event.target.files);

      if (dataTransfer.files.length + newFiles.length > 5) {
        alert('You can upload a maximum of 5 images.');
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

    // Wizard logic for Abuse Report form
    (function() {
      const steps = Array.from(document.querySelectorAll('.abuse-step'));
      const nextBtn = document.getElementById('abuseNext');
      const prevBtn = document.getElementById('abusePrev');
      const submitBtn = document.getElementById('submitReport');
      const progress = document.getElementById('abuseProgress');
      const label = document.getElementById('abuseStepLabel');
      const termsCheckbox = document.getElementById('terms_agreement');
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

        if (step === total && submitBtn && termsCheckbox) {
          submitBtn.disabled = !termsCheckbox.checked;
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

      if (termsCheckbox && submitBtn) {
        termsCheckbox.addEventListener('change', () => {
          submitBtn.disabled = !termsCheckbox.checked;
        });
      }

      showStep(current);
    })();

    // Smooth scroll to form when clicking button
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    // Header spacer function
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
  </script>
</x-layout>
