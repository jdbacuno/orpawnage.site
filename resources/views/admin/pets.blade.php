<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Pet Profiles</h1>

  <div class="bg-white p-6 shadow-md rounded-lg mt-4">
    <!-- Successful Add -->
    @if(session('add_success') && !session('modal_open'))
    <div id="alert-3"
      class="flex items-center p-4 mb-1 text-green-800 rounded-lg bg-green-50 sm:col-span-7 edit-success w-full md:w-1/2"
      role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">
        Pet {!! session('add_success') !!} has been added successfully!
      </div>
      <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
        data-dismiss-target="#alert-3" aria-label="Close" class="dismiss-btn">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
      </button>
    </div>
    @endif

    <!-- Successful Update -->
    @if(session('edit_success') && !session('modal_open'))
    <div id="alert-3"
      class="flex items-center p-4 mb-1 text-green-800 rounded-lg bg-green-50 sm:col-span-7 edit-success w-full md:w-1/2"
      role="alert">
      <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div class="ms-3 text-sm font-medium">
        Pet {!! session('edit_success') !!} has been updated!
      </div>
      <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
        data-dismiss-target="#alert-3" aria-label="Close" class="dismiss-btn">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
      </button>
    </div>
    @endif

    <!-- Successful Add -->
    @if(session('delete_success') && !session('modal_open'))
    <div id="alert-3"
      class="flex items-center p-4 mb-1 text-green-800 rounded-lg bg-green-50 sm:col-span-7 edit-success w-full md:w-1/2"
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
        data-dismiss-target="#alert-3" aria-label="Close" class="dismiss-btn">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
      </button>
    </div>
    @endif

    <!-- Add New Pet Button -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800">Pet Profiles</h2>
      <!-- Add New Pet Button -->
      <button id="openModal"
        class="bg-yellow-400 text-black hover:bg-orange-500 hover:text-white font-semibold py-2 px-4 md:px-4 flex items-center justify-center md:rounded-md rounded-full w-10 h-10 md:w-auto md:h-auto">
        <i class="ph-fill ph-plus-circle"></i>
        <span class="hidden md:inline-flex ml-2">Add a New Pet</span>
      </button>
    </div>

    <!-- Top Pagination -->
    <div class="my-2">
      {{ $pets->links() }}
    </div>

    <!-- Filter Section -->
    <div class="mb-6 mt-4 flex flex-col md:flex-row gap-4">
      <!-- Filter Dropdowns -->
      <div class="flex flex-wrap gap-2">
        <form method="GET" action="{{ request()->url() }}#pets" class="flex flex-wrap gap-4">
          <!-- Species Filter -->
          <select name="species"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px] sm:min-w-[120px]"
            onchange="this.form.submit()">
            <option value="">All Species</option>
            <option value="feline" {{ request('species')=='feline' ? 'selected' : '' }}>Cats</option>
            <option value="canine" {{ request('species')=='canine' ? 'selected' : '' }}>Dogs</option>
          </select>

          <!-- Sex Filter -->
          <select name="sex"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px] sm:min-w-[120px]"
            onchange="this.form.submit()">
            <option value="">All Sexes</option>
            <option value="male" {{ request('sex')=='male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ request('sex')=='female' ? 'selected' : '' }}>Female</option>
          </select>

          <!-- Reproductive Status Filter -->
          <select name="reproductive_status"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
            onchange="this.form.submit()">
            <option value="">Reproductive</option>
            <option value="intact" {{ request('reproductive_status')=='intact' ? 'selected' : '' }}>Intact</option>
            <option value="neutered" {{ request('reproductive_status')=='neutered' ? 'selected' : '' }}>Neutered/Spayed
            </option>
          </select>

          <!-- Color Filter -->
          <select name="color"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px] sm:min-w-[120px]"
            onchange="this.form.submit()">
            <option value="">All Colors</option>
            <option value="black" {{ request('color')=='black' ? 'selected' : '' }}>Black</option>
            <option value="white" {{ request('color')=='white' ? 'selected' : '' }}>White</option>
            <option value="gray" {{ request('color')=='gray' ? 'selected' : '' }}>Gray</option>
            <option value="brown" {{ request('color')=='brown' ? 'selected' : '' }}>Brown</option>
            <option value="brindle" {{ request('color')=='brindle' ? 'selected' : '' }}>Brindle</option>
            <option value="orange" {{ request('color')=='orange' ? 'selected' : '' }}>Orange</option>
            <option value="calico" {{ request('color')=='calico' ? 'selected' : '' }}>Calico</option>
            <option value="tabby" {{ request('color')=='tabby' ? 'selected' : '' }}>Tabby</option>
            <option value="bi-color" {{ request('color')=='bi-color' ? 'selected' : '' }}>Bi-Color</option>
            <option value="tri-color" {{ request('color')=='tri-color' ? 'selected' : '' }}>Tri-Color</option>
            <option value="others" {{ request('color')=='others' ? 'selected' : '' }}>Others</option>
            <!-- Add more colors as needed -->
          </select>

          <!-- Source Filter -->
          <select name="source"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px] sm:min-w-[120px]"
            onchange="this.form.submit()">
            <option value="">All Sources</option>
            <option value="surrendered" {{ request('source')=='surrendered' ? 'selected' : '' }}>Surrendered</option>
            <option value="rescued" {{ request('source')=='rescued' ? 'selected' : '' }}>Rescued</option>
          </select>

          <!-- Adoption Status Filter -->
          <select name="adoption_status"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px] sm:min-w-[120px]"
            onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="available" {{ request('adoption_status')=='available' ? 'selected' : '' }}>Available</option>
            <option value="in_process" {{ request('adoption_status')=='in_process' ? 'selected' : '' }}>In Process
            </option>
          </select>

          <!-- Sort Filter -->
          <select name="sort_by"
            class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[150px]"
            onchange="this.form.submit()">
            <option value="">Sort By</option>
            <option value="latest" {{ request('sort_by')=='latest' ? 'selected' : '' }}>Newest Arrivals</option>
            <option value="oldest" {{ request('sort_by')=='oldest' ? 'selected' : '' }}>Oldest Arrivals</option>
            <option value="youngest" {{ request('sort_by')=='youngest' ? 'selected' : '' }}>Youngest First
            </option>
            <option value="oldest_age" {{ request('sort_by')=='oldest_age' ? 'selected' : '' }}>Oldest First
            </option>
          </select>

          <!-- Reset Filters Button -->
          <a href="{{ request()->url() }}"
            class="bg-gray-200 hover:bg-gray-300 text-center text-gray-800 px-4 py-2.5 border border-gray-400 rounded-lg text-sm min-w-[150px] sm:min-w-[120px]">
            Reset Filters
          </a>
        </form>
      </div>
    </div>

    @if($pets->isEmpty())
    <div class="flex items-center justify-center p-6 text-gray-500">
      <p class="text-lg">No pets found.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      @foreach($pets as $pet)
      <div
        class="relative bg-white w-full max-w-[350px] mx-auto rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
        wire:poll.10s>

        <!-- Image container with hover-specific slide-up -->
        <div class="group relative h-48 overflow-hidden">
          <a href="/services/{{ $pet->slug }}/adoption-form" class="block h-full">
            <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image"
              class="h-full w-full object-cover transition duration-300" />
          </a>

          <!-- Slide-Up Panel (now properly working) -->
          <div
            class="absolute bottom-0 left-0 w-full bg-white/80 backdrop-blur-md text-gray-900 p-3 translate-y-full group-hover:translate-y-0 transition duration-300 ease-in-out scrollbar-hidden">
            <div class="flex flex-wrap gap-2 mb-1">
              <span
                class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full border border-blue-200 cursor-pointer"
                data-description="Age" onclick="changeText(this)">
                {{ $pet->age }} {{ $pet->age == 1 ? Str::singular($pet->age_unit) : Str::plural($pet->age_unit) }}
              </span>

              <span
                class="{{ $pet->sex == 'male' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-pink-100 text-pink-800 border-pink-200' }} text-xs px-2 py-1 rounded-full border cursor-pointer"
                data-description="Sex" onclick="changeText(this)">
                {{ ucfirst($pet->sex) }}
              </span>

              <span
                class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full border border-green-200 cursor-pointer"
                data-description="Color" onclick="changeText(this)">
                {{ ucfirst($pet->color) }}
              </span>
            </div>

            <div class="flex flex-wrap gap-2">
              <span
                class="{{ $pet->reproductive_status == 'neutered' ? 'bg-green-50 text-green-800 border-green-100' : 'bg-amber-50 text-amber-800 border-amber-100' }} text-xs px-2 py-1 rounded-full border cursor-pointer"
                data-description="Reproductive Status" onclick="changeText(this)">
                {{ ucfirst($pet->reproductive_status) }}
              </span>

              <span
                class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full border border-gray-200 cursor-pointer"
                data-description="Source" onclick="changeText(this)">
                {{ ucfirst($pet->source) }}
              </span>
            </div>
          </div>
        </div>

        <!-- Card footer -->
        <div class="p-3">
          <div class="flex justify-between items-center mb-1">
            <h3 class="text-md font-bold">
              {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
            </h3>
            <span class="bg-yellow-400 text-xs text-black py-1 px-2 rounded font-bold">
              {{ $pet->species === 'feline' ? 'Cat' : 'Dog' }}#{{ $pet->pet_number }}
            </span>
          </div>

          <!-- Action Buttons with Timestamp and Three-Dots Menu -->
          <div class="flex justify-between items-center mt-2">
            <div class="text-gray-500 text-xs flex items-center">
              <i class="ph-fill ph-clock mr-1"></i>
              <span>Added {{ \Carbon\Carbon::parse($pet->created_at)->diffForHumans() }}</span>
            </div>

            <!-- Three-Dots Menu -->
            <div class="relative">
              <button
                class="menu-toggle flex items-center justify-center p-1.5 rounded-full hover:bg-gray-100 transition-colors focus:outline-none"
                data-menu-id="menu-{{ $pet->id }}">
                <i class="ph-fill ph-dots-three-outline-vertical text-lg text-gray-500 hover:text-gray-700"></i>
              </button>

              <div id="menu-{{ $pet->id }}"
                class="hidden absolute bottom-full right-0 mb-2 w-40 bg-white rounded-md shadow-lg z-10 border border-gray-100">
                <div class="py-1">
                  <a href="/services/{{ $pet->slug }}/adoption-form" target="_blank"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <i class="ph-fill ph-eye mr-2 text-yellow-500"></i> View
                  </a>

                  <button
                    class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 edit-btn"
                    data-id="{{ $pet->id }}" data-number="{{ $pet->pet_number }}" data-name="{{ $pet->pet_name }}"
                    data-species="{{ $pet->species }}" data-age="{{ $pet->age }}" data-age-unit="{{ $pet->age_unit }}"
                    data-sex="{{ $pet->sex }}" data-repro-status="{{ $pet->reproductive_status }}"
                    data-color="{{ $pet->color }}" data-source="{{ $pet->source }}"
                    data-image="{{ asset('storage/' . $pet->image_path) }}">
                    <i class="ph-fill ph-pencil-simple mr-2 text-blue-600"></i> Edit
                  </button>

                  @if($pet->adoptionApplication && in_array($pet->adoptionApplication->status ?? null, ['to be
                  confirmed', 'confirmed', 'to be picked
                  up', 'to be scheduled', 'adoption on-going']))
                  <button class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-400 cursor-not-allowed"
                    disabled title="Cannot Archive - Adoption In Progress">
                    <i class="ph-fill ph-archive mr-2"></i> Archive
                  </button>
                  @else
                  <button
                    class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 delete-btn"
                    data-id="{{ $pet->id }}" data-number="{{ $pet->pet_number }}">
                    <i class="ph-fill ph-archive mr-2 text-red-600"></i> Archive
                  </button>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif

    <!-- Pagination -->
    <div class="mt-6">
      {{ $pets->links() }}
    </div>
  </div>

  <!-- Add a New Pet Modal (Initially Hidden) -->
  <div id="modal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 
    {{ session('modal_open') === 'add' ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x"></i>
      </button>

      <!-- Scrollable Content -->
      <div class="flex flex-col overflow-y-auto scrollbar-hidden p-2 space-y-4 flex-grow">
        <!-- Form Title -->
        <h2 class="text-xl font-semibold text-gray-800">Add a New Pet</h2>

        <!-- Image Preview -->
        <div class="flex justify-center relative">
          <p id="imagePlaceholder" class="absolute text-gray-500 text-sm">Image preview here...</p>
          <img id="imagePreview" src="" class="w-full h-auto object-cover rounded-lg border border-gray-300 hidden"
            alt="Pet Image">
        </div>

        <!-- Form Fields -->
        <form method="POST" id="addPetForm" action="/admin/pet-profiles" enctype="multipart/form-data"
          class="space-y-4 relative">
          @csrf

          <div>
            <label class="block text-gray-700 text-sm font-medium">Image</label>
            <input type="file" class="w-full border rounded-md" name="image" id="imageInput" required>
            <x-form-error name="image" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Pet No.</label>
            <input type="number" name="pet_number" placeholder="Pet No."
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" value="{{ old('pet_number') }}"
              required>
            <x-form-error name="pet_number" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Pet Name (If Any)</label>
            <input type="text" name="pet_name" placeholder="Type &quot;N/A&quot; if none"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" value="{{ old('pet_name') }}"
              required>
            <x-form-error name="pet_name" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Species</label>
            <select name="species" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
              <option value="feline" {{ old('species')==='feline' ? 'selected' : '' }}>Feline</option>
              <option value="canine" {{ old('species')==='canine' ? 'selected' : '' }}>Canine</option>
            </select>
            <x-form-error name="species" />
          </div>

          <div class="flex space-x-2">
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Age</label>
              <input type="number" name="age" placeholder="Age"
                class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" value="{{ old('age') }}" required>
              <x-form-error name="age" />
            </div>
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Unit</label>
              <select name="age_unit" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
                <option value="months" {{ old('age_unit')==='months' ? 'selected' : '' }}>Months</option>
                <option value="years" {{ old('age_unit')==='years' ? 'selected' : '' }}>Years</option>
                <option value="weeks" {{ old('age_unit')==='weeks' ? 'selected' : '' }}>Weeks</option>
              </select>
              <x-form-error name="age_unit" />
            </div>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Sex</label>
            <select name="sex" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
              <option value="male" {{ old('sex')==='male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('sex')==='female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-form-error name="sex" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Reproductive Status</label>
            <select name="reproductive_status" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400"
              required>
              <option value="intact" {{ old('reproductive_status')==='intact' ? 'selected' : '' }}>Intact</option>
              <option value="neutered" {{ old('reproductive_status')==='neutered' ? 'selected' : '' }}>Neutered</option>
              <option value="unknown" {{ old('reproductive_status')==='unknown' ? 'selected' : '' }}>Unknown</option>
            </select>
            <x-form-error name="reproductive_status" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Color</label>
            <select name="color" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
              <option value="black" {{ old('color')==='black' ? 'selected' : '' }}>Black</option>
              <option value="white" {{ old('color')==='white' ? 'selected' : '' }}>White</option>
              <option value="gray" {{ old('color')==='gray' ? 'selected' : '' }}>Gray</option>
              <option value="brown" {{ old('color')==='brown' ? 'selected' : '' }}>Brown</option>
              <option value="orange" {{ old('color')==='orange' ? 'selected' : '' }}>Orange</option>
              <option value="brindle" {{ old('color')==='brindle' ? 'selected' : '' }}>Brindle</option>
              <option value="calico" {{ old('color')==='calico' ? 'selected' : '' }}>Calico</option>
              <option value="tabby" {{ old('color')==='tabby' ? 'selected' : '' }}>Tabby</option>
              <option value="bi-color" {{ old('color')==='bi-color' ? 'selected' : '' }}>Bi-color</option>
              <option value="tri-color" {{ old('color')==='tri-color' ? 'selected' : '' }}>Tri-color</option>
              <option value="others" {{ old('color')==='others' ? 'selected' : '' }}>Others</option>
            </select>
            <x-form-error name="color" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Source of Pet</label>
            <select name="source" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
              <option value="surrendered" {{ old('source')==='surrendered' ? 'selected' : '' }}>Surrendered</option>
              <option value="rescued" {{ old('source')==='rescued' ? 'selected' : '' }}>Rescued</option>
              <option value="other" {{ old('source')==='other' ? 'selected' : '' }}>Other</option>
            </select>
            <x-form-error name="source" />
          </div>

          <!-- Submit Button -->
          <button type="submit"
            class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-yellow-400 hover:text-black sticky bottom-0">Add
            Pet</button>
        </form>
      </div>
    </div>
  </div>


  <!-- Edit Pet Modal -->
  @if (!$pets->isEmpty())
  <div id="editModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 {{ session('modal_open') === 'edit' ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeEditModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x"></i>
      </button>

      <!-- Scrollable Content -->
      <div class="flex flex-col overflow-y-auto scrollbar-hidden p-2 space-y-4 flex-grow">
        <!-- Form Title -->
        <h2 class="text-xl font-semibold text-gray-800">Edit Pet</h2>

        @php
        $editPetData = session('edit_pet_data', $pet);
        // dd($editPetData->id);
        @endphp

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
          class="space-y-4 relative">
          @csrf
          @method('PATCH')

          <input type="hidden" name="id" id="editPetId" value="{{ $pet->id }}">

          <div>
            <label class="block text-gray-700 text-sm font-medium">Image</label>
            <input type="file" class="w-full border rounded-md" name="image" id="editImageInput">
            <x-form-error name="image" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Pet No.</label>
            <input type="number" name="pet_number" id="editPetNumber"
              value="{{ old('pet_number', $editPetData->pet_number) }}"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
            <x-form-error name="pet_number" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Pet Name</label>
            <input type="text" name="pet_name" id="editPetName" value="{{ old('pet_name', $editPetData->pet_name) }}"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400"
              placeholder="Type &quot;N/A&quot; if none" required>
            <x-form-error name="pet_name" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Species</label>
            <select name="species" id="editSpecies"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
              <option value="feline" {{ old('species', $editPetData->species) == 'feline' ? 'selected' : '' }}>Feline
              </option>
              <option value="canine" {{ old('species', $editPetData->species) == 'canine' ? 'selected' : '' }}>Canine
              </option>
            </select>
            <x-form-error name="species" />
          </div>

          <div class="flex space-x-2">
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Age</label>
              <input type="number" name="age" id="editAge" value="{{ old('age', $editPetData->age) }}"
                class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
              <x-form-error name="age" />
            </div>
            <div class="w-1/2">
              <label class="block text-gray-700 text-sm font-medium">Unit</label>
              <select name="age_unit" id="editAgeUnit"
                class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
                <option value="months" {{ old('age_unit', $editPetData->age_unit) == 'months' ? 'selected' : ''
                  }}>Months
                </option>
                <option value="years" {{ old('age_unit', $editPetData->age_unit) == 'years' ? 'selected' : '' }}>Years
                </option>
                <option value="weeks" {{ old('age_unit', $editPetData->age_unit) == 'weeks' ? 'selected' : '' }}>Weeks
                </option>
              </select>
              <x-form-error name="age_unit" />
            </div>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Sex</label>
            <select name="sex" id="editSex" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400"
              required>
              <option value="male" {{ old('sex', $editPetData->sex) == 'male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('sex', $editPetData->sex) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-form-error name="sex" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Reproductive Status</label>
            <select name="reproductive_status" id="editReproStatus"
              class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400" required>
              <option value="intact" {{ old('reproductive_status', $editPetData->reproductive_status) == 'intact' ?
                'selected' : ''
                }}>Intact</option>
              <option value="neutered" {{ old('reproductive_status', $editPetData->reproductive_status) == 'neutered' ?
                'selected' : ''
                }}>Neutered</option>
              <option value="unknown" {{ old('reproductive_status', $editPetData->reproductive_status) == 'unknown' ?
                'selected' : ''
                }}>Unknown</option>
            </select>
            <x-form-error name="reproductive_status" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Color</label>
            <select name="color" id="editColor" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400"
              required>
              @foreach (["black", "white", "gray", "brown", "orange", "brindle", "calico", "tabby", "bi-color",
              "tri-color",
              "others"] as $color)
              <option value="{{ $color }}" {{ old('color', $editPetData->color) == $color ? 'selected' : '' }}>
                {{ ucfirst($color) }}
              </option>
              @endforeach
            </select>
            <x-form-error name="color" />
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium">Source of Pet</label>
            <select name="source" id="editSource" class="w-full border p-2 rounded-md focus:ring focus:ring-yellow-400"
              required>
              <option value="surrendered" {{ old('source', $editPetData->source) == 'surrendered' ?
                'selected' : ''
                }}>Surrendered</option>
              <option value="rescued" {{ old('source', $editPetData->source) == 'rescued' ? 'selected' : ''
                }}>Rescued</option>
              <option value="other" {{ old('source', $editPetData->source) == 'other' ? 'selected' : ''
                }}>Other</option>
            </select>
            <x-form-error name="source" />
          </div>

          <!-- Submit Button -->
          <button type="submit"
            class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-yellow-400 hover:text-black sticky bottom-0">Update
            Pet</button>
        </form>
      </div>
    </div>
  </div>
  @endif

  <!-- Delete Pet Modal -->
  <div id="deleteModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <!-- Modal Content -->
      <h2 class="text-xl font-semibold text-gray-800">Archive this Pet?</h2>
      <p class="text-gray-600 mt-2">Are you sure you want to archive Pet#<span id="deletePetIdText"></span>?</p>

      <div class="flex justify-end mt-4 space-x-2">
        <button id="closeDeleteModal" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400">
          Cancel
        </button>
        <form id="deletePetForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
            Archive
          </button>
        </form>
      </div>
    </div>
  </div>

</x-admin-layout>