<x-layout>
  <!-- ========== ADOPTION REQUESTS SECTION ========== -->
  <section class="py-20 px-5 lg:px-20">
    <h2 class="text-2xl font-semibold text-orange-500 mb-6">
      Adoption Applications
    </h2>

    <div class="flex flex-wrap gap-x-4 gap-y-6">
      @if ($adoptionApplications->isEmpty())
      <div class="w-full text-center text-gray-500 text-lg">
        No adoption applications found.
      </div>
      @else
      @foreach ($adoptionApplications as $application)
      <div
        class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col w-full sm:w-[48%] lg:w-[32%] max-w-sm flex-grow min-h-full">

        <!-- Pet Image -->
        <img src="{{ asset('storage/' . $application->pet->image_path) }}" alt="Pet Image"
          class="w-full h-52 object-cover" />

        <!-- Content -->
        <div class="p-6 flex-1 overflow-y-auto">
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            Adoption Request for Pet#{{ $application->pet->pet_number }}
          </h3>

          <p class="text-sm text-gray-700">
            <strong>Date of Pick-up:</strong>
            @if ($application->status === 'Rejected')
            Rejected
            @else
            {{ $application->pickup_date ? $application->pickup_date->format('M d, Y') : 'To be scheduled' }}
            @endif
          </p>

          <p class="text-sm text-gray-700"><strong>Species:</strong> {{ ucfirst($application->pet->species) }}</p>
          <p class="text-sm text-gray-700"><strong>Breed:</strong> {{ ucfirst($application->pet->breed) }}</p>
          <p class="text-sm text-gray-700">
            <strong>Age:</strong> {{ $application->pet->age }} {{ ucfirst($application->pet->age_unit) }}
          </p>
          <p class="text-sm text-gray-700"><strong>Gender:</strong> {{ ucfirst($application->pet->sex) }}</p>
          <p class="text-sm text-gray-700"><strong>Color:</strong> {{ ucfirst($application->pet->color) }}</p>
          <p class="text-sm text-gray-700"><strong>Status:</strong> {{ ucfirst($application->status) }}</p>

          @if ($application->status === 'rejected')
          <p class="text-sm text-gray-700">
            <strong>Reason for Rejection:</strong>
            <span id="rejectReasonShort">
              {{ ucfirst(Str::limit($application->reject_reason, 10, '...')) }}
            </span>
            <span id="rejectReasonFull" class="hidden">
              {{ ucfirst($application->reject_reason) }}
            </span>
            @if (strlen($application->reject_reason) > 10)
            <button id="seeMoreBtn" onclick="toggleRejectReason()" class="text-blue-600 text-sm underline">
              See More
            </button>
            @endif
          </p>
          @endif
        </div>

        <!-- Button Section -->
        <div class="p-6 pt-0">
          @if ($application->status === 'to be picked up' || $application->status === 'to be scheduled')
          <div class="flex items-center gap-2">
            <button class="flex-1 bg-green-600 text-white font-medium rounded-lg py-2 disabled cursor-not-allowed">
              {{ $application->status === 'to be picked up' ? 'Pick-up on ' .
              $application->pickup_date->format('M d, Y') : 'To be scheduled' }}
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="bg-red-600 text-white font-medium rounded-lg px-4 py-2">
              Cancel
            </button>
          </div>
          @elseif ($application->status === 'rejected')
          <div class="flex items-center gap-2">
            <button class="w-full bg-black text-white font-medium rounded-lg py-2 disabled cursor-not-allowed">
              Rejected
            </button>
            <button onclick="openCancelModal({{ $application->id }})"
              class="bg-red-600 text-white font-medium rounded-lg px-4 py-2">
              Delete
            </button>
          </div>
          @elseif ($application->status === 'picked up')
          <button class="w-full bg-blue-500 text-white font-medium rounded-lg py-2 disabled cursor-not-allowed"
            disabled>
            Picked up
          </button>
          @else
          <button class="w-full bg-gray-600 text-white font-medium rounded-lg py-2 cursor-not-allowed" disabled>
            Pending for Approval
          </button>
          @endif
        </div>
      </div>
      @endforeach

      <!-- Pagination -->
      <div class="mt-6 flex justify-center">
        {{ $adoptionApplications->links() }}
      </div>
      @endif
    </div>



  </section>

  <!-- ========== SURRENDER REQUESTS SECTION ========== -->
  <section class="pt-10 pb-20 px-5 lg:px-20 border-t border-t-gray-200">
    <h2 class="text-2xl font-semibold text-orange-500 mb-6">
      Surrender Applications
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-1 gap-y-6">
      <!-- Surrender Request Card -->
      <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col max-w-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          Surrender Request
        </h3>

        <p class="text-sm text-gray-700">
          <strong>Request ID:</strong> 12345678
        </p>
        <p class="text-sm text-gray-700"><strong>Species:</strong> Dog</p>
        <p class="text-sm text-gray-700"><strong>Breed:</strong> Askal</p>
        <p class="text-sm text-gray-700"><strong>Sex:</strong> Male</p>
        <p class="text-sm text-gray-700 truncate">
          <strong>Reason:</strong> Unable to provide care lorem ipsum dolor
          sit amet consectetur, adipisicing elit. Corporis ad consequatur
          error provident dolorem odio ullam voluptates, saepe beatae dicta.
        </p>

        <div class="mt-auto pt-6">
          <button class="w-full bg-gray-600 text-white font-medium rounded-lg py-2 cursor-not-allowed" disabled>
            Pending for Review
          </button>
        </div>
      </div>

      <!-- Surrender Request Card -->
      <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col max-w-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          Surrender Request
        </h3>

        <p class="text-sm text-gray-700">
          <strong>Request ID:</strong> 789456123
        </p>
        <p class="text-sm text-gray-700"><strong>Species:</strong> Dog</p>
        <p class="text-sm text-gray-700"><strong>Breed:</strong> Askal</p>
        <p class="text-sm text-gray-700"><strong>Sex:</strong> Male</p>
        <p class="text-sm text-gray-700 truncate">
          <strong>Reason:</strong> Unable to provide care
        </p>

        <div class="mt-auto pt-6">
          <button class="w-full bg-gray-600 text-white font-medium rounded-lg py-2 cursor-not-allowed" disabled>
            Denied
          </button>
        </div>
      </div>

      <!-- Surrender Request Card -->
      <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col max-w-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          Surrender Request
        </h3>

        <p class="text-sm text-gray-700">
          <strong>Request ID:</strong> 258963147
        </p>
        <p class="text-sm text-gray-700"><strong>Species:</strong> Cat</p>
        <p class="text-sm text-gray-700"><strong>Breed:</strong> Puspin</p>
        <p class="text-sm text-gray-700"><strong>Sex:</strong> Male</p>
        <p class="text-sm text-gray-700 truncate">
          <strong>Reason:</strong> Too old
        </p>

        <div class="mt-auto pt-6">
          <button class="w-full bg-green-600 text-white font-medium rounded-lg py-2 cursor-not-allowed" disabled>
            Approved
          </button>
        </div>
      </div>
    </div>
  </section>

  @if(!$adoptionApplications->isEmpty())
  <!-- Cancel/Delete Confirmation Modal -->
  <div id="cancelModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
      <h2 class="text-lg font-semibold mb-4">Confirm Action</h2>
      <p class="text-sm text-gray-600">Are you sure you want to cancel/delete this adoption request?</p>

      <div class="mt-4 flex justify-end gap-2">
        <button onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>

        <form id="deleteForm" method="POST" action="{{ url('/transactions/' . $application->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Confirm</button>
        </form>
      </div>
    </div>
  </div>
  @endif
</x-layout>