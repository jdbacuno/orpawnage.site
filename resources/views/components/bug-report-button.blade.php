<!-- Bug Report Floating Button -->
<div id="bug-report-container" class="fixed bottom-24 right-8 z-50">
    <!-- Floating Button -->
    <button id="bug-report-btn"
        class="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110"
        title="Report a Bug">
        <i class="ph-fill ph-bug text-lg"></i>
    </button>

    <!-- Bug Report Chatbox -->
    <div id="bug-report-chatbox"
        class="hidden fixed bottom-24 right-8 w-80 bg-white rounded-lg shadow-2xl border border-gray-200 z-50">
        <div class="bg-orange-500 text-white p-4 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold">Report a Bug</h3>
                <button id="close-bug-chatbox" class="text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-4">
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
                        <img id="preview-image" class="max-w-full h-32 object-cover rounded border"
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

    // Toggle chatbox
    bugReportBtn.addEventListener('click', function() {
        bugReportChatbox.classList.toggle('hidden');
    });

    // Close chatbox
    closeBugChatbox.addEventListener('click', function() {
        bugReportChatbox.classList.add('hidden');
    });

    cancelBugReport.addEventListener('click', function() {
        bugReportChatbox.classList.add('hidden');
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
        // Hide the bug report chatbox before taking screenshot
        bugReportChatbox.classList.add('hidden');
        
        // Wait a moment for the chatbox to hide
        setTimeout(() => {
            // Create a temporary container for the current viewport
            const viewportContainer = document.createElement('div');
            viewportContainer.style.position = 'fixed';
            viewportContainer.style.top = '0';
            viewportContainer.style.left = '0';
            viewportContainer.style.width = window.innerWidth + 'px';
            viewportContainer.style.height = window.innerHeight + 'px';
            viewportContainer.style.overflow = 'hidden';
            viewportContainer.style.zIndex = '-1';
            
            // Clone the body content
            const bodyClone = document.body.cloneNode(true);
            
            // Remove any fixed positioned elements that might interfere
            const fixedElements = bodyClone.querySelectorAll('[style*="position: fixed"], [style*="position:fixed"]');
            fixedElements.forEach(el => el.remove());
            
            // Process all elements to replace oklch colors
            const allElements = bodyClone.querySelectorAll('*');
            allElements.forEach(element => {
                replaceOklchColors(element);
            });
            
            // Position the cloned content to show current viewport
            bodyClone.style.position = 'absolute';
            bodyClone.style.top = (-window.scrollY) + 'px';
            bodyClone.style.left = (-window.scrollX) + 'px';
            bodyClone.style.width = document.body.scrollWidth + 'px';
            bodyClone.style.height = document.body.scrollHeight + 'px';
            
            viewportContainer.appendChild(bodyClone);
            document.body.appendChild(viewportContainer);
            
            // Use a simpler approach for html2canvas
            html2canvas(viewportContainer, {
                useCORS: true,
                scale: 1,
                backgroundColor: '#ffffff',
                width: window.innerWidth,
                height: window.innerHeight,
                scrollX: 0,
                scrollY: 0,
                ignoreElements: (element) => {
                    // Ignore elements that might cause issues
                    return element.classList.contains('bug-report-container') || 
                           element.id === 'bug-report-container' ||
                           element.closest('#bug-report-container');
                },
                onclone: (clonedDoc) => {
                    // Additional processing on the cloned document
                    const clonedElements = clonedDoc.querySelectorAll('*');
                    clonedElements.forEach(element => {
                        replaceOklchColors(element);
                    });
                }
            }).then(canvas => {
                // Remove the temporary container
                document.body.removeChild(viewportContainer);
                
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
                    
                    // Show chatbox again
                    bugReportChatbox.classList.remove('hidden');
                }, 'image/png');
            }).catch(error => {
                // Remove the temporary container on error
                if (document.body.contains(viewportContainer)) {
                    document.body.removeChild(viewportContainer);
                }
                
                console.error('Screenshot failed:', error);
                screenshotStatus.textContent = 'Screenshot failed. Please try again.';
                screenshotStatus.className = 'text-sm text-red-600';
                bugReportChatbox.classList.remove('hidden');
                
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
                
                // Reset form and close chatbox
                bugReportForm.reset();
                screenshotPreview.classList.add('hidden');
                screenshotStatus.textContent = '';
                bugReportChatbox.classList.add('hidden');
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