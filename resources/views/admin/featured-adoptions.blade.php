<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900" id="mainContent">Upload Successful Adoptions</h1>

  @if(session('success'))
  <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50" role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
      viewBox="0 0 20 20">
      <path
        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium">
      {{ session('success') }}
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

  <div class="py-6">
    <!-- Upload Form - Improved styling -->
    <div class="px-6 py-3 mb-8 bg-gray-50 rounded-lg border border-gray-200">
      <form action="{{ route('featured-adoptions.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Select Images</label>

          <!-- Hidden Input -->
          <input type="file" name="images[]" id="images_input" multiple accept="image/*" class="hidden" required>

          <!-- Preview Container -->
          <div id="imagesPreviews" class="my-2 grid grid-cols-4 gap-2"></div>

          <!-- Add More Button -->
          <button type="button" id="addImagesBtn"
            class="px-4 py-2 bg-orange-100 text-orange-700 text-sm font-medium rounded-md border border-orange-300 hover:bg-orange-200 transition w-fit flex items-center gap-2">
            <i class="ph-fill ph-plus-circle"></i> Add Images
          </button>

          <p class="text-xs text-gray-500 mt-1">Please upload clear photos of the successful adoptions.</p>
          <x-form-error name="images" />
        </div>

        <div class="flex justify-end">
          <button type="submit"
            class="px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 flex items-center">
            <i class="ph-fill ph-cloud-arrow-up mr-2"></i>
            Upload Images
          </button>
        </div>
      </form>
    </div>

    <!-- Month/Year Dropdown Filter -->
    @if ($featuredPets->count() > 0)
    <div class="mt-8 flex flex-col sm:flex-row justify-start gap-4 mb-6">
      <div class="w-full sm:w-auto">
        <select id="monthFilter"
          class="block w-full pl-4 pr-8 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
          <option value="all">All Months</option>
          @foreach($months as $month)
          <option value="{{ $month['value'] }}">{{ $month['name'] }}</option>
          @endforeach
        </select>
      </div>

      <div class="w-full sm:w-auto">
        <select id="yearFilter"
          class="block w-full pl-4 pr-8 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
          @foreach($years as $year)
          <option value="{{ $year }}">{{ $year }}</option>
          @endforeach
        </select>
      </div>
    </div>
    @endif

    <!-- Gallery - Improved layout -->
    @if($featuredPets->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No featured adoptions found.</p>
    </div>
    @else
    <div class="space-y-8">
      @foreach($featuredPets as $month => $images)
      <div class="month-section" id="{{ Str::slug($month) }}" data-month="{{ date('n', strtotime($month)) }}"
        data-year="{{ date('Y', strtotime($month)) }}">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-semibold text-gray-800">{{ $month }}</h3>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gallery-grid">
          @foreach($images as $image)
          <div
            class="gallery-item overflow-hidden rounded-lg shadow-md group cursor-pointer transition-all duration-300 hover:shadow-lg"
            data-src="{{ asset('storage/' . $image->image_path) }}" data-month="{{ date('n', strtotime($month)) }}"
            data-year="{{ date('Y', strtotime($month)) }}">
            <div class="relative aspect-square" onclick="openImageModal('{{ asset('storage/' . $image->image_path) }}')">
              <img src="{{ asset('storage/' . $image->image_path) }}" alt="Featured adoption"
                class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105"
                loading="lazy">
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
              <button type="button"
                class="absolute top-2 right-2 bg-white/90 hover:bg-white text-red-600 hover:text-red-700 rounded-full p-1 shadow hidden group-hover:block"
                title="Delete"
                onclick="event.stopPropagation(); confirmDelete('{{ route('featured-adoptions.destroy', $image) }}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2h12a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zm-3 6a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1zm4 0a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1zm5 1a1 1 0 10-2 0v6a1 1 0 102 0V9z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3 text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
          <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Confirm Deletion</h3>
        <div class="mt-2 px-7 py-3">
          <p class="text-sm text-gray-500">Are you sure you want to delete this image? This action cannot be undone.</p>
        </div>
        <div class="items-center px-4 py-3">
          <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" id="cancelDelete"
              class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 mr-2">
              Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
              Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Image Preview Modal -->
  <div id="imageModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-80 z-50 hidden">
    <button type="button" class="absolute top-4 right-4 text-white bg-black/40 hover:bg-black/60 rounded-full p-2"
      aria-label="Close preview" onclick="closeImageModal()">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 11-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
      </svg>
    </button>
    <div class="max-w-7xl w-full max-h-[90vh] flex items-center justify-center" onclick="closeImageModal()">
      <img id="modalImage" src="" alt="Preview" class="max-h-[90vh] max-w-full rounded-lg shadow-lg" onclick="event.stopPropagation()">
    </div>
  </div>

  <script>
    // Function to handle image uploads and previews
    function setupImageUpload(inputId, previewContainerId, addButtonId, maxFiles = 10) {
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
            img.className = 'h-32 w-full object-cover rounded-lg border border-gray-300';

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

    document.addEventListener('DOMContentLoaded', function() {
      // Initialize the image upload functionality
      setupImageUpload('images_input', 'imagesPreviews', 'addImagesBtn', 10);

      // Month/Year filter functionality
      const yearFilter = document.getElementById('yearFilter');
      const monthFilter = document.getElementById('monthFilter');
      
      function applyFilters() {
        const selectedYear = yearFilter.value;
        const selectedMonth = monthFilter.value;
        
        document.querySelectorAll('.month-section').forEach(section => {
          const sectionYear = section.getAttribute('data-year');
          const sectionMonth = section.getAttribute('data-month');
          
          const yearMatch = selectedYear === 'all' || sectionYear === selectedYear;
          const monthMatch = selectedMonth === 'all' || sectionMonth === selectedMonth;
          
          if (yearMatch && monthMatch) {
            section.classList.remove('hidden');
            section.querySelectorAll('.gallery-item').forEach(item => {
              item.classList.remove('hidden');
            });
          } else {
            section.classList.add('hidden');
            section.querySelectorAll('.gallery-item').forEach(item => {
              item.classList.add('hidden');
            });
          }
        });
      }
      
      yearFilter.addEventListener('change', applyFilters);
      monthFilter.addEventListener('change', applyFilters);
      
      // When year changes, update available months
      yearFilter.addEventListener('change', function() {
        const selectedYear = this.value;
        
        // Reset month filter
        monthFilter.value = 'all';
        
        if (selectedYear === 'all') {
          // Enable all month options
          Array.from(monthFilter.options).forEach(option => {
            option.disabled = false;
          });
        } else {
          // Disable months that don't have data for selected year
          const availableMonths = new Set();
          document.querySelectorAll(`.month-section[data-year="${selectedYear}"]`).forEach(section => {
            availableMonths.add(section.getAttribute('data-month'));
          });
          
          Array.from(monthFilter.options).forEach(option => {
            option.disabled = option.value !== 'all' && !availableMonths.has(option.value);
          });
        }
        
        applyFilters();
      });
    });

    // Image preview modal helpers
    function openImageModal(src) {
      const modal = document.getElementById('imageModal');
      const img = document.getElementById('modalImage');
      img.src = src;
      modal.classList.remove('hidden');

      // Escape to close
      function onKeydown(e) {
        if (e.key === 'Escape') {
          closeImageModal();
        }
      }
      window.addEventListener('keydown', onKeydown, { once: true });
    }

    function closeImageModal() {
      const modal = document.getElementById('imageModal');
      const img = document.getElementById('modalImage');
      img.src = '';
      modal.classList.add('hidden');
    }

    // Delete confirmation modal
    function confirmDelete(url) {
      const modal = document.getElementById('deleteModal');
      const form = document.getElementById('deleteForm');
      const cancelBtn = document.getElementById('cancelDelete');

      form.action = url;
      modal.classList.remove('hidden');

      cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
      });

      // Close modal when clicking outside
      window.addEventListener('click', (event) => {
        if (event.target === modal) {
          modal.classList.add('hidden');
        }
      });
    }
  </script>
</x-admin-layout>