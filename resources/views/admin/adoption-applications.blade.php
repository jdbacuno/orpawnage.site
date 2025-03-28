<x-admin-layout>
  <h1 class="text-2xl font-bold text-gray-900">Manage Pet Adoption Applications</h1>

  <div class="bg-white p-6 shadow-md rounded-lg mt-4">
    <div class="overflow-x-auto">
      @if($adoptionApplications->isEmpty())
      <div class="flex items-center justify-center p-6 text-gray-500">
        <p class="text-lg">No adoption applications found.</p>
      </div>
      @else
      <table class="w-full border border-gray-200 rounded-lg">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="py-2 px-4 text-left">Pet No.</th>
            <th class="py-2 px-4 text-left">Name</th>
            <th class="py-2 px-4 text-left">Status</th>
            <th class="py-2 px-4 text-left">Pickup Date</th>
            <th class="py-2 px-4 text-left">
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                class="text-blue-500 hover:underline hover:text-blue-600 flex items-center gap-1 whitespace-nowrap">
                Date Applied
                <span>{!! request('sort') === 'created_at' ? (request('direction') === 'asc' ? '▲' : '▼') : ''
                  !!}</span>
              </a>
            </th>

            <th class="py-2 px-4 text-center">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach($adoptionApplications as $application)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-2 px-4 whitespace-nowrap">
              <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline pet-info-btn"
                data-id="{{ $application->id }}" data-image="{{ asset('storage/' . $application->pet->image_path) }}"
                data-number="{{ $application->pet->pet_number }}" data-species="{{ $application->pet->species }}"
                data-breed="{{ $application->pet->breed }}" data-age="{{ $application->pet->age }}"
                data-age-unit="{{ $application->pet->age_unit }}" data-color="{{ $application->pet->color }}"
                data-sex="{{ $application->pet->sex }}">
                #{{ $application->pet->pet_number }} - {{ $application->pet->species }}
              </a>
            </td>
            <td class="py-2 px-4 whitespace-nowrap">
              <a href="#" class="text-blue-500 hover:text-blue-600 hover:underline adopter-info-btn"
                data-id="{{ $application->id }}" data-name="{{ $application->full_name }}"
                data-email="{{ $application->email }}" data-age="{{ $application->age }}" data-birthdate="{{ $application->birthdate->format('F
              j, Y') }}" data-address="{{ $application->address }}" data-phone="{{ $application->contact_number }}"
                data-civil="{{ $application->civil_status }}" data-citizenship="{{ $application->citizenship }}">
                {{ $application->full_name }}
              </a>
            </td>

            <td class="py-2 px-4 whitespace-nowrap flex justify-between gap-1">
              <span class="px-2 py-1 text-sm rounded 
        {{ $application->status === 'to be scheduled' ? 'bg-yellow-100 text-yellow-700' : '' }}
        {{ $application->status === 'to be picked up' ? 'bg-green-100 text-green-700' : '' }}
        {{ $application->status === 'picked up' ? 'bg-blue-100 text-blue-700' : '' }}
        {{ $application->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                {{ ucfirst($application->status) }}
              </span>

              @if ($application->status === 'to be picked up')
              <form method="POST" action="/admin/adoption-applications/pickedup">
                @csrf
                @method('PATCH')

                <input type="hidden" name="application_id" value="{{ $application->id }}">

                <button type="submit" class="bg-blue-500 text-sm px-2 py-1 text-white hover:bg-blue-400 rounded-md">
                  Mark as Picked Up
                </button>
              </form>
              @endif

              </span>
            </td>

            <td class="py-2 px-4 whitespace-nowrap">{{ $application->pickup_date ? $application->pickup_date->format('F
              j, Y') : 'Not set' }}</td>

            <td class="py-2 px-4 whitespace-nowrap">{{ $application->created_at->format('M d, Y h:i A') }}</td>
            <td class="py-2 px-4 text-center whitespace-nowrap">
              <span class="flex justify-around items-center gap-1">
                @if ($application->status !== 'picked up')
                <!-- Approve Button -->
                <button
                  class="bg-green-500 p-1 text-sm text-white hover:bg-green-400 w-32 rounded-md text-center approve-btn"
                  data-id="{{ $application->id }}" data-pickup="{{ $application->pickup_date }}">
                  {{ $application->pickup_date ? 'Reschedule' : 'Approve' }}
                </button>

                <!-- Reject Button -->
                <button
                  class="bg-red-500 p-1 text-sm text-white hover:bg-red-400 w-24 rounded-md text-center reject-btn"
                  data-id="{{ $application->id }}">
                  Reject
                </button>
                @else
                <button
                  class="bg-blue-500 p-1 text-sm text-white hover:bg-blue-400 w-full rounded-md text-center disabled">
                  Picked Up
                </button>
                @endif
              </span>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      {{ $adoptionApplications->links() }}
    </div>
  </div>

  <!-- Pet Info Modal -->
  <div id="petInfoModal" class="fixed inset-0 px-1 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">

      <!-- Close Button (X) -->
      <button id="closePetInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph ph-x text-xl"></i> <!-- Using Phosphor Icons -->
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Pet Information</h2>

      <!-- Pet Image -->
      <div class="flex justify-start gap-4 my-4">
        <img id="petImage" src="" alt="Pet Image" class="w-1/2 h-auto object-cover rounded-md">

        <div>
          <p><strong>Pet No:</strong> #<span id="petNumber"></span></p>
          <p><strong>Species:</strong> <span id="petSpecies"></span></p>
          <p><strong>Breed:</strong> <span id="petBreed"></span></p>
          <p><strong>Age:</strong> <span id="petAge"></span> <span id="petAgeUnit"></span></p>
          <p><strong>Color:</strong> <span id="petColor"></span></p>
          <p><strong>Sex:</strong> <span id="petSex"></span></p>
        </div>
      </div>
    </div>
  </div>


  <!-- Adopter Info Modal -->
  <div id="adopterInfoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <!-- Close Button (X) -->
      <button id="closeAdopterInfoModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph ph-x text-xl"></i> <!-- Using Phosphor Icons -->
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Adopter's Information</h2>
      <p><strong>Name:</strong> <span id="adopterName"></span></p>
      <p><strong>Email:</strong> <span id="adopterEmail"></span></p>
      <p><strong>Age:</strong> <span id="adopterAge"></span></p>
      <p><strong>Birthdate:</strong> <span id="adopterBirthdate"></span></p>
      <p><strong>Address:</strong> <span id="adopterAddress"></span></p>
      <p><strong>Phone:</strong> <span id="adopterPhone"></span></p>
      <p><strong>Civil Status:</strong> <span id="adopterCivilStatus"></span></p>
      <p><strong>Citizenship:</strong> <span id="adopterCitizenship"></span></p>

    </div>
  </div>

  <!-- Approve Modal -->
  <div id="approveModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">

      <!-- Close Button -->
      <button type="button" id="closeApproveModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph ph-x text-xl"></i> <!-- Phosphor Icons -->
      </button>

      <h2 class="text-xl font-semibold text-gray-800">Approve Adoption</h2>
      <p class="mb-4">Contact the adopter and set a pickup schedule:</p>

      <!-- Form -->
      <form id="approveForm" method="POST" action="/admin/adoption-applications/approve">
        @csrf
        @method('PATCH')
        <input type="hidden" name="application_id" id="applicationId">

        <!-- Date Input -->
        <label for="pickupDate" class="block font-medium text-gray-700">Pickup Date:</label>
        <input type="date" id="pickupDate" name="pickup_date" class="w-full border p-2 rounded-md mb-4" required>

        <button type="submit" class="bg-green-500 px-4 py-2 text-white hover:bg-green-400 rounded-md w-full">
          Submit
        </button>
      </form>
    </div>
  </div>


</x-admin-layout>