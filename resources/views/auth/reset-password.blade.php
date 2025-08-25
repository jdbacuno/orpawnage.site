<x-auth-layout>
  <div class="relative p-6 bg-white z-1 sm:p-0">
    <div class="relative flex flex-col justify-center w-full h-screen sm:p-0 lg:flex-row">
      <!-- LEFT SIDE: Form -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto px-4 sm:px-6">
          <div class="space-y-8">
            <!-- Mobile Logo -->
            <div class="lg:hidden">
              <img src="{{ asset('images/orpawnage-logo.png') }}" class="h-24 mx-auto" alt="OrPAWnage Logo" />
            </div>

            <!-- Header -->
            <div class="space-y-2 text-center">
              <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                Reset Your Password
              </h1>
              <p class="text-gray-500">
                Create a new secure password for your account
              </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm" class="space-y-6">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">
              <input type="hidden" name="email" value="{{ request('email') }}">

              <!-- New Password -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  New Password
                </label>
                <div class="relative">
                  <input type="password" id="password" name="password" placeholder="Create a new password"
                    class="block w-full px-4 py-3 pr-10 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                    required />
                  <span id="toggle-password"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer hover:text-gray-500">
                    <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-closed" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                  </span>
                </div>

                <x-form-error name="password" />

                <!-- Password Strength -->
                <div class="mt-3">
                  <p id="strength-text" class="text-xs text-blue-700">Start typing to see strength...</p>
                  <div class="h-1.5 mt-1 rounded-full w-full bg-transparent">
                    <div id="strength-progress"
                      class="h-1.5 rounded-full w-0 bg-transparent transition-all duration-300"></div>
                  </div>
                </div>

                <!-- Password Requirements -->
                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mt-2">
                  <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                    <i class="ph-fill ph-info mr-2"></i>Password Requirements
                  </h4>
                  <ul class="text-xs space-y-1">
                    <li id="req-length" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> Minimum 6 characters
                    </li>
                    <li id="req-uppercase" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one uppercase letter
                    </li>
                    <li id="req-lowercase" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one lowercase letter
                    </li>
                    <li id="req-number" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one number
                    </li>
                    <li id="req-symbol" class="flex items-center text-blue-700">
                      <i class="ph-fill ph-circle mr-2 text-xs"></i> At least one symbol
                    </li>
                  </ul>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                  Confirm New Password
                </label>
                <div x-data="{ showPassword: false }" class="relative">
                  <input :type="showPassword ? 'text' : 'password'" placeholder="Repeat your new password"
                    name="password_confirmation"
                    class="block w-full px-4 py-3 pr-10 text-sm transition-all duration-200 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                    required />
                  <span @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer hover:text-gray-500">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      style="display: none;">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                  </span>
                </div>
                <x-form-error name="password_confirmation" />
              </div>

              <!-- Submit Button -->
              <div>
                <button type="submit"
                  class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-all duration-200 rounded-lg bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Reset Password
                </button>
              </div>
            </form>

            <!-- Sign In Link -->
            <div class="text-sm text-center text-gray-500">
              Remember your password? <a href="{{ route('login') }}"
                class="font-medium text-blue-600 hover:text-blue-500">Sign in</a>
            </div>
          </div>

          <!-- Bug Report Link -->
          <div class="fixed top-4 right-4 z-40">
            <button id="bug-report-link"
              class="text-sm bg-red-500 text-white hover:text-red-500 hover:bg-white flex items-center justify-center bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-md border border-gray-200 hover:bg-white transition-all duration-200">
              <svg class="w-5 h-5 sm:mr-1" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5c-.49 0-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20zm-6 8h-4v-2h4v2zm0-4h-4v-2h4v2z" />
              </svg>
              <span class="hidden sm:inline">Report a Bug</span>
            </button>

            <!-- Bug Report Modal -->
            <div id="bug-report-modal"
              class="fixed inset-0 px-1 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
              <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
                <div class="bg-orange-500 text-white p-4 rounded-t-lg -m-5 mb-4">
                  <div class="flex justify-between items-center">
                    <h3 class="font-semibold">Report a Bug</h3>
                    <button id="close-bug-modal" class="text-white hover:text-gray-200">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                      </svg>
                    </button>
                  </div>
                </div>

                <form id="bug-report-form" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-4">
                    <label for="bug-description" class="block text-sm font-medium text-gray-700 mb-2">
                      Describe the bug you encountered:
                    </label>
                    <textarea id="bug-description" name="description" rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                      placeholder="Please describe what happened, what you expected to happen, and any error messages you saw..."
                      required></textarea>
                  </div>

                  <div class="mb-4">
                    <label for="bug-email" class="block text-sm font-medium text-gray-700 mb-2">
                      Email (optional):
                    </label>
                    <input type="email" id="bug-email" name="email"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                      placeholder="Enter your email">
                  </div>

                  <div class="mb-4">
                    <label for="bug-screenshot" class="block text-sm font-medium text-gray-700 mb-2">
                      Screenshot (optional):
                    </label>
                    <div class="flex items-center space-x-2">
                      <button type="button" id="capture-screenshot"
                        class="px-3 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 transition-colors"
                        title="Captures only what you can currently see on screen">
                        📸 Capture Current View
                      </button>
                      <input type="file" id="bug-screenshot" name="screenshot" accept="image/*" class="hidden">
                      <span id="screenshot-status" class="text-sm text-gray-500"></span>
                    </div>
                    <div id="screenshot-preview" class="mt-2 hidden">
                      <img id="preview-image" class="max-w-full h-24 object-cover rounded border"
                        alt="Screenshot preview">
                      <button type="button" id="remove-screenshot"
                        class="mt-2 text-red-600 hover:text-red-800 text-sm underline cursor-pointer"
                        title="Remove screenshot">
                        Remove screenshot
                      </button>
                    </div>
                  </div>

                  <div class="flex space-x-2">
                    <button type="submit"
                      class="flex-1 bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 transition-colors">
                      Submit Report
                    </button>
                    <button type="button" id="cancel-bug-report"
                      class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                      Cancel
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Success Modal -->
          <div id="bugReportSuccessModal"
            class="fixed px-1 inset-0 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
            <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
              <div class="mt-3">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                  <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Bug Report Submitted!</h3>
                <p class="text-sm text-gray-500 text-center mb-6">Thank you for helping us improve. Your bug report
                  has been
                  successfully submitted and our team will review it shortly.</p>

                <div class="flex justify-center">
                  <button onclick="closeBugReportSuccessModal()"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                    Got it!
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE: Background Image -->
      <div class="relative hidden w-full h-full lg:block lg:w-1/2 bg-cover bg-center" style="
          background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                    url({{ asset('images/vet_service.jpg') }}) no-repeat center center;
          background-size: cover;
        ">
        <!-- Centered Content -->
        <div class="relative z-10 flex flex-col items-center justify-center w-full h-full p-8 text-center">
          <img src="{{ asset('images/orpawnage-logo.png') }}" alt="OrPAWnage Logo" class="w-40 mb-6" />
          <h2 class="text-3xl font-bold text-white"><span class="bg-black/20 relative overflow-hidden p-2">
              <span class="animate-color-change-orange">
                Or<strong class="animate-color-change-yellow">PAW</strong>nage
              </span>
              <span class="glowing-border"></span>
            </span></h2>
          <p class="mt-2 text-lg text-gray-300">Angeles City Veterinary Office</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Password Strength Script -->
  <script>
    const passwordInput = document.getElementById('password');
    const strengthText = document.getElementById('strength-text');
    const togglePassword = document.getElementById('toggle-password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    
    const reqLength = document.getElementById('req-length');
    const reqUpper = document.getElementById('req-uppercase');
    const reqLower = document.getElementById('req-lowercase');
    const reqNumber = document.getElementById('req-number');
    const reqSymbol = document.getElementById('req-symbol');
    
    const strengthProgress = document.getElementById('strength-progress');

    const updateRequirement = (condition, element) => {
      if (condition) {
        element.classList.add('text-green-600');
        element.classList.remove('text-blue-700');
      } else {
        element.classList.remove('text-green-600');
        element.classList.add('text-blue-700');
      }
    };

    const updateStrength = (password) => {
      const hasLength = password.length >= 6;
      const hasUpper = /[A-Z]/.test(password);
      const hasLower = /[a-z]/.test(password);
      const hasNumber = /[0-9]/.test(password);
      const hasSymbol = /[^A-Za-z0-9]/.test(password);
      
      updateRequirement(hasLength, reqLength);
      updateRequirement(hasUpper, reqUpper);
      updateRequirement(hasLower, reqLower);
      updateRequirement(hasNumber, reqNumber);
      updateRequirement(hasSymbol, reqSymbol);

      let strength = 0;
      if (hasLength) strength += 1;
      if (hasUpper) strength += 1;
      if (hasLower) strength += 1;
      if (hasNumber) strength += 1;
      if (hasSymbol) strength += 1;

      let progressPercentage = (strength / 5) * 100;
      strengthProgress.style.width = `${progressPercentage}%`;

      if (progressPercentage === 0) {
        strengthText.innerText = 'Start typing to see strength...';
        strengthProgress.style.backgroundColor = '#ef4444'; // Red
      } else if (progressPercentage < 40) {
        strengthText.innerText = 'Weak';
        strengthText.style.color = '#ef4444';
        strengthProgress.style.backgroundColor = '#ef4444'; // Red
      } else if (progressPercentage < 70) {
        strengthText.innerText = 'Medium';
        strengthText.style.color = '#f59e0b';
        strengthProgress.style.backgroundColor = '#f59e0b'; // Orange
      } else {
        strengthText.innerText = 'Strong';
        strengthText.style.color = '#10b981';
        strengthProgress.style.backgroundColor = '#10b981'; // Green
      }
    };

    passwordInput.addEventListener('input', () => {
      updateStrength(passwordInput.value);
    });

    togglePassword.addEventListener('click', () => {
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
  
      eyeOpen.classList.toggle('hidden');
      eyeClosed.classList.toggle('hidden');
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const bugReportLink = document.getElementById('bug-report-link');
        const bugReportModal = document.getElementById('bug-report-modal');
        const closeBugModal = document.getElementById('close-bug-modal');
        const cancelBugReport = document.getElementById('cancel-bug-report');
        const bugReportForm = document.getElementById('bug-report-form');
        const captureScreenshot = document.getElementById('capture-screenshot');
        const screenshotPreview = document.getElementById('screenshot-preview');
        const previewImage = document.getElementById('preview-image');
        const screenshotStatus = document.getElementById('screenshot-status');
        const removeScreenshot = document.getElementById('remove-screenshot');

        // Open modal
        bugReportLink.addEventListener('click', function(e) {
            e.preventDefault();
            bugReportModal.classList.remove('hidden');
        });

        // Close modal
        closeBugModal.addEventListener('click', function() {
            bugReportModal.classList.add('hidden');
        });

        cancelBugReport.addEventListener('click', function() {
            bugReportModal.classList.add('hidden');
        });

        // Close modal when clicking outside
        bugReportModal.addEventListener('click', function(e) {
            if (e.target === bugReportModal) {
                bugReportModal.classList.add('hidden');
            }
        });

        // Remove screenshot
        removeScreenshot.addEventListener('click', function() {
            // Clear the file input
            const fileInput = document.getElementById('bug-screenshot');
            fileInput.value = '';
            
            // Hide the preview
            screenshotPreview.classList.add('hidden');
            
            // Clear the status
            screenshotStatus.textContent = '';
            
            // Revoke the object URL to free memory
            if (previewImage.src && previewImage.src.startsWith('blob:')) {
                URL.revokeObjectURL(previewImage.src);
            }
        });

        // Function to replace oklch colors with safe fallbacks
        function replaceOklchColors(element) {
            // Handle inline styles
            if (element.hasAttribute('style')) {
                let style = element.getAttribute('style');
                if (style.includes('oklch')) {
                    // Replace oklch colors with hex equivalents
                    style = style.replace(/oklch\([^)]+\)/g, function(match) {
                        // Extract values from oklch function
                        const values = match.replace('oklch(', '').replace(')', '').split('/')[0].split(' ');
                        
                        if (values.length >= 3) {
                            const l = parseFloat(values[0]);
                            const c = parseFloat(values[1]);
                            const h = parseFloat(values[2]);
                            
                            // Simple conversion based on lightness
                            if (l > 0.6) return '#f3f4f6'; // light gray
                            if (l > 0.4) return '#9ca3af'; // medium gray
                            return '#4b5563'; // dark gray
                        }
                        
                        return '#3b82f6'; // default blue fallback
                    });
                    element.setAttribute('style', style);
                }
            }
            
            // Handle computed styles for elements without inline styles
            const computedStyle = window.getComputedStyle(element);
            
            // Check and replace color
            if (computedStyle.color.includes('oklch')) {
                element.style.color = '#3b82f6'; // Fallback blue
            }
            
            // Check and replace background color
            if (computedStyle.backgroundColor.includes('oklch')) {
                element.style.backgroundColor = '#f3f4f6'; // Fallback light gray
            }
            
            // Check and replace border color
            if (computedStyle.borderColor.includes('oklch')) {
                element.style.borderColor = '#d1d5db'; // Fallback border gray
            }
        }

        // Capture screenshot
        captureScreenshot.addEventListener('click', function() {
            // Hide the bug report modal before taking screenshot
            bugReportModal.classList.add('hidden');
            
            // Wait a moment for the modal to hide
            setTimeout(() => {
                // Capture the current viewport directly
                html2canvas(document.body, {
                    useCORS: true,
                    scale: 1,
                    backgroundColor: '#ffffff',
                    width: window.innerWidth,
                    height: window.innerHeight,
                    scrollX: -window.scrollX,
                    scrollY: -window.scrollY,
                    windowWidth: document.documentElement.offsetWidth,
                    windowHeight: document.documentElement.offsetHeight,
                    ignoreElements: (element) => {
                        // Ignore elements that might cause issues
                        return element.id === 'bug-report-modal' ||
                               element.id === 'bug-report-link' ||
                               element.classList.contains('fixed') ||
                               element.style.position === 'fixed';
                    },
                    onclone: (clonedDoc) => {
                        // Process all elements to replace oklch colors
                        const clonedElements = clonedDoc.querySelectorAll('*');
                        clonedElements.forEach(element => {
                            replaceOklchColors(element);
                        });
                        
                        // Remove fixed positioned elements from the clone
                        const fixedElements = clonedDoc.querySelectorAll('[style*="position: fixed"], [style*="position:fixed"], .fixed');
                        fixedElements.forEach(el => el.remove());
                    }
                }).then(canvas => {
                    // Convert canvas to blob
                    canvas.toBlob(function(blob) {
                        // Create file input and set the blob
                        const fileInput = document.getElementById('bug-screenshot');
                        const file = new File([blob], 'screenshot.png', { type: 'image/png' });
                        
                        // Create a new FileList-like object
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;
                        
                        // Show preview
                        const url = URL.createObjectURL(blob);
                        previewImage.src = url;
                        screenshotPreview.classList.remove('hidden');
                        screenshotStatus.textContent = 'Screenshot captured!';
                        screenshotStatus.className = 'text-sm text-green-600';
                        
                        // Show modal again
                        bugReportModal.classList.remove('hidden');
                    }, 'image/png');
                }).catch(error => {
                    console.error('Screenshot failed:', error);
                    screenshotStatus.textContent = 'Screenshot failed. Please try again.';
                    screenshotStatus.className = 'text-sm text-red-600';
                    bugReportModal.classList.remove('hidden');
                    
                    // Fallback: allow manual file upload
                    const fileInput = document.getElementById('bug-screenshot');
                    fileInput.click();
                });
            }, 100);
        });

        // Handle file input change for manual screenshot upload
        document.getElementById('bug-screenshot').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    screenshotPreview.classList.remove('hidden');
                    screenshotStatus.textContent = 'Screenshot uploaded!';
                    screenshotStatus.className = 'text-sm text-green-600';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Handle form submission
        bugReportForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('page_url', window.location.href);
            formData.append('user_agent', navigator.userAgent);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            fetch('/bug-report', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success modal
                    document.getElementById('bugReportSuccessModal').classList.remove('hidden');
                    
                    // Reset form and close modal
                    bugReportForm.reset();
                    screenshotPreview.classList.add('hidden');
                    screenshotStatus.textContent = '';
                    bugReportModal.classList.add('hidden');
                } else {
                    alert('Failed to submit bug report. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });


    });

    // Function to close success modal
    function closeBugReportSuccessModal() {
        document.getElementById('bugReportSuccessModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'bugReportSuccessModal') {
            closeBugReportSuccessModal();
        }
    });
  </script>

  <!-- Include html2canvas for screenshot functionality -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</x-auth-layout>