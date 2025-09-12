<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900" id="mainContent">Manage Pet Profiles</h1>

  <div class="mt-4">
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
      <div class="relative bg-white w-full mx-auto rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition-all duration-200 border border-gray-200" wire:poll.10s>
        <a href="/services/{{ $pet->slug }}/adoption-form" class="block relative" target="_blank">
          <img src="{{ asset('storage/' . ($pet->image_path ?? 'pet-images/catdog.svg')) }}" alt="Pet Image" class="h-64 w-full object-cover group-hover:brightness-95 transition-all duration-300" />
          <div class="absolute top-2 left-2">
            <span class="bg-rose-600 text-white text-[10px] font-bold px-2 py-1 rounded">Pick me!</span>
          </div>
          <div class="absolute top-2 right-2">
            <span class="bg-black/60 text-white text-[10px] px-2 py-1 rounded flex items-center">
              <i class="ph-fill ph-clock mr-1"></i>
              Added {{ \Carbon\Carbon::parse($pet->created_at)->diffForHumans() }}
            </span>
          </div>
        </a>

        <!-- Slide-Up Panel with Blur (includes admin menu) -->
        <div class="absolute bottom-0 left-0 w-full bg-white/70 backdrop-blur-md text-gray-900 p-4 translate-y-full group-hover:translate-y-0 transition-all duration-300 ease-in-out">
          <div class="flex justify-between items-start mb-3">
            <div>
              <h3 class="text-lg font-bold text-black">
                {{ strtolower($pet->pet_name) !== 'n/a' ? ucwords($pet->pet_name) : 'Unnamed' }}
              </h3>
              <span class="inline-block mt-1 bg-yellow-400 text-xs text-black py-1 px-2 rounded font-bold">
                {{ $pet->species == 'feline' ? 'Cat' : 'Dog' }}#{{ $pet->pet_number }}
              </span>
            </div>

            <!-- Three-Dots Menu -->
            <div class="relative">
              <button class="menu-toggle flex items-center justify-center p-1.5 rounded-full hover:bg-gray-100 transition-colors focus:outline-none" data-menu-id="menu-{{ $pet->id }}">
                <i class="ph-fill ph-dots-three-outline-vertical text-lg text-gray-700"></i>
              </button>
              <div id="menu-{{ $pet->id }}" class="hidden absolute right-0 top-8 w-44 bg-white rounded-md shadow-lg z-10 border border-gray-100">
                <div class="py-1">
                  <a href="/services/{{ $pet->slug }}/adoption-form" target="_blank" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <i class="ph-fill ph-eye mr-2 text-yellow-500"></i> View
                  </a>
                  <button class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 edit-btn" data-id="{{ $pet->id }}" data-number="{{ $pet->pet_number }}" data-name="{{ $pet->pet_name }}" data-species="{{ $pet->species }}" data-age="{{ $pet->age }}" data-age-unit="{{ $pet->age_unit }}" data-sex="{{ $pet->sex }}" data-repro-status="{{ $pet->reproductive_status }}" data-color="{{ $pet->color }}" data-source="{{ $pet->source }}" data-image="{{ asset('storage/' . $pet->image_path) }}">
                    <i class="ph-fill ph-pencil-simple mr-2 text-blue-600"></i> Edit
                  </button>
                  @if($pet->adoptionApplication && in_array($pet->adoptionApplication->status ?? null, ['to be confirmed', 'confirmed', 'to be picked up', 'to be scheduled', 'adoption on-going']))
                  <button class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-400 cursor-not-allowed" disabled title="Cannot Archive - Adoption In Progress">
                    <i class="ph-fill ph-archive mr-2"></i> Archive
                  </button>
                  @else
                  <button class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 delete-btn" data-id="{{ $pet->id }}" data-number="{{ $pet->pet_number }}">
                    <i class="ph-fill ph-archive mr-2 text-red-600"></i> Archive
                  </button>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Colorized Badges (clickable/togglable) -->
          <div class="flex flex-wrap gap-2 mb-2">
            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full border border-blue-200 cursor-pointer" data-description="Age" onclick="changeText(this)">
              {{ $pet->age }} {{ $pet->age == 1 ? Str::singular($pet->age_unit) : Str::plural($pet->age_unit) }} old
            </span>
            <span class="{{ $pet->sex == 'male' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-pink-100 text-pink-800 border-pink-200' }} text-xs px-3 py-1 rounded-full border cursor-pointer" data-description="Sex" onclick="changeText(this)">
              {{ ucfirst($pet->sex) }}
            </span>
            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full border border-green-200 cursor-pointer" data-description="Color" onclick="changeText(this)">
              {{ ucfirst($pet->color) }}
            </span>
            @php
              $ageYears = 0;
              if (strtolower($pet->age_unit) === 'year' || strtolower($pet->age_unit) === 'years') {
                $ageYears = (int) $pet->age;
              } elseif (strtolower($pet->age_unit) === 'month' || strtolower($pet->age_unit) === 'months') {
                $ageYears = floor(((int) $pet->age) / 12);
              }
            @endphp
            @if ($ageYears >= 6)
            <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full border border-purple-200">
              Senior
            </span>
            @endif
            <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full border border-gray-200 cursor-pointer" data-description="Source" onclick="changeText(this)">
              {{ ucfirst($pet->source) }}
            </span>
            <span class="{{ $pet->reproductive_status == 'neutered' ? 'bg-green-50 text-green-800 border-green-100' : 'bg-amber-50 text-amber-800 border-amber-100' }} text-xs px-3 py-1 rounded-full border cursor-pointer" data-description="Reproductive Status" onclick="changeText(this)">
              {{ ucfirst($pet->reproductive_status) }}
            </span>
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

  <!-- Add a New Pet Modal -->
  <div id="modal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 
    {{ session('modal_open') === 'add' ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x text-xl"></i>
      </button>

      <!-- Scrollable Content -->
      <div class="flex flex-col overflow-y-auto scrollbar-hidden p-2 space-y-4 flex-grow">
        <!-- Form Title -->
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
          <i class="ph-fill ph-plus-circle mr-2 text-orange-500"></i>Add a New Pet
        </h2>

        <!-- Image Preview -->
        <div class="flex justify-center relative">
          <p id="imagePlaceholder" class="absolute text-gray-500 text-sm">Image preview will appear here</p>
          <img id="imagePreview" src="" class="w-full h-auto object-cover rounded-lg border border-gray-300 hidden"
            alt="Pet Image">
        </div>

        <!-- Form Fields -->
        <form method="POST" id="addPetForm" action="/admin/pet-profiles" enctype="multipart/form-data"
          class="space-y-6">
          @csrf

          <!-- Image Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Pet Image <span
                class="text-red-500">*</span></label>
            <input type="file" name="image" id="imageInput"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
              required>
            <x-form-error name="image" />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
              <!-- Pet Number -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Pet Number <span
                    class="text-red-500">*</span></label>
                <input type="number" name="pet_number" placeholder="Pet Number"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('pet_number') }}" min="1" max="100" required>
                <x-form-error name="pet_number" />
              </div>

              <!-- Pet Name -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Pet Name <span
                    class="text-red-500">*</span></label>
                <input type="text" name="pet_name" placeholder="(Optional)"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('pet_name') }}">
                <x-form-error name="pet_name" />
              </div>

              <!-- Species -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Species <span
                    class="text-red-500">*</span></label>
                <select name="species"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="feline" {{ old('species')==='feline' ? 'selected' : '' }}>Feline (Cat)</option>
                  <option value="canine" {{ old('species')==='canine' ? 'selected' : '' }}>Canine (Dog)</option>
                </select>
                <x-form-error name="species" />
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
              <!-- Age and Unit -->
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Age <span
                      class="text-red-500">*</span></label>
                  <input type="number" name="age" placeholder="Age"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    value="{{ old('age') }}" min="1" max="100" required>
                  <x-form-error name="age" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Unit <span
                      class="text-red-500">*</span></label>
                  <select name="age_unit"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    required>
                    <option value="months" {{ old('age_unit')==='months' ? 'selected' : '' }}>Months</option>
                    <option value="years" {{ old('age_unit')==='years' ? 'selected' : '' }}>Years</option>
                    <option value="weeks" {{ old('age_unit')==='weeks' ? 'selected' : '' }}>Weeks</option>
                  </select>
                  <x-form-error name="age_unit" />
                </div>
              </div>

              <!-- Sex -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Sex <span
                    class="text-red-500">*</span></label>
                <select name="sex"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="male" {{ old('sex')==='male' ? 'selected' : '' }}>Male</option>
                  <option value="female" {{ old('sex')==='female' ? 'selected' : '' }}>Female</option>
                </select>
                <x-form-error name="sex" />
              </div>

              <!-- Reproductive Status -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Reproductive Status <span
                    class="text-red-500">*</span></label>
                <select name="reproductive_status"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="intact" {{ old('reproductive_status')==='intact' ? 'selected' : '' }}>Intact</option>
                  <option value="neutered" {{ old('reproductive_status')==='neutered' ? 'selected' : '' }}>
                    Neutered/Spayed</option>
                  <option value="unknown" {{ old('reproductive_status')==='unknown' ? 'selected' : '' }}>Unknown
                  </option>
                </select>
                <x-form-error name="reproductive_status" />
              </div>

              <!-- Color -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Color <span
                    class="text-red-500">*</span></label>
                <select name="color"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  @foreach (["black", "white", "gray", "brown", "orange", "brindle", "calico", "tabby", "bi-color",
                  "tri-color", "others"] as $color)
                  <option value="{{ $color }}" {{ old('color')===$color ? 'selected' : '' }}>
                    {{ ucfirst($color) }}
                  </option>
                  @endforeach
                </select>
                <x-form-error name="color" />
              </div>

              <!-- Source -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Source <span
                    class="text-red-500">*</span></label>
                <select name="source"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="surrendered" {{ old('source')==='surrendered' ? 'selected' : '' }}>Surrendered</option>
                  <option value="rescued" {{ old('source')==='rescued' ? 'selected' : '' }}>Rescued</option>
                  <option value="other" {{ old('source')==='other' ? 'selected' : '' }}>Other</option>
                </select>
                <x-form-error name="source" />
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end pt-4">
            <button type="submit"
              class="w-full sm:w-fit px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <i class="ph-fill ph-plus-circle mr-2"></i>Add Pet
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Pet Modal -->
  <div id="editModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 {{ session('modal_open') === 'edit' ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-hidden relative flex flex-col">
      <!-- Close Button -->
      <button id="closeEditModal" class="absolute top-3 right-3 text-gray-600 hover:text-black">
        <i class="ph-bold ph-x text-xl"></i>
      </button>

      <!-- Scrollable Content -->
      <div class="flex flex-col overflow-y-auto scrollbar-hidden p-2 space-y-4 flex-grow">
        <!-- Form Title -->
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
          <i class="ph-fill ph-pencil-simple mr-2 text-orange-500"></i>Edit Pet Profile
        </h2>

        @php
        $editPetData = session('edit_pet_data', $pet);
        // dd($editPetData->id);
        @endphp

        <!-- Image Preview -->
        <div class="flex justify-center relative">
          <p id="editImagePlaceholder" class="absolute text-gray-500 text-sm">Current pet image</p>
          <img id="editImagePreview"
            src="{{ $editPetData->image_path ? asset('storage/' . $editPetData->image_path) : '' }}"
            class="w-full h-auto object-cover rounded-lg border border-gray-300 {{ $editPetData->image_path ? '' : 'hidden' }}"
            alt="Pet Image">
        </div>

        <!-- Form Fields -->
        <form method="POST" id="editPetForm" action="/admin/pet-profiles/{{ $pet->id }}" enctype="multipart/form-data"
          class="space-y-6">
          @csrf
          @method('PATCH')

          <input type="hidden" name="id" id="editPetId" value="{{ $pet->id }}">

          <!-- Image Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Update Image</label>
            <input type="file" name="image" id="editImageInput"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
            <x-form-error name="image" />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
              <!-- Pet Number -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Pet Number <span
                    class="text-red-500">*</span></label>
                <input type="number" name="pet_number" id="editPetNumber"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  value="{{ old('pet_number', $editPetData->pet_number) }}" min="1" max="100" required>
                <x-form-error name="pet_number" />
              </div>

              <!-- Pet Name -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Pet Name <span
                    class="text-red-500">*</span></label>
                <input type="text" name="pet_name" id="editPetName"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  placeholder="(Optional)" value="{{ old('pet_name', $editPetData->pet_name) }}">
                <x-form-error name="pet_name" />
              </div>

              <!-- Species -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Species <span
                    class="text-red-500">*</span></label>
                <select name="species" id="editSpecies"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="feline" {{ old('species', $editPetData->species) == 'feline' ? 'selected' : ''
                    }}>Feline (Cat)</option>
                  <option value="canine" {{ old('species', $editPetData->species) == 'canine' ? 'selected' : ''
                    }}>Canine (Dog)</option>
                </select>
                <x-form-error name="species" />
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
              <!-- Age and Unit -->
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Age <span
                      class="text-red-500">*</span></label>
                  <input type="number" name="age" id="editAge"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    value="{{ old('age', $editPetData->age) }}" min="1" max="100" required>
                  <x-form-error name="age" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-1">Unit <span
                      class="text-red-500">*</span></label>
                  <select name="age_unit" id="editAgeUnit"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                    required>
                    <option value="months" {{ old('age_unit', $editPetData->age_unit) == 'months' ? 'selected' : ''
                      }}>Months</option>
                    <option value="years" {{ old('age_unit', $editPetData->age_unit) == 'years' ? 'selected' : ''
                      }}>Years</option>
                    <option value="weeks" {{ old('age_unit', $editPetData->age_unit) == 'weeks' ? 'selected' : ''
                      }}>Weeks</option>
                  </select>
                  <x-form-error name="age_unit" />
                </div>
              </div>

              <!-- Sex -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Sex <span
                    class="text-red-500">*</span></label>
                <select name="sex" id="editSex"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="male" {{ old('sex', $editPetData->sex) == 'male' ? 'selected' : '' }}>Male</option>
                  <option value="female" {{ old('sex', $editPetData->sex) == 'female' ? 'selected' : '' }}>Female
                  </option>
                </select>
                <x-form-error name="sex" />
              </div>

              <!-- Reproductive Status -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Reproductive Status <span
                    class="text-red-500">*</span></label>
                <select name="reproductive_status" id="editReproStatus"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="intact" {{ old('reproductive_status', $editPetData->reproductive_status) == 'intact' ?
                    'selected' : '' }}>Intact</option>
                  <option value="neutered" {{ old('reproductive_status', $editPetData->reproductive_status) ==
                    'neutered' ? 'selected' : '' }}>Neutered/Spayed</option>
                  <option value="unknown" {{ old('reproductive_status', $editPetData->reproductive_status) == 'unknown'
                    ? 'selected' : '' }}>Unknown</option>
                </select>
                <x-form-error name="reproductive_status" />
              </div>

              <!-- Color -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Color <span
                    class="text-red-500">*</span></label>
                <select name="color" id="editColor"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  @foreach (["black", "white", "gray", "brown", "orange", "brindle", "calico", "tabby", "bi-color",
                  "tri-color", "others"] as $color)
                  <option value="{{ $color }}" {{ old('color', $editPetData->color) == $color ? 'selected' : '' }}>
                    {{ ucfirst($color) }}
                  </option>
                  @endforeach
                </select>
                <x-form-error name="color" />
              </div>

              <!-- Source -->
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Source <span
                    class="text-red-500">*</span></label>
                <select name="source" id="editSource"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
                  required>
                  <option value="surrendered" {{ old('source', $editPetData->source) == 'surrendered' ? 'selected' : ''
                    }}>Surrendered</option>
                  <option value="rescued" {{ old('source', $editPetData->source) == 'rescued' ? 'selected' : ''
                    }}>Rescued</option>
                  <option value="other" {{ old('source', $editPetData->source) == 'other' ? 'selected' : '' }}>Other
                  </option>
                </select>
                <x-form-error name="source" />
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end pt-4">
            <button type="submit"
              class="w-full sm:w-fit px-5 bg-orange-500 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-yellow-400 hover:text-black transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
              <i class="ph-fill ph-floppy-disk	 mr-2"></i>Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Archive Modal (Updated Styling) -->
  <div id="archiveModal"
    class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 {{ $errors->has('archive_reason') || $errors->has('archive_notes') ? '' : 'hidden' }}">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button type="button" id="closeArchiveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-xl font-semibold text-gray-800 flex items-center">
        <i class="ph-fill ph-archive mr-2"></i>Archive Pet
      </h2>

      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg mt-4">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <i class="ph-fill ph-warning text-yellow-500 text-xl"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-yellow-700">
              You are about to archive Pet#<span id="archivePetIdText" class="font-semibold">{{ old('pet_number',
                session('archive_pet_number')) }}</span>.
              This action cannot be undone. This will also notify all users.
            </p>
          </div>
        </div>
      </div>

      <form id="archivePetForm" method="POST"
        action="{{ old('pet_id') ? url('/admin/pet-profiles/' . old('pet_id') . '/archive') : '' }}" class="mt-6">
        @csrf
        @method('PATCH')
        <input type="hidden" name="pet_id" id="archivePetId" value="{{ old('pet_id') }}">

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-600 mb-1">Reason for Archiving <span
              class="text-red-500">*</span></label>
          <select name="archive_reason" id="archiveReason"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
            required>
            <option value="">Select a reason</option>
            <option value="Pet has passed away" {{ old('archive_reason')=='Pet has passed away' ? 'selected' : '' }}>Pet
              has passed away</option>
            <option value="Pet has health issues" {{ old('archive_reason')=='Pet has health issues' ? 'selected' : ''
              }}>Pet has health issues</option>
            <option value="Other" {{ old('archive_reason')=='Other' ? 'selected' : '' }}>Other (please specify)</option>
          </select>
          <x-form-error name="archive_reason" />
        </div>

        <div class="mb-4" id="archiveNotesContainer"
          style="{{ old('archive_reason') == 'Other' ? '' : 'display: none;' }}">
          <textarea name="archive_notes" id="archiveNotes"
            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400"
            rows="3" placeholder="Specify the reason for archiving">{{ old('archive_notes') }}</textarea>
          <x-form-error name="archive_notes" />
        </div>

        <div class="flex justify-end space-x-3 mt-6">
          <button type="button" id="cancelArchive"
            class="px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-300">
            Cancel
          </button>
          <button type="submit"
            class="px-4 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-500 focus:ring-2 focus:ring-red-300 flex items-center">
            <i class="ph-fill ph-archive mr-2"></i>Confirm Archive
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
    // Open modal on delete button click
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function () {
        const petId = this.getAttribute('data-id');
        const petNumber = this.getAttribute('data-number');

        const form = document.getElementById('archivePetForm');
        form.action = `/admin/pet-profiles/${petId}/archive`;

        document.getElementById('archivePetId').value = petId;
        document.getElementById('archivePetIdText').textContent = petNumber;

        document.getElementById('archiveModal').classList.remove('hidden');
      });
    });

    // Close modal
    document.getElementById('closeArchiveModal').addEventListener('click', function () {
      document.getElementById('archiveModal').classList.add('hidden');
    });

    document.getElementById('cancelArchive').addEventListener('click', function () {
      document.getElementById('archiveModal').classList.add('hidden');
    });

    // Show/hide notes field based on reason
    document.getElementById('archiveReason').addEventListener('change', function () {
      const notesContainer = document.getElementById('archiveNotesContainer');
      notesContainer.style.display = this.value === 'Other' ? 'block' : 'none';
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
      function updateHeaderSpacer() {
          const header = document.getElementById('main-header');
          const mainContent = document.getElementById('mainContent');
          
          if (header && mainContent) {
              const headerHeight = header.offsetHeight;
              mainContent.style.marginTop = `${headerHeight * .25}px`;
          }
      }

      // Initial update
      updateHeaderSpacer();

      // Update on window resize
      window.addEventListener('resize', updateHeaderSpacer);
    });
  </script>

</x-admin-layout>