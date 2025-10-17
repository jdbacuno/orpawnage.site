<x-layout>
  <!-- ========== START OF HERO SECTION ========== -->
  <section class="relative min-h-[70vh] flex items-center justify-center bg-gray-900 overflow-hidden" id="mainContent">
    <!-- Background image with darker overlay -->
    <div class="absolute inset-0 w-full h-full">
      <img src="{{ asset('images/missing.png') }}" alt="Missing Pet"
        class="w-full h-full object-cover object-center brightness-50" />
      <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <!-- Content container -->
    <div class="container mx-auto px-6 sm:px-8 relative z-10 text-center">
      <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
          <span class="block">Lost Your Pet?</span>
          <span class="text-yellow-400 block">We're Here to Help You Find Them</span>
        </h1>

        <p class="text-lg sm:text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
          Report your missing pet and we'll spread the word to our community. Together, we can bring them home.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a href="#reportForm"
            class="px-8 py-3 bg-orange-500 hover:bg-yellow-500 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center">
            <i class="ph-fill ph-clipboard-text mr-2"></i>Post a Missing Pet
          </a>
          <a href="/missing-pets-browse"
            class="px-8 py-3 bg-white/10 hover:bg-yellow-500/20 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg text-center flex justify-center items-center border border-white/20">
            <i class="ph-fill ph-magnifying-glass mr-2"></i>Browse Missing Pets
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
            <i class="ph-fill ph-clipboard-text mr-2 text-orange-500"></i>Report Missing Pet
          </h2>
          <p class="text-gray-600">Fill out the form below to report your missing pet</p>
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

        @if (session('error') || $errors->any())
        <div id="alert-error"
          class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 border-l-4 border-red-400" role="alert">
          <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
          </svg>
          <span class="sr-only">Info</span>
          <div class="ms-3 text-sm font-medium">
            {{ session('error') ?? 'Please correct the errors below.' }}
          </div>
          <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
            data-dismiss-target="#alert-error" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
          </button>
        </div>
      </div>
      @endif

      <!-- Form Stepper -->
      <div class="mb-4">
        <div class="flex items-center justify-between">
          <div class="flex-1 h-2 bg-gray-200 rounded-full mr-3">
            <div id="missingProgress" class="h-2 bg-orange-500 rounded-full" style="width: 25%"></div>
          </div>
          <span id="missingStepLabel" class="text-xs text-gray-600">Step 1 of 4</span>
        </div>
        <div class="mt-2 grid grid-cols-4 gap-2 text-[11px] text-gray-600">
          <div class="text-center">Your Info</div>
          <div class="text-center">Pet Info</div>
          <div class="text-center">Documents</div>
          <div class="text-center">Declaration</div>
        </div>
      </div>

      <form method="POST" action="/report/missing-pet" id="missingForm" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @guest
        <x-login-required-banner />
        @endguest

        <!-- Step 1: Your Information -->
        <div class="missing-step" data-step="1">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
            <i class="ph-fill ph-user-circle mr-2"></i>Your Information
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Your Name <span class="text-red-500">*</span>
              </label>
              <input type="text" name="owner_name" value="{{ old('owner_name') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                placeholder="Enter your full name" />
              <x-form-error name="owner_name" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Contact Number <span class="text-red-500">*</span>
              </label>
              <input type="text" name="contact_no" value="{{ old('contact_no') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                placeholder="09123456789" />
              <x-form-error name="contact_no" />
            </div>
          </div>
        </div>

        <!-- Step 2: Pet Information -->
        <div class="missing-step hidden" data-step="2">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
            <i class="ph-fill ph-paw-print mr-2"></i>Pet Information
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Pet's Name <span class="text-red-500">*</span>
              </label>
              <input type="text" name="pet_name" value="{{ old('pet_name') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                placeholder="Enter pet's name" />
              <x-form-error name="pet_name" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Last Seen Date <span class="text-red-500">*</span>
              </label>
              <input type="date" name="last_seen_date" value="{{ old('last_seen_date') }}" required
                max="{{ date('Y-m-d') }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400" />
              <x-form-error name="last_seen_date" />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Last Seen Location <span class="text-red-500">*</span>
              </label>
              <input type="text" name="last_seen_location" value="{{ old('last_seen_location') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                placeholder="Enter the last known location" />
              <x-form-error name="last_seen_location" />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Message/Description <span class="text-red-500">*</span>
              </label>
              <textarea name="pet_description" rows="4" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                placeholder="Describe your pet (breed, color, distinctive features, etc.)">{{ old('pet_description') }}</textarea>
              <x-form-error name="pet_description" />
            </div>
          </div>
        </div>

        <!-- Step 3: Documentation -->
        <div class="missing-step hidden" data-step="3">
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
              <div class="flex justify-between items-center mb-1">
                <label class="block text-sm font-medium text-gray-600">
                  Valid ID (max 5MB) <span class="text-red-500">*</span>
                </label>
                <button type="button" onclick="openValidIdModal()"
                  class="text-sm text-orange-600 hover:text-orange-700 font-medium cursor-pointer">
                  View Accepted IDs
                </button>
              </div>
              <input type="file" name="valid_id" accept="image/*" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" />
              <x-form-error name="valid_id" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Pet Photos (Max 5, 5MB each) <span class="text-red-500">*</span>
              </label>
              <input type="file" name="pet_photos[]" id="pet_photos_input" multiple accept="image/*" class="hidden"
                required />
              <div id="petPhotosPreviews" class="my-2 grid grid-cols-3 gap-2"></div>
              <button type="button" id="addPetPhotosBtn"
                class="px-4 py-2 bg-orange-100 text-orange-700 text-sm font-medium rounded-md border border-orange-300 hover:bg-orange-200 transition w-fit flex items-center gap-2">
                <i class="ph-fill ph-plus-circle"></i> Add Pet Photos
              </button>
              <x-form-error name="pet_photos" />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Location Photos (Optional, Max 5, 5MB each)
              </label>
              <input type="file" name="location_photos[]" id="location_photos_input" multiple accept="image/*"
                class="hidden" />
              <div id="locationPhotosPreviews" class="my-2 grid grid-cols-3 gap-2"></div>
              <button type="button" id="addLocationPhotosBtn"
                class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md border border-gray-300 hover:bg-gray-200 transition w-fit flex items-center gap-2">
                <i class="ph-fill ph-plus-circle"></i> Add Location Photos
              </button>
              <x-form-error name="location_photos" />
            </div>
          </div>
        </div>

        <!-- Step 4: Declaration -->
        <div class="missing-step hidden" data-step="4">
          <div class="p-4 bg-orange-50 rounded-lg border border-orange-100 mb-4">
            <h4 class="text-sm font-medium text-orange-800 mb-2 flex items-center">
              <i class="ph-fill ph-hand-palm mr-2"></i>Declaration
            </h4>
            <div class="text-sm text-gray-700 leading-relaxed">
              <p class="mb-3">I certify that the information provided is true and accurate. Once approved, this report
                will be posted publicly and shared with our community to help find my missing pet.</p>
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
                OrPAWnage. I understand that the information I provide will be used solely for processing my missing
                pet report. <span class="text-red-500">*</span>
              </label>
            </div>
            <x-form-error name="terms_agreement" />
          </div>

          <div class="flex justify-end">
            @auth
            <button type="submit" id="missingSubmit"
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
          <button type="button" id="missingPrev"
            class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-40"
            disabled>
            Back
          </button>
          <button type="button" id="missingNext"
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
    function openValidIdModal() {
      document.getElementById('validIdModal').classList.remove('hidden');
    }

    function closeValidIdModal() {
      document.getElementById('validIdModal').classList.add('hidden');
    }

    // Image upload handlers
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

        newFiles.forEach((file) => {
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
    }

    document.addEventListener('DOMContentLoaded', function() {
      setupImageUpload('pet_photos_input', 'petPhotosPreviews', 'addPetPhotosBtn');
      setupImageUpload('location_photos_input', 'locationPhotosPreviews', 'addLocationPhotosBtn');
    });

    // Wizard logic for Missing Pet form
    (function() {
      const steps = Array.from(document.querySelectorAll('.missing-step'));
      const nextBtn = document.getElementById('missingNext');
      const prevBtn = document.getElementById('missingPrev');
      const submitBtn = document.getElementById('missingSubmit');
      const progress = document.getElementById('missingProgress');
      const label = document.getElementById('missingStepLabel');
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

    // Smooth scroll to form when clicking "Post a Missing Pet"
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
  </script>
</x-layout>
