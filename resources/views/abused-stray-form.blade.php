<x-layout>
  <section class="relative w-full min-h-screen bg-cover bg-center flex items-center justify-center"
    style="background-image: url('{{ asset('images/abuse-img.jpg') }}')" id="mainContent">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- Centered Form Card -->
    <div class="relative z-10 w-full max-w-4xl m-4">
      <div
        class="p-6 rounded-xl bg-gray-50/75 border border-gray-300 shadow-md backdrop-blur-sm max-h-full sm:max-h-[90vh] overflow-y-auto scrollbar-hidden">
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

        <!-- Form Start (Wizard) -->
        <form id="reportForm" action="{{ route('report.animal.abuse') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Stepper -->
          <div class="mb-4">
            <div class="flex items-center justify-between">
              <div class="flex-1 h-2 bg-gray-200 rounded-full mr-3">
                <div id="stepProgressAbuse" class="h-2 bg-orange-500 rounded-full" style="width: 25%"></div>
              </div>
              <span id="stepLabelAbuse" class="text-xs text-gray-600">Step 1 of 4</span>
            </div>
          </div>

          <!-- Step 1: Notice -->
          <div class="wizard-step-abuse" data-step="1">
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm text-red-700">
                    <strong>Important Notice:</strong> While we review all reports, please understand that we may not be able to immediately investigate or resolve every case due to resource limitations. Some reports may be grouped with similar cases in your area. You will receive a confirmation when your report is received, and may receive a generic notification when action is taken. For urgent cases, please contact local authorities directly.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 2: Reporter Info -->
          <div class="wizard-step-abuse hidden" data-step="2">
            <h4 class="text-md font-medium text-gray-900 mb-3 flex items-center">
              <i class="ph-fill ph-user-circle mr-2"></i>Reporter's Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name (Optional)</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Your full name" />
                <x-form-error name="full_name" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                <input type="tel" name="contact_no"
                  value="{{ auth()->user()->contact_number ?: 'Not Set (Please update in Account Settings)' }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-100" readonly required />
                <x-form-error name="contact_no" />
              </div>
            </div>
          </div>

          <!-- Step 3: Incident & Animal Info -->
          <div class="wizard-step-abuse hidden" data-step="3">
            <h4 class="text-md font-medium text-gray-900 mb-3 flex items-center">
              <i class="ph-fill ph-map-pin mr-2"></i>Incident Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Where did it happen?</label>
                <input type="text" name="incident_location" value="{{ old('incident_location') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="Where the incident occurred" required />
                <x-form-error name="incident_location" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">When did it happen?</label>
                <input type="date" name="incident_date" value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required />
                <x-form-error name="incident_date" />
              </div>
            </div>

            <h4 class="text-md font-medium text-gray-900 mb-3 flex items-center">
              <i class="ph-fill ph-paw-print mr-2"></i>Animal Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type of Animal</label>
                <input type="text" name="species" value="{{ old('species') }}"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="e.g. dog, cat, monkey..." required />
                <x-form-error name="species" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">What happened to the animal?</label>
                <select name="animal_condition"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="" disabled selected>Select condition</option>
                  <option value="Illegal Meat Trading or Consumption" {{ old('animal_condition')=='Illegal Meat Trading or Consumption' ? 'selected' : '' }}>Illegal Meat Trading/Consumption</option>
                  <option value="Wounded" {{ old('animal_condition')=='Wounded' ? 'selected' : '' }}>Wounded</option>
                  <option value="Physically Abused" {{ old('animal_condition')=='Physically Abused' ? 'selected' : '' }}>Physically Abused</option>
                  <option value="Stray" {{ old('animal_condition')=='Stray' ? 'selected' : '' }}>Stray</option>
                  <option value="Other" {{ old('animal_condition')=='Other' ? 'selected' : '' }}>Other</option>
                </select>
                <x-form-error name="animal_condition" />
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                <textarea name="additional_notes"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  rows="4" placeholder="Provide additional details about the incident" required>{{ old('additional_notes') }}</textarea>
                <x-form-error name="additional_notes" />
              </div>
            </div>
          </div>

          <!-- Step 4: Photos -->
          <div class="wizard-step-abuse hidden" data-step="4">
            <h4 class="text-md font-medium text-gray-900 mb-3 flex items-center">
              <i class="ph-fill ph-camera mr-2"></i>Valid ID and Photos of Incident
            </h4>
            <div>
              <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                  <label class="block text-sm font-medium text-gray-700">Upload Valid ID <span class="text-red-500">*</span></label>
                  <button type="button" onclick="openValidIdModal()" class="text-sm text-blue-600 hover:text-blue-700 font-medium cursor-pointer">View Accepted Valid IDs</button>
                </div>
                <input type="file" name="valid_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" required />
                <x-form-error name="valid_id" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Photos of Incident and Its Location (Max 10) <span class="text-red-500">*</span></label>
                <input type="file" name="incident_photos[]" id="incident_photos_input" multiple accept="image/*" class="hidden" />
                <div id="imagePreviews" class="my-2 grid grid-cols-3 gap-2"></div>
                <button type="button" id="addMoreBtn" class="px-4 py-2 bg-orange-100 text-orange-700 text-sm font-medium rounded-md border border-orange-300 hover:bg-orange-200 transition w-fit flex items-center gap-2">
                  <i class="ph-fill ph-plus-circle"></i> Add More Photos
                </button>
                <x-form-error name="incident_photos" />
              </div>
            </div>
          </div>

          <!-- Wizard Controls -->
          <div class="mt-4 flex items-center justify-between">
            <button type="button" id="prevStepAbuse" class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-40" disabled>
              Back
            </button>
            <button type="button" id="nextStepAbuse" class="px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              Next
            </button>
            <button type="submit" id="submitAbuse" class="hidden px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <i class="ph-fill ph-warning mr-2"></i>Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Valid ID Modal -->
  <div id="validIdModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center px-1">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full space-y-4 relative max-h-[90vh] overflow-y-auto">
      <!-- Close Button -->
      <button onclick="closeValidIdModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-900">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold">Accepted Valid IDs</h2>

      <div class="text-sm text-gray-700 space-y-4">
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
    // Wizard logic for Abused/Stray form
    (function() {
      const steps = Array.from(document.querySelectorAll('.wizard-step-abuse'));
      const nextBtn = document.getElementById('nextStepAbuse');
      const prevBtn = document.getElementById('prevStepAbuse');
      const submitBtn = document.getElementById('submitAbuse');
      const progress = document.getElementById('stepProgressAbuse');
      const label = document.getElementById('stepLabelAbuse');
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
        submitBtn.classList.toggle('hidden', step !== total);
      }

      function validateStep(step) {
        // Minimal per-step required fields enforcement
        const container = steps.find(s => s.getAttribute('data-step') === String(step));
        if (!container) return true;
        const requiredInputs = container.querySelectorAll('[required]');
        for (const input of requiredInputs) {
          if (input.type === 'file') {
            if (!input.files || input.files.length === 0) {
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

      showStep(current);
    })();

    const input = document.getElementById('incident_photos_input');
    const previewContainer = document.getElementById('imagePreviews');
    const addMoreBtn = document.getElementById('addMoreBtn');
    const dataTransfer = new DataTransfer();

    addMoreBtn.addEventListener('click', () => input.click());

    input.addEventListener('change', (event) => {
      const newFiles = Array.from(event.target.files);

      if (dataTransfer.files.length + newFiles.length > 10) {
        alert('You can upload a maximum of 10 images.');
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

    document.addEventListener('DOMContentLoaded', function() {
     function updateHeaderSpacer() {
         const header = document.getElementById('main-header');
         const mainContent = document.getElementById('mainContent');
         
         if (header && mainContent) {
             const headerHeight = header.offsetHeight;
             mainContent.style.marginTop = `${headerHeight}px`;
             mainContent.style.paddingTop = `${headerHeight * .30}px`;
             mainContent.style.paddingBottom = `${headerHeight * .30}px`;
         }
     }
    
     // Initial update
     updateHeaderSpacer();
    
     // Update on window resize
     window.addEventListener('resize', updateHeaderSpacer);
    });
  </script>


</x-layout>