<x-auth-layout>
  <div class="relative p-6 bg-white z-1 sm:p-0">
    <div class="relative flex flex-col justify-center w-full h-screen sm:p-0 lg:flex-row">
      <!-- LEFT SIDE: Form -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2 left-content">
        <div
          class="flex flex-col justify-start sm:justify-center flex-1 w-full max-w-md mx-auto py-8 sm:py-0 px-4 sm:px-6">
          <div class="space-y-8">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-8">
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
            <div class="text-sm text-gray-500">
              Remember your password? <a href="{{ route('login') }}"
                class="font-medium text-blue-600 hover:text-blue-500">Sign in</a>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE: Background Image -->
      <div class="relative hidden w-full h-full lg:block lg:w-1/2 bg-cover bg-center right-content" style="
          background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                    url({{ asset('images/register-img.jpg') }}) no-repeat center center;
          background-size: cover;
        ">
        <!-- Centered Content -->
        <div class="relative z-10 flex flex-col items-center justify-center w-full h-full p-8 text-center">
          <img src="{{ asset('images/orpawnage-logo.png') }}" alt="OrPAWnage Logo" class="w-40 mb-6" />
          <h2 class="text-3xl font-bold text-white"><span class="bg-black/20 relative overflow-hidden p-2">
              <span class="animate-color-change-orange">
                OR<strong class="animate-color-change-yellow">PAW</strong>NAGE
              </span>
              <span class="glowing-border"></span>
            </span></h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Bug Report Floating Button - OUTSIDE all containers -->
  <div style="position: fixed; bottom: 32px; right: 32px; z-index: 9999;">
    <!-- Floating Button -->
    <button id="bug-report-btn"
      style="background-color: #ef4444; color: white; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: all 0.3s ease;"
      title="Report a Bug" onmouseover="this.style.backgroundColor='#dc2626'; this.style.transform='scale(1.1)'"
      onmouseout="this.style.backgroundColor='#ef4444'; this.style.transform='scale(1)'">
      <!-- Bug Icon -->
      <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24">
        <path
          d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5c-.49 0-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20zm-6 8h-4v-2h4v2zm0-4h-4v-2h4v2z" />
      </svg>
    </button>

    <!-- Bug Report Chatbox -->
    <div id="bug-report-chatbox"
      style="display: none; position: fixed; bottom: 90px; right: 32px; width: 320px; background: white; border-radius: 8px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid #e5e7eb; z-index: 9999; max-height: 384px; flex-direction: column;">
      <div style="background-color: #f97316; color: white; padding: 16px; border-radius: 8px 8px 0 0; flex-shrink: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h3 style="font-weight: 600; margin: 0;">Report an Issue</h3>
          <button id="close-bug-chatbox"
            style="color: white; background: none; border: none; cursor: pointer; padding: 0;"
            onmouseover="this.style.color='#d1d5db'" onmouseout="this.style.color='white'">
            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
      <form id="bug-report-form" style="display: flex; flex-direction: column; flex: 1; overflow: hidden;"
        enctype="multipart/form-data">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div style="flex: 1; overflow-y: auto; padding: 16px;">
          <div style="margin-bottom: 16px;">
            <label for="bug-description"
              style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
              Describe the issue you encountered:
            </label>
            <textarea id="bug-description" name="description" rows="4"
              style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical; box-sizing: border-box;"
              placeholder="Please describe what happened, what you expected to happen, and any error messages you saw..."
              required></textarea>
          </div>

          <div style="margin-bottom: 16px;">
            <label for="bug-screenshot"
              style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">
              Screenshot (optional):
            </label>
            <div style="display: flex; align-items: center; gap: 8px;">
              <button type="button" id="capture-screenshot"
                style="display: flex; align-items: center; padding: 8px 12px; background-color: #3b82f6; color: white; font-size: 14px; border-radius: 6px; border: none; cursor: pointer;"
                title="Captures only what you can currently see on screen">
                <svg style="width: 16px; height: 16px; margin-right: 4px;" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5a3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97c0-.33-.03-.66-.07-1L21.54 10c.88-.07 1.46-1.07 1.46-2s-.58-1.93-1.46-2L19.43 5c.04-.34.07-.67.07-1c0-.33-.03-.65-.07-.97l2.11-1c.88-.07 1.46-1.07 1.46-2s-.58-1.93-1.46-2L19.43 0c.04-.33.07-.66.07-.97C19.5.69 18.81 0 18 0H6C5.19 0 4.5.69 4.5 1.53c0 .31.03.64.07.97L2.46 3.5C1.58 3.57 1 4.57 1 5.5s.58 1.93 1.46 2L4.57 9c-.04.34-.07.67-.07 1c0 .33.03.66.07 1L2.46 12c-.88.07-1.46 1.07-1.46 2s.58 1.93 1.46 2L4.57 17c-.04.33-.07.66-.07.97C4.5 18.31 5.19 19 6 19h12c.81 0 1.5-.69 1.5-1.53c0-.31-.03-.64-.07-.97L21.54 16c.88-.07 1.46-1.07 1.46-2s-.58-1.93-1.46-2" />
                </svg>
                Capture Current View
              </button>
              <input type="file" id="bug-screenshot" name="screenshot" accept="image/*" style="display: none;">
              <span id="screenshot-status" style="font-size: 14px; color: #6b7280;"></span>
            </div>
            <div id="screenshot-preview" style="margin-top: 8px; display: none;">
              <img id="preview-image"
                style="max-width: 100%; height: 128px; object-fit: cover; border-radius: 4px; border: 1px solid #d1d5db;"
                alt="Screenshot preview">
              <button type="button" id="remove-screenshot"
                style="margin-top: 8px; color: #dc2626; background: none; border: none; font-size: 14px; text-decoration: underline; cursor: pointer;"
                title="Remove screenshot">
                Remove screenshot
              </button>
            </div>
          </div>
        </div>
        <div style="padding: 16px; border-top: 1px solid #e5e7eb; display: flex; gap: 8px; background-color: #f9fafb;">
          <button type="submit"
            style="flex: 1; background-color: #f97316; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer;">
            Submit Report
          </button>
          <button type="button" id="cancel-bug-report"
            style="padding: 8px 16px; color: #6b7280; border: 1px solid #d1d5db; border-radius: 6px; background: white; cursor: pointer;">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Success Modal -->
  <div id="bugReportSuccessModal"
    class="fixed px-1 inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Bug Report Submitted!</h3>
        <p class="text-sm text-gray-500 text-center mb-6">Thank you for helping us improve. Your bug report has been
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

  <!-- Bug Report JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const bugReportBtn = document.getElementById('bug-report-btn');
        const bugReportChatbox = document.getElementById('bug-report-chatbox');
        const closeBugChatbox = document.getElementById('close-bug-chatbox');
        const cancelBugReport = document.getElementById('cancel-bug-report');
        const bugReportForm = document.getElementById('bug-report-form');
        const captureScreenshot = document.getElementById('capture-screenshot');
        const screenshotPreview = document.getElementById('screenshot-preview');
        const previewImage = document.getElementById('preview-image');
        const screenshotStatus = document.getElementById('screenshot-status');
        const removeScreenshot = document.getElementById('remove-screenshot');

        // Prevent multiple submissions
        let isSubmitting = false;

        // Toggle chatbox
        bugReportBtn.addEventListener('click', function() {
            if (bugReportChatbox.style.display === 'none' || bugReportChatbox.style.display === '') {
                bugReportChatbox.style.display = 'flex';
            } else {
                bugReportChatbox.style.display = 'none';
            }
        });

        // Close chatbox
        closeBugChatbox.addEventListener('click', function() {
            bugReportChatbox.style.display = 'none';
        });

        cancelBugReport.addEventListener('click', function() {
            bugReportChatbox.style.display = 'none';
        });

        // Remove screenshot
        removeScreenshot.addEventListener('click', function() {
            // Clear the file input
            const fileInput = document.getElementById('bug-screenshot');
            fileInput.value = '';
            
            // Hide the preview
            screenshotPreview.style.display = 'none';
            
            // Clear the status
            screenshotStatus.textContent = '';
            
            // Revoke the object URL to free memory
            if (previewImage.src && previewImage.src.startsWith('blob:')) {
                URL.revokeObjectURL(previewImage.src);
            }
        });

        // Enhanced screenshot capture function
        captureScreenshot.addEventListener('click', function() {
            // Disable the capture button to prevent multiple clicks
            captureScreenshot.disabled = true;
            captureScreenshot.textContent = 'Capturing...';
            
            // Hide the bug report chatbox before taking screenshot
            bugReportChatbox.style.display = 'none';
            
            // Wait for the chatbox to hide and UI to settle
            setTimeout(() => {
                // Get current viewport dimensions and scroll position
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;
                const scrollX = window.pageXOffset || document.documentElement.scrollLeft;
                const scrollY = window.pageYOffset || document.documentElement.scrollTop;
                
                // Use html2canvas to capture the current viewport
                html2canvas(document.body, {
                    useCORS: true,
                    allowTaint: false,
                    scale: 1,
                    backgroundColor: '#ffffff',
                    width: viewportWidth,
                    height: viewportHeight,
                    x: scrollX,
                    y: scrollY,
                    scrollX: 0,
                    scrollY: 0,
                    windowWidth: viewportWidth,
                    windowHeight: viewportHeight,
                    ignoreElements: (element) => {
                        // Ignore bug report related elements and other overlays
                        return element.id === 'bug-report-btn' ||
                              element.id === 'bug-report-chatbox' ||
                              element.id === 'bug-report-container' ||
                              element.closest('#bug-report-container') ||
                              element.classList.contains('bug-report-element') ||
                              // Ignore other potential overlay elements
                              element.classList.contains('modal') ||
                              element.classList.contains('tooltip') ||
                              element.classList.contains('dropdown') ||
                              // Ignore fixed positioned elements that might be overlays
                              (getComputedStyle(element).position === 'fixed' && 
                                element.id !== 'main-header' && 
                                !element.closest('#main-header'));
                    },
                    onclone: (clonedDoc, element) => {
                        // Process cloned document
                        const clonedElements = clonedDoc.querySelectorAll('*');
                        clonedElements.forEach(el => {
                            // Remove any bug report elements that might have been cloned
                            if (el.id === 'bug-report-btn' || 
                                el.id === 'bug-report-chatbox' || 
                                el.id === 'bug-report-container' ||
                                el.closest('#bug-report-container')) {
                                el.remove();
                            }
                            
                            // Handle oklch colors for better compatibility
                            replaceOklchColors(el);
                        });
                        
                        // Set the cloned body to show the current viewport
                        const clonedBody = clonedDoc.body;
                        clonedBody.style.transform = `translate(-${scrollX}px, -${scrollY}px)`;
                        clonedBody.style.width = document.body.scrollWidth + 'px';
                        clonedBody.style.height = document.body.scrollHeight + 'px';
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
                        screenshotPreview.style.display = 'block';
                        screenshotStatus.textContent = 'Screenshot captured!';
                        screenshotStatus.style.color = '#059669';
                        
                        // Show chatbox again
                        bugReportChatbox.style.display = 'flex';
                    }, 'image/png');
                }).catch(error => {
                    console.error('Screenshot failed:', error);
                    screenshotStatus.textContent = 'Screenshot failed. Please try again.';
                    screenshotStatus.style.color = '#dc2626';
                    bugReportChatbox.style.display = 'flex';
                    
                    // Fallback: allow manual file upload
                    const fileInput = document.getElementById('bug-screenshot');
                    fileInput.click();
                }).finally(() => {
                    // Re-enable the capture button
                    captureScreenshot.disabled = false;
                    captureScreenshot.innerHTML = `
                        <svg style="width: 16px; height: 16px; margin-right: 4px;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5a3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97c0-.33-.03-.66-.07-1L21.54 10c.88-.07 1.46-1.07 1.46-2s-.58-1.93-1.46-2L19.43 5c.04-.34.07-.67.07-1c0-.33-.03-.65-.07-.97l2.11-1c.88-.07 1.46-1.07 1.46-2s-.58-1.93-1.46-2L19.43 0c.04-.33.07-.66.07-.97C19.5.69 18.81 0 18 0H6C5.19 0 4.5.69 4.5 1.53c0 .31.03.64.07.97L2.46 3.5C1.58 3.57 1 4.57 1 5.5s.58 1.93 1.46 2L4.57 9c-.04.34-.07.67-.07 1c0 .33.03.66.07 1L2.46 12c-.88.07-1.46 1.07-1.46 2s.58 1.93 1.46 2L4.57 17c-.04.33-.07.66-.07.97C4.5 18.31 5.19 19 6 19h12c.81 0 1.5-.69 1.5-1.53c0-.31-.03-.64-.07-.97L21.54 16c.88-.07 1.46-1.07 1.46-2s-.58-1.93-1.46-2"/>
                        </svg>
                        Capture Current View
                    `;
                });
            }, 150); // Slightly longer delay to ensure UI settles
        });

        // Handle file input change for manual screenshot upload
        document.getElementById('bug-screenshot').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    screenshotPreview.style.display = 'block';
                    screenshotStatus.textContent = 'Screenshot uploaded!';
                    screenshotStatus.style.color = '#059669';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Enhanced form submission with duplicate prevention
        bugReportForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Prevent double submission
            if (isSubmitting) {
                return false;
            }
            
            isSubmitting = true;
            
            const formData = new FormData(this);
            formData.append('page_url', window.location.href);
            formData.append('user_agent', navigator.userAgent);
            formData.append('screen_resolution', `${window.screen.width}x${window.screen.height}`);
            formData.append('viewport_size', `${window.innerWidth}x${window.innerHeight}`);
            formData.append('timestamp', new Date().toISOString());
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;
            
            // Disable all form inputs to prevent changes during submission
            const formInputs = this.querySelectorAll('input, textarea, button');
            formInputs.forEach(input => input.disabled = true);
            
            fetch('/bug-report', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success modal
                    document.getElementById('bugReportSuccessModal').classList.remove('hidden');
                    
                    // Reset form and close chatbox
                    this.reset();
                    screenshotPreview.style.display = 'none';
                    screenshotStatus.textContent = '';
                    bugReportChatbox.style.display = 'none';
                } else {
                    throw new Error(data.message || 'Failed to submit bug report');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the bug report. Please try again.');
            })
            .finally(() => {
                // Reset button and form state
                submitBtn.textContent = originalText;
                
                // Re-enable all form inputs
                formInputs.forEach(input => input.disabled = false);
                
                isSubmitting = false;
            });
            
            return false;
        });

        // Function to replace oklch colors with safe fallbacks
        function replaceOklchColors(element) {
            if (!element || !element.style) return;
            
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
            try {
                const computedStyle = window.getComputedStyle(element);
                
                // Check and replace color
                if (computedStyle.color && computedStyle.color.includes('oklch')) {
                    element.style.color = '#3b82f6'; // Fallback blue
                }
                
                // Check and replace background color
                if (computedStyle.backgroundColor && computedStyle.backgroundColor.includes('oklch')) {
                    element.style.backgroundColor = '#f3f4f6'; // Fallback light gray
                }
                
                // Check and replace border color
                if (computedStyle.borderColor && computedStyle.borderColor.includes('oklch')) {
                    element.style.borderColor = '#d1d5db'; // Fallback border gray
                }
            } catch (e) {
                // Ignore errors from getComputedStyle on some elements
            }
        }
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

    // Prevent form resubmission on page refresh
    window.addEventListener('beforeunload', function() {
        // Clear any ongoing submissions
        isSubmitting = false;
    });
  </script>

  <!-- Include html2canvas for screenshot functionality -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</x-auth-layout>
