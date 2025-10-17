<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Team Members</h1>

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

  <!-- Add New Staff Button -->
  <div class="flex flex-wrap justify-between items-center gap-4 my-4">
    <!-- Search Bar -->
    <div class="relative">
      <!-- Replace the current search div with this form -->
      <form method="GET" action="{{ route('team.management') }}" class="relative">
        <input type="text" name="search" placeholder="Search by email or name" value="{{ request('search') }}"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 pl-10 pr-10">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <i class="ph-fill ph-magnifying-glass text-gray-500"></i>
        </div>
        @if(request('search'))
        <a href="{{ route('team.management') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center">
          <i class="ph-fill ph-x text-gray-500 hover:text-gray-700"></i>
        </a>
        @endif
      </form>
    </div>

    <button id="openModal"
      class="bg-yellow-400 text-black hover:bg-orange-500 hover:text-white font-semibold py-2 px-4 flex items-center rounded-md">
      <i class="ph-fill ph-plus-circle"></i>
      <span class="ml-2">Add a Member</span>
    </button>
  </div>

  @if($staff->isEmpty())
  <div class="flex items-center justify-center p-6 text-gray-500">
    <p class="text-lg">No staff members found.</p>
  </div>
  @else
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="staffGrid">
    @foreach($staff as $member)
    <div
      class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 text-center draggable-item"
      draggable="true" data-id="{{ $member->id }}" data-order="{{ $member->order }}">
      <!-- Staff Image - Rounded Design -->
      <div class="relative mb-4 rounded-full w-32 h-32 mx-auto group cursor-pointer"
        onclick="openEditModal({{ $member->id }})">
        <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}"
          class="w-full h-full object-cover rounded-full duration-500" />
        <div
          class="absolute inset-0 bg-orange-700/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
      </div>

      <!-- Staff Info -->
      <h3 class="font-bold text-lg">{{ $member->name }}</h3>
      <p class="text-gray-600 text-sm">{{ $member->position }}</p>
      @if($member->email)
      <p class="text-xs text-gray-500 mt-1">{{ $member->email }}</p>
      @endif
    </div>
    @endforeach
  </div>
  @endif

  @if($staff->hasPages())
  <div class="mt-8">
    {{ $staff->appends(['search' => request('search')])->links() }}
  </div>
  @endif

  <!-- Add Staff Modal -->
  <div id="addModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[75vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeAddModal" class="absolute top-4 right-4 text-gray-600 hover:text-black z-10">
        <i class="ph-bold ph-x text-xl"></i>
      </button>

      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
          <i class="ph-fill ph-plus-circle mr-2 text-orange-500"></i>Add New Staff Member
        </h2>
      </div>

      <!-- Modal Content -->
      <div class="overflow-y-auto scrollbar-hidden flex-grow p-6">
        <div class="flex flex-col lg:flex-row gap-6">
          <!-- Image Preview -->
          <div class="lg:w-64 flex-shrink-0 bg-gray-50 rounded-lg p-6 flex flex-col items-center justify-center">
            <div class="text-center">
              <div class="mb-4 relative">
                <div id="imagePlaceholder"
                  class="w-48 h-48 rounded-full border-4 border-dashed border-gray-300 bg-gray-100 flex items-center justify-center mx-auto">
                  <div class="text-center">
                    <i class="ph-light ph-image text-3xl text-gray-400 mb-2"></i>
                    <p class="text-xs text-gray-500">Image preview will appear here</p>
                  </div>
                </div>
                <img id="imagePreview" src=""
                  class="w-48 h-48 object-cover rounded-full border-4 border-white shadow-lg mx-auto hidden"
                  alt="Staff Image">
              </div>
              <p class="text-xs text-gray-500 italic">Profile Image Preview</p>
            </div>
          </div>

          <!-- Form -->
          <div class="flex-1">
            <form method="POST" id="addStaffForm" action="{{ route('office-staff.store') }}"
              enctype="multipart/form-data" class="space-y-4">
              @csrf

              <!-- Image Upload -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Profile Image</label>
                <input type="file" name="image" id="imageInput"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
              </div>

              <!-- Name -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Full Name <span
                    class="text-red-500">*</span></label>
                <input type="text" name="name" placeholder="Staff member's full name"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
              </div>

              <!-- Position -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Position <span
                    class="text-red-500">*</span></label>
                <input type="text" name="position" placeholder="Staff member's position"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
                <input type="email" name="email" placeholder="Staff member's email (optional)"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400">
              </div>

              <!-- Submit Button -->
              <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit"
                  class="w-full sm:w-fit px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                  <i class="ph-fill ph-plus-circle mr-2"></i>Add Staff Member
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Staff Modal -->
  <div id="editModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[75vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeEditModal" class="absolute top-4 right-4 text-gray-600 hover:text-black z-10">
        <i class="ph-bold ph-x text-xl"></i>
      </button>

      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
          <i class="ph-fill ph-pencil-simple mr-2 text-orange-500"></i>Edit Staff Member
        </h2>
      </div>

      <!-- Modal Content -->
      <div class="overflow-y-auto scrollbar-hidden flex-grow p-6">
        <div class="flex flex-col lg:flex-row gap-6">
          <!-- Image Preview -->
          <div class="lg:w-64 flex-shrink-0 bg-gray-50 rounded-lg p-6 flex flex-col items-center justify-center">
            <div class="text-center">
              <div class="mb-4">
                <img id="editImagePreview" src=""
                  class="w-48 h-48 object-cover rounded-full border-4 border-white shadow-lg mx-auto" alt="Staff Image">
              </div>
              <p class="text-xs text-gray-500 italic">Profile Image Preview</p>
            </div>
          </div>

          <!-- Form -->
          <div class="flex-1">
            <form method="POST" id="editStaffForm" action="" enctype="multipart/form-data" class="space-y-4">
              @csrf
              @method('PATCH')

              <!-- Image Upload -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Update Profile Image</label>
                <input type="file" name="image" id="editImageInput"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
              </div>

              <!-- Name -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Full Name <span
                    class="text-red-500">*</span></label>
                <input type="text" name="name" id="editName"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
              </div>

              <!-- Position -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Position <span
                    class="text-red-500">*</span></label>
                <input type="text" name="position" id="editPosition"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
                <input type="email" name="email" id="editEmail" placeholder="Staff member's email (optional)"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400">
              </div>

              <!-- Submit and Delete Buttons -->
              <div class="flex flex-col sm:flex-row justify-between gap-3 pt-4 border-t border-gray-200">
                <!-- Delete Button -->
                <button id="deleteStaffBtn" type="button"
                  class="w-full sm:w-fit px-5 py-2.5 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                  <i class="ph-fill ph-trash mr-2"></i>Delete Staff Member
                </button>

                <!-- Save Button -->
                <button type="submit"
                  class="w-full sm:w-fit px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                  <i class="ph-fill ph-floppy-disk mr-2"></i>Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeDeleteModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 flex items-center">
        <i class="ph-fill ph-warning mr-2 text-red-500"></i>Confirm Deletion
      </h2>

      <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg mt-4">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <i class="ph-fill ph-warning text-red-500 text-xl"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-red-700">
              Are you sure you want to delete this staff member? This action cannot be undone.
            </p>
          </div>
        </div>
      </div>

      <form id="deleteStaffForm" method="POST" action="" class="mt-6">
        @csrf
        @method('DELETE')

        <div class="flex justify-end space-x-3 mt-6">
          <button type="button" id="cancelDelete"
            class="px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-300">
            Cancel
          </button>
          <button type="submit"
            class="px-4 py-2.5 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-300 flex items-center">
            <i class="ph-fill ph-trash mr-2"></i>Delete
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Image Preview for Add Modal
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('imagePlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Image Preview for Edit Modal
    document.getElementById('editImageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('editImagePreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    function openEditModal(staffId) {
        // Get the staff member data from a data attribute on the clicked element
        const staffElement = document.querySelector(`[data-id="${staffId}"]`);
        if (!staffElement) return;

        // Get the image path from the img src (remove the asset path)
        const imgSrc = staffElement.querySelector('img').src;
        const imagePath = imgSrc.replace("{{ asset('storage/') }}/", '');

        // Get other data from data attributes or text content
        const name = staffElement.querySelector('h3').textContent;
        const position = staffElement.querySelector('p.text-gray-600').textContent;
        const email = staffElement.querySelector('p.text-xs.text-gray-500')?.textContent || '';

        // Populate the edit modal
        document.getElementById('editImagePreview').src = imgSrc;
        document.getElementById('editName').value = name;
        document.getElementById('editPosition').value = position;
        document.getElementById('editEmail').value = email;

        document.getElementById('editStaffForm').action = `/admin/office-staff/${staffId}`;
        document.getElementById('deleteStaffForm').action = `/admin/office-staff/${staffId}`;

        document.getElementById('editModal').classList.remove('hidden');
    }

    // Modal Controls
    document.getElementById('openModal').addEventListener('click', function() {
        document.getElementById('addModal').classList.remove('hidden');
    });

    document.getElementById('closeAddModal').addEventListener('click', function() {
        document.getElementById('addModal').classList.add('hidden');
    });

    document.getElementById('closeEditModal').addEventListener('click', function() {
        document.getElementById('editModal').classList.add('hidden');
    });

    document.getElementById('deleteStaffBtn').addEventListener('click', function() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('hidden');
    });

    document.getElementById('closeDeleteModal').addEventListener('click', function() {
        document.getElementById('deleteModal').classList.add('hidden');
    });

    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteModal').classList.add('hidden');
    });

    // Drag and Drop Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('staffGrid');
        let draggedItem = null;

        // Add event listeners for drag and drop
        document.querySelectorAll('.draggable-item').forEach(item => {
            item.addEventListener('dragstart', function() {
                draggedItem = this;
                setTimeout(() => {
                    this.style.opacity = '0.5';
                }, 0);
            });

            item.addEventListener('dragend', function() {
                setTimeout(() => {
                    this.style.opacity = '1';
                    draggedItem = null;
                }, 0);
            });

            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                const afterElement = getDragAfterElement(grid, e.clientY);
                if (afterElement == null) {
                    grid.appendChild(draggedItem);
                } else {
                    grid.insertBefore(draggedItem, afterElement);
                }
            });
        });

        // Handle drop to update order
        grid.addEventListener('drop', function(e) {
            e.preventDefault();
            const items = Array.from(document.querySelectorAll('.draggable-item'));

            // Update the order numbers based on new positions
            items.forEach((item, index) => {
                const newOrder = index + 1;
                const currentOrder = parseInt(item.dataset.order);

                if (newOrder !== currentOrder) {
                    // Update the order badge immediately
                    item.dataset.order = newOrder;

                    // Send AJAX request to update order in database
                    updateStaffOrder(item.dataset.id, newOrder);
                }
            });
        });

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.draggable-item:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

        function updateStaffOrder(staffId, newOrder) {
            fetch(`/admin/office-staff/${staffId}/update-order`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ order: newOrder })
            })
            .then(response => {
                if (!response.ok) {
                    console.error('Failed to update order');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
  </script>
</x-admin-layout>
