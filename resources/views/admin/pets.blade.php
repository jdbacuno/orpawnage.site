<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Pet Profiles</h1>

  <div class="bg-white p-6 shadow-md rounded-lg mt-4">
    <!-- Add New Pet Button -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800">Pet Profiles</h2>
      <!-- Add New Pet Button -->
      <button id="openModal"
        class="bg-yellow-500 hover:bg-orange-500 text-black font-semibold py-2 px-4 md:px-4 flex items-center justify-center md:rounded-md rounded-full w-10 h-10 md:w-auto md:h-auto">
        <i class="ph-fill ph-plus-circle"></i>
        <span class="hidden md:inline-flex ml-2">Add a New Pet</span>
      </button>
    </div>

    <!-- Pet Profiles Table -->
    <div class="overflow-x-auto">
      <table class="w-full border border-gray-200 rounded-lg">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="py-2 px-4 text-left">Pet No.</th>
            <th class="py-2 px-4 text-left">Image</th>
            <th class="py-2 px-4 text-left">Species</th>
            <th class="py-2 px-4 text-left">Breed</th>
            <th class="py-2 px-4 text-left">Age</th>
            <th class="py-2 px-4 text-left">Sex</th>
            <th class="py-2 px-4 text-left">Color</th>
            <th class="py-2 px-4 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pets as $pet)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-2 px-4">
              <a href="/services/{{ $pet->slug }}/adoption-form"
                class="text-black p-2 text-blue-500 hover:text-blue-600 hover:underline" target="_blank">#{{
                $pet->pet_number }}</a>
            </td>
            <td class="py-2 px-4">
              <img src="{{ asset('storage/' . $pet->image_path) }}" alt="Pet Image"
                class="w-12 h-12 rounded-full object-cover">
            </td>
            <td class="py-2 px-4">{{ ucfirst($pet->species) }}</td>
            <td class="py-2 px-4">{{ ucfirst($pet->breed) }}</td>
            <td class="py-2 px-4">{{ $pet->age }} {{ $pet->age_unit }}</td>
            <td class="py-2 px-4">{{ ucfirst($pet->sex) }}</td>
            <td class="py-2 px-4">{{ ucfirst($pet->color) }}</td>
            <td class="py-2 px-4 text-center">
              <a href="#" class="text-blue-500 hover:text-blue-600 mr-4 edit-btn" data-id="{{ $pet->id }}"
                data-number="{{ $pet->pet_number }}" data-species="{{ $pet->species }}" data-breed="{{ $pet->breed }}"
                data-age="{{ $pet->age }}" data-age-unit="{{ $pet->age_unit }}" data-sex="{{ $pet->sex }}"
                data-color="{{ $pet->color }}" data-image="{{ asset('storage/' . $pet->image_path) }}">
                <i class="ph-fill ph-pencil-simple"></i>
              </a>
              <button class="text-red-500 hover:text-red-600 delete-btn" data-id="{{ $pet->id }}"
                data-number="{{ $pet->pet_number }}">
                <i class="ph-fill ph-trash"></i>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      {{ $pets->links() }}
      <!-- Laravel default pagination links -->
    </div>


  </div>

  <!-- Add a New Pet Modal (Initially Hidden) -->
  <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 
    {{ session('modal_open') === 'add' ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x"></i>
      </button>

      <!-- Scrollable Content -->
      <div class="flex flex-col overflow-y-auto p-2 space-y-4 flex-grow">
        <!-- Form Title -->
        <h2 class="text-xl font-semibold text-gray-800">Add a New Pet</h2>

        <!-- Image Preview -->
        <div class="flex justify-center relative">
          <p id="imagePlaceholder" class="absolute text-gray-500 text-sm">Image preview here...</p>
          <img id="imagePreview" src="" class="w-full h-auto object-cover rounded-lg border border-gray-300 hidden"
            alt="Pet Image">
        </div>

        <!-- Form Fields -->
        <form method="POST" action="/admin/pet-profiles" enctype="multipart/form-data" class="space-y-4">
          @csrf

          @if (session('add_success'))
          <div id="alert-3"
            class="flex items-center p-4 my-3 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 sm:col-span-7 add-success"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              {{ session('add_success') }}
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
              data-dismiss-target="#alert-3" aria-label="Close" class="dismiss-btn">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
          @endif

          <div>
            <label class="block text-gray-700 text-sm font-medium">Pet No.</label>
            <input type="number" name="pet_number" placeholder="Pet No."
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" value="{{ old('pet_number') }}"
              required>
            <x-form-error name="pet_number" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Species</label>
            <select name="species" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
              <option value="feline" {{ old('species')==='feline' ? 'selected' : '' }}>Feline</option>
              <option value="canine" {{ old('species')==='canine' ? 'selected' : '' }}>Canine</option>
            </select>
            <x-form-error name="species" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Breed</label>
            <input type="text" name="breed" placeholder="e.g. askal, puspin, etc."
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" value="{{ old('breed') }}" required>
            <x-form-error name="breed" />
          </div>

          <div class="flex space-x-2">
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Age</label>
              <input type="number" name="age" placeholder="Age"
                class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" value="{{ old('age') }}" required>
              <x-form-error name="age" />
            </div>
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Unit</label>
              <select name="age_unit" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
                <option value="months" {{ old('age_unit')==='months' ? 'selected' : '' }}>Months</option>
                <option value="years" {{ old('age_unit')==='years' ? 'selected' : '' }}>Years</option>
              </select>
              <x-form-error name="age_unit" />
            </div>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Sex</label>
            <select name="sex" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
              <option value="male" {{ old('sex')==='male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('sex')==='female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-form-error name="sex" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Color</label>
            <select name="color" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
              <option value="black">Black</option>
              <option value="white">White</option>
              <option value="gray">Gray</option>
              <option value="brown">Brown</option>
              <option value="orange">Orange</option>
              <option value="calico">Calico</option>
              <option value="tabby">Tabby</option>
              <option value="bi-color">Bi-color</option>
              <option value="tri-color">Tri-color</option>
              <option value="others">Others</option>
            </select>
            <x-form-error name="color" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Image</label>
            <input type="file" class="w-full border rounded-md" name="image" id="imageInput" required>
            <x-form-error name="image" />
          </div>

          <!-- Submit Button -->
          <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-md hover:bg-orange-500">Add
            Pet</button>
        </form>
      </div>
    </div>
  </div>


  <!-- Edit Pet Modal -->
  <div id="editModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 {{ session('modal_open') === 'edit' ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeEditModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x"></i>
      </button>

      <!-- Scrollable Content -->
      <div class="flex flex-col overflow-y-auto p-2 space-y-4 flex-grow">
        <!-- Form Title -->
        <h2 class="text-xl font-semibold text-gray-800">Edit Pet</h2>

        @php
        $editPetData = session('edit_pet_data', $pet);
        // dd($editPetData->id);
        @endphp


        <!-- Success Message -->
        @if(session('edit_success') && session('edit_pet_id') == old('id', $editPetData->id))
        <div id="alert-3"
          class="flex items-center p-4 my-3 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 sm:col-span-7 edit-success"
          role="alert">
          <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
          </svg>
          <span class="sr-only">Info</span>
          <div class="ms-3 text-sm font-medium">
            {{ session('edit_success') }}
          </div>
          <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
            data-dismiss-target="#alert-3" aria-label="Close" class="dismiss-btn">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
          </button>
        </div>
        @endif

        <!-- Image Preview -->
        <div class="flex justify-center relative">
          <p id="editImagePlaceholder" class="absolute text-gray-500 text-sm">Image preview here...</p>
          <img id="editImagePreview"
            src="{{ $editPetData->image_path ? asset('storage/' . $editPetData->image_path) : '' }}"
            class="w-full h-auto object-cover rounded-lg border border-gray-300 {{ $editPetData->image_path ? '' : 'hidden' }}"
            alt="Pet Image">
        </div>

        <!-- Form Fields -->
        <form method="POST" id="editPetForm" action="/admin/pet-profiles/{{ $pet->id }}" enctype="multipart/form-data"
          class="space-y-4">
          @csrf
          @method('PATCH')

          <input type="hidden" name="id" id="editPetId" value="{{ $pet->id }}">

          <div>
            <label class="block text-gray-700 text-sm font-medium">Pet No.</label>
            <input type="number" name="pet_number" id="editPetNumber"
              value="{{ old('pet_number', $editPetData->pet_number) }}"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
            <x-form-error name="pet_number" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Species</label>
            <select name="species" id="editSpecies"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
              <option value="feline" {{ old('species', $editPetData->species) == 'feline' ? 'selected' : '' }}>Feline
              </option>
              <option value="canine" {{ old('species', $editPetData->species) == 'canine' ? 'selected' : '' }}>Canine
              </option>
            </select>
            <x-form-error name="species" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Breed</label>
            <input type="text" name="breed" id="editBreed" value="{{ old('breed', $editPetData->breed) }}"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
            <x-form-error name="breed" />
          </div>

          <div class="flex space-x-2">
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Age</label>
              <input type="number" name="age" id="editAge" value="{{ old('age', $editPetData->age) }}"
                class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
              <x-form-error name="age" />
            </div>
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Unit</label>
              <select name="age_unit" id="editAgeUnit"
                class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
                <option value="months" {{ old('age_unit', $editPetData->age_unit) == 'months' ? 'selected' : ''
                  }}>Months
                </option>
                <option value="years" {{ old('age_unit', $editPetData->age_unit) == 'years' ? 'selected' : '' }}>Years
                </option>
              </select>
              <x-form-error name="age_unit" />
            </div>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Sex</label>
            <select name="sex" id="editSex" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500"
              required>
              <option value="male" {{ old('sex', $editPetData->sex) == 'male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('sex', $editPetData->sex) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-form-error name="sex" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Color</label>
            <select name="color" id="editColor" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500"
              required>
              @foreach (["black", "white", "gray", "brown", "orange", "calico", "tabby", "bi-color", "tri-color",
              "others"] as $color)
              <option value="{{ $color }}" {{ old('color', $editPetData->color) == $color ? 'selected' : '' }}>
                {{ ucfirst($color) }}
              </option>
              @endforeach
            </select>
            <x-form-error name="color" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Image</label>
            <input type="file" class="w-full border rounded-md" name="image" id="editImageInput">
            <x-form-error name="image" />
          </div>

          <!-- Submit Button -->
          <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-md hover:bg-orange-500">Update
            Pet</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Pet Modal -->
  <!-- Delete Pet Modal -->
  <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <!-- Modal Content -->
      <h2 class="text-xl font-semibold text-gray-800">Confirm Deletion</h2>
      <p class="text-gray-600 mt-2">Are you sure you want to delete Pet#<span id="deletePetIdText"></span>?</p>

      <div class="flex justify-end mt-4 space-x-2">
        <button id="closeDeleteModal" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400">
          Cancel
        </button>
        <form id="deletePetForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>


</x-admin-layout>