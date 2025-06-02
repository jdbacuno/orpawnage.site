<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900" id="mainContent">Manage Office Staff</h1>

  <div class="mt-4">
    @if(session('add_success'))
    <div id="alert-3" class="flex items-center p-4 mb-1 text-green-800 rounded-lg bg-green-50 w-full md:w-1/2"
      role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">
        Staff member {{ session('add_success') }} added successfully!
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

    @if(session('edit_success'))
    <div id="alert-3" class="flex items-center p-4 mb-1 text-green-800 rounded-lg bg-green-50 w-full md:w-1/2"
      role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">
        Staff member {{ session('edit_success') }} updated successfully!
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

    @if(session('delete_success'))
    <div id="alert-3" class="flex items-center p-4 mb-1 text-green-800 rounded-lg bg-green-50 w-full md:w-1/2"
      role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">
        {{ session('delete_success') }}
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

    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800">Staff Members</h2>
      <button id="openModal"
        class="bg-yellow-400 text-black hover:bg-orange-500 hover:text-white font-semibold py-2 px-4 md:px-4 flex items-center justify-center md:rounded-md rounded-full w-10 h-10 md:w-auto md:h-auto">
        <i class="ph-fill ph-plus-circle"></i>
        <span class="hidden md:inline-flex ml-2">Add New Staff</span>
      </button>
    </div>

    @if($staff->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No staff members found.</p>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
      @foreach($staff as $member)
      <div class="group text-center">
        <div class="relative mb-4 overflow-hidden rounded-full w-24 h-24 mx-auto shadow-lg cursor-pointer staff-profile"
          data-id="{{ $member->id }}" data-name="{{ $member->name }}" data-position="{{ $member->position }}"
          data-image="{{ $member->image_path ? asset('storage/' . $member->image_path) : '' }}"
          data-featured="{{ $member->is_featured }}">
          <img
            src="{{ $member->image_path ? asset('storage/' . $member->image_path) : 'https://avatar.iran.liara.run/public/' . ($loop->index % 2 === 0 ? 'boy' : 'girl') }}"
            alt="{{ $member->name }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
          <div
            class="absolute inset-0 bg-orange-700/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <i class="ph-fill ph-pencil-simple text-white text-xl"></i>
          </div>
          @if($member->is_featured)
          <span
            class="absolute top-0 right-0 bg-yellow-400 text-black text-xs font-bold px-2 py-0.5 rounded-full transform translate-x-1 -translate-y-1">
            <i class="ph-fill ph-star"></i>
          </span>
          @endif
        </div>
        <h3 class="font-bold text-gray-800">{{ $member->name }}</h3>
        <p class="text-gray-600 text-sm">{{ $member->position }}</p>
      </div>
      @endforeach
    </div>
    @endif
  </div>

  <div id="modal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-hidden relative flex flex-col">
      <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x text-xl"></i>
      </button>

      <div class="flex flex-col overflow-y-auto scrollbar-hidden p-2 space-y-4 flex-grow">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center" id="modalTitle">
          <i class="ph-fill ph-plus-circle mr-2 text-orange-500"></i>Add New Staff
        </h2>

        <div class="flex justify-center relative">
          <p id="imagePlaceholder" class="absolute text-gray-500 text-sm">Image preview will appear here</p>
          <img id="imagePreview" src="" class="w-32 h-32 rounded-full object-cover border-4 border-orange-100 hidden"
            alt="Staff Image">
        </div>

        <form id="staffForm" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          <div id="formMethod"></div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Staff Photo</label>
            <input type="file" name="image" id="imageInput"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Full Name <span
                class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Position <span
                class="text-red-500">*</span></label>
            <input type="text" name="position" id="position" required
              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400">
          </div>

          <div class="mb-4 flex items-center">
            <input type="checkbox" name="is_featured" id="is_featured" class="mr-2">
            <label for="is_featured" class="text-sm text-gray-600">Feature on homepage (first 5 featured staff will be
              shown)</label>
          </div>

          <div class="flex justify-between pt-4">
            <button type="button" id="deleteStaffButton"
              class="px-5 bg-red-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-red-600 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg hidden">
              <i class="ph-fill ph-trash mr-2"></i>Delete
            </button>
            <button type="submit"
              class="w-full sm:w-fit px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg ml-auto">
              <i class="ph-fill ph-floppy-disk mr-2"></i>Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="deleteModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
          <i class="ph-fill ph-trash text-red-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Staff Member</h3>
        <p class="text-gray-600 text-center mb-6">Are you sure you want to delete <span id="staffNameToDelete"
            class="font-semibold"></span>? This action cannot be undone.</p>

        <div class="flex justify-center gap-4 w-full">
          <button id="cancelDelete"
            class="px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200">
            Cancel
          </button>
          <form id="deleteForm" method="POST" class="w-full sm:w-auto">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="w-full px-5 py-2.5 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition duration-200">
              Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modal');
            const deleteModal = document.getElementById('deleteModal');
            const openModalBtn = document.getElementById('openModal');
            const closeModalBtn = document.getElementById('closeModal');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const form = document.getElementById('staffForm');
            const deleteForm = document.getElementById('deleteForm');
            const formMethod = document.getElementById('formMethod');
            const modalTitle = document.getElementById('modalTitle');
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePlaceholder = document.getElementById('imagePlaceholder');
            const staffNameToDelete = document.getElementById('staffNameToDelete');
            const deleteStaffButton = document.getElementById('deleteStaffButton'); // New button for delete inside modal

            // Open modal for adding new staff
            openModalBtn.addEventListener('click', function() {
                form.reset();
                form.action = "{{ route('office-staff.store') }}";
                formMethod.innerHTML = '';
                modalTitle.innerHTML = '<i class="ph-fill ph-plus-circle mr-2 text-orange-500"></i>Add New Staff';
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
                imagePlaceholder.classList.remove('hidden');
                document.getElementById('is_featured').checked = false;
                deleteStaffButton.classList.add('hidden'); // Hide delete button for add
                modal.classList.remove('hidden');
            });

            // Close modals
            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            cancelDeleteBtn.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
            });

            // Open modal for editing staff when profile is clicked
            document.querySelectorAll('.staff-profile').forEach(profile => {
                profile.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const position = this.getAttribute('data-position');
                    const image = this.getAttribute('data-image');
                    const featured = this.getAttribute('data-featured') === '1';

                    form.action = `/admin/office-staff/${id}`;
                    formMethod.innerHTML = `@method('PUT')`;
                    modalTitle.innerHTML = '<i class="ph-fill ph-pencil-simple mr-2 text-orange-500"></i>Edit Staff Member';

                    document.getElementById('name').value = name;
                    document.getElementById('position').value = position;
                    document.getElementById('is_featured').checked = featured;

                    if (image) {
                        imagePreview.src = image;
                        imagePreview.classList.remove('hidden');
                        imagePlaceholder.classList.add('hidden');
                    } else {
                        imagePreview.src = '';
                        imagePreview.classList.add('hidden');
                        imagePlaceholder.classList.remove('hidden');
                    }
                    
                    deleteStaffButton.classList.remove('hidden'); // Show delete button for edit
                    modal.classList.remove('hidden');

                    // Set up delete button within the edit modal
                    deleteStaffButton.onclick = function() {
                        staffNameToDelete.textContent = name;
                        deleteForm.action = `/admin/office-staff/${id}`;
                        modal.classList.add('hidden'); // Hide edit modal
                        deleteModal.classList.remove('hidden'); // Show delete confirmation modal
                    };
                });
            });

            // Image upload handling
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        imagePlaceholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Universal alert dismiss functionality
            document.querySelectorAll('[data-dismiss-target]').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-dismiss-target');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.style.display = 'none'; // Or targetElement.remove();
                    }
                });
            });
        });
  </script>
</x-admin-layout>