<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Pet Profiles</h1>

  <div class="bg-white p-6 shadow-md rounded-lg mt-4">
    <!-- Add New Pet Button -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800">Pet Profiles</h2>
      <!-- Add New Pet Button -->
      <button id="openModal"
        class="bg-yellow-500 hover:bg-orange-500 text-white font-semibold py-2 px-4 md:px-4 flex items-center justify-center md:rounded-md rounded-full w-10 h-10 md:w-auto md:h-auto">
        <i class="ph-fill ph-plus-circle"></i>
        <span class="hidden md:inline-flex ml-2">Add a New Pet</span>
      </button>
    </div>

    <!-- Pet Profiles Table -->
    <div class="overflow-x-auto">
      <table class="w-full border border-gray-200 rounded-lg">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="py-2 px-4 text-left">Image</th>
            <th class="py-2 px-4 text-left">Name</th>
            <th class="py-2 px-4 text-left">Breed</th>
            <th class="py-2 px-4 text-left">Age</th>
            <th class="py-2 px-4 text-left">Status</th>
            <th class="py-2 px-4 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Static Data -->
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-2 px-4">
              <img src="{{ asset('images/black-dog.jpg') }}" alt="Pet Image"
                class="w-12 h-12 rounded-full object-cover">
            </td>
            <td class="py-2 px-4">Buddy</td>
            <td class="py-2 px-4">Golden Retriever</td>
            <td class="py-2 px-4">3 years</td>
            <td class="py-2 px-4">
              <span class="px-2 py-1 text-sm font-semibold rounded-md bg-green-500 text-white">
                Available
              </span>
            </td>
            <td class="py-2 px-4 text-center">
              <a href="#" class="text-blue-500 hover:text-blue-600 mr-2">
                <i class="ph-fill ph-pencil-simple"></i>
              </a>
              <button class="text-red-500 hover:text-red-600">
                <i class="ph-fill ph-trash"></i>
              </button>
            </td>
          </tr>

          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-2 px-4">
              <img src="{{ asset('images/black-dog.jpg') }}" alt="Pet Image"
                class="w-12 h-12 rounded-full object-cover">
            </td>
            <td class="py-2 px-4">Whiskers</td>
            <td class="py-2 px-4">Siamese</td>
            <td class="py-2 px-4">2 years</td>
            <td class="py-2 px-4">
              <span class="px-2 py-1 text-sm font-semibold rounded-md bg-red-500 text-white">
                Adopted
              </span>
            </td>
            <td class="py-2 px-4 text-center">
              <a href="#" class="text-blue-500 hover:text-blue-600 mr-2">
                <i class="ph-fill ph-pencil-simple"></i>
              </a>
              <button class="text-red-500 hover:text-red-600">
                <i class="ph-fill ph-trash"></i>
              </button>
            </td>
          </tr>

          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-2 px-4">
              <img src="{{ asset('images/black-dog.jpg') }}" alt="Pet Image"
                class="w-12 h-12 rounded-full object-cover">
            </td>
            <td class="py-2 px-4">Polly</td>
            <td class="py-2 px-4">Parrot</td>
            <td class="py-2 px-4">5 years</td>
            <td class="py-2 px-4">
              <span class="px-2 py-1 text-sm font-semibold rounded-md bg-green-500 text-white">
                Available
              </span>
            </td>
            <td class="py-2 px-4 text-center">
              <a href="#" class="text-blue-500 hover:text-blue-600 mr-2">
                <i class="ph-fill ph-pencil-simple"></i>
              </a>
              <button class="text-red-500 hover:text-red-600">
                <i class="ph-fill ph-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination and Results Count -->
    <div class="mt-4 flex justify-between items-center">
      <span class="text-gray-600 text-sm">
        Showing 1 - 3 of 3 results
      </span>
      <div class="pagination flex gap-2">
        <button class="px-3 py-1 text-gray-500 bg-gray-200 rounded-md cursor-not-allowed" disabled>
          <i class="ph ph-caret-left"></i>
        </button>
        <button class="px-3 py-1 bg-blue-500 text-white rounded-md">1</button>
        <button class="px-3 py-1 text-gray-500 bg-gray-200 rounded-md cursor-not-allowed" disabled>
          <i class="ph ph-caret-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Modal (Initially Hidden) -->
  <div id="modal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 {{ session('success') || $errors->any() ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <!-- Close Button -->
      <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x"></i>
      </button>

      <!-- Form Title -->
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Add a New Pet</h2>

      <!-- Form Fields -->
      <form method="POST" action="/admin/pet-profiles" enctype="multipart/form-data">
        @csrf

        @if (session('success'))
        <div id="alert-3"
          class="flex items-center p-4 my-3 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 sm:col-span-7"
          role="alert">
          <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
          </svg>
          <span class="sr-only">Info</span>
          <div class="ms-3 text-sm font-medium">
            {{ session('success') }}
          </div>
          <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
            data-dismiss-target="#alert-3" aria-label="Close" id="triggerElement">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
          </button>
        </div>
        @endif

        <div class="mb-3">
          <label class="block text-gray-700 text-sm font-medium">Pet No.</label>
          <input type="number" name="pet_number" placeholder="Pet No."
            class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" value="{{ old('pet_number') }}"
            required>
          <x-form-error name="pet_number" />
        </div>

        <div class="mb-3">
          <label class="block text-gray-700 text-sm font-medium">Species</label>
          <select name="species" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
            <option value="feline" {{ old('species')==='feline' ? 'selected' : '' }}>Feline</option>
            <option value="canine" {{ old('species')==='canine' ? 'selected' : '' }}>Canine</option>
          </select>
          <x-form-error name="species" />
        </div>

        <div class="mb-3">
          <label class="block text-gray-700 text-sm font-medium">Breed</label>
          <input type="text" name="breed" placeholder="e.g. askal, puspin, etc."
            class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" value="{{ old('breed') }}" required>
          <x-form-error name="breed" />
        </div>

        <div class="mb-3 flex space-x-2">
          <div class="w-1/2">
            <label class="block text-gray-700 text-sm font-medium">Age</label>
            <input type="number" name="age" placeholder="age"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" value="{{ old('age') }}" required>
            <x-form-error name="age" />
          </div>
          <div class="w-1/2">
            <label class="block text-gray-700 text-sm font-medium">Select Unit</label>
            <select name="age_unit" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
              <option value="months" {{ old('age_unit')==='months' ? 'selected' : '' }}>Months</option>
              <option value="years" {{ old('age_unit')==='years' ? 'selected' : '' }}>Years</option>
            </select>
            <x-form-error name="age_unit" />
          </div>
        </div>

        <div class="mb-3">
          <label class="block text-gray-700 text-sm font-medium">Sex</label>
          <select name="sex" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" required>
            <option value="male" {{ old('sex')==='male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('sex')==='female' ? 'selected' : '' }}>Female</option>
          </select>
          <x-form-error name="sex" />
        </div>

        <div class="mb-3">
          <label class="block text-gray-700 text-sm font-medium">Color</label>
          <input type="text" name="color" placeholder="black, orange, tricolor, etc."
            class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-500" value="{{ old('color') }}" required>
          <x-form-error name="color" />
        </div>

        <div class="mb-3">
          <label class="block text-gray-700 text-sm font-medium">Image</label>
          <input type="file" class="w-full border rounded-md" name="image" required>
          <x-form-error name="image" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-md hover:bg-orange-500">Add
          Pet</button>
      </form>
    </div>
  </div>


</x-admin-layout>