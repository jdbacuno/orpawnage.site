<x-transactions-layout>
  <div class="flex flex-col flex-wrap gap-x-4 gap-y-6">
    <!-- Filters Section -->
    <div class="flex flex-wrap gap-4 items-center justify-start mb-1">
      <form method="GET" action="/transactions/abused-status" class="flex flex-wrap gap-4">
        <!-- Status Filter -->
        <select name="status"
          class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg p-2.5 min-w-[200px]"
          onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
          <option value="acknowledged" {{ request('status')=='acknowledged' ? 'selected' : '' }}>Acknowledged</option>
          <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
      </form>
    </div>

    @if ($abusedReports->isEmpty())
    <div class="w-full text-center text-gray-500 text-lg">
      No abused / stray reports found.
    </div>
    @else

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-6">
      @foreach($abusedReports as $report)
      <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 flex flex-col justify-between h-[320px]">
        <!-- Card Content -->
        <div class="flex-1 overflow-y-auto">
          <div class="flex justify-between items-start">
            <h3 class="text-xl font-semibold flex items-center"><i class="ph-fill ph-tag mr-2"></i> {{
              $report->report_number }}</h3>
          </div>
          <p class="text-sm text-gray-500 mt-2"><strong>Reported by:</strong> {{ ucwords($report->full_name) ?? 'N/A' }}
          </p>
          <p class="text-sm text-gray-500 mt-1"><strong>Contact Number:</strong> {{ $report->contact_no }}</p>
          <p class="text-sm text-gray-500 mt-1"><strong>Location of Incident:</strong> {{ $report->incident_location }}
          </p>
          <p class="text-sm text-gray-500 mt-1"><strong>Date of Incident:</strong> {{
            \Carbon\Carbon::parse($report->incident_date)->format('F j, Y')
            }}</p>
          <p class="text-sm text-gray-500 mt-1"><strong>Type of Animal:</strong> {{ $report->species }}</p>
          <p class="text-sm text-gray-500 mt-1"><strong>Condition:</strong> {{ $report->animal_condition }}</p>

          @php
          $notePreviewLimit = 20;
          $noteIsLong = Str::length($report->additional_notes) > $notePreviewLimit;
          @endphp

          <div class="mt-1">
            <p class="text-sm text-gray-500"><strong>Notes:</strong>
              {{ $noteIsLong ?
              Str::limit($report->additional_notes,
              $notePreviewLimit) : $report->additional_notes }}

              @if ($noteIsLong)
              <button type="button" class="text-blue-500 hover:underline text-sm mt-1 show-more-btn"
                data-notes="{{ $report->additional_notes }}">
                Show more
              </button>
              @endif
            </p>
          </div>
        </div>

        <div class="mt-2 flex justify-between items-center">
          <!-- View Photo on the left -->
          <div>
            {{-- <a href="{{ asset('storage/' . $report->incident_photo) }}" target="_blank"
              class="text-blue-500 hover:underline text-sm">
              View Photo
            </a> --}}
            <button type="button" data-image="{{ asset('storage/' . $report->incident_photo) }}"
              class="text-blue-500 hover:underline text-sm show-image-btn">
              View Photo
            </button>
          </div>

          <!-- Action Buttons on the right -->
          <div class="flex space-x-1">
            <!-- Status Badge -->
            @if($report->status === 'pending')
            <span class="bg-yellow-500 text-white px-3 py-1 rounded-md text-sm cursor-pointer">Waiting for Review</span>
            @elseif($report->status === 'rejected')
            <span class="italic bg-gray-500 text-white px-3 py-1 rounded-md text-sm cursor-pointer">Rejected</span>
            @elseif($report->status === 'acknowledged')
            <span class="bg-green-500 text-white px-3 py-1 rounded-md text-sm cursor-pointer">Notified via Email</span>
            @else
            <span class="bg-gray-500 text-white px-3 py-1 rounded-md text-sm cursor-pointer">{{ ucfirst($report->status)
              }}</span>
            @endif

            <!-- Delete Button (always visible) -->
            <button type="button" class="bg-red-600 text-sm text-white py-1 px-2 hover:bg-red-700 rounded-md delete-btn"
              data-report-id="{{ $report->id }}" data-report-number="{{ $report->report_number }}">
              Delete
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    @endif
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $abusedReports->appends(request()->except('page'))->links() }}
  </div>

  {{-- Note Modal for Long Text --}}
  <div id="notesModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">

      <!-- Close Button -->
      <button id="closeNotesModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-lg font-semibold text-gray-800">Additional Notes</h2>
      <p id="fullNotesText" class="text-sm text-gray-700 whitespace-pre-wrap mt-2"></p>
    </div>
  </div>

  {{-- image modal --}}
  <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg relative max-w-2xl w-full">
      <!-- Close Button -->
      <button id="closeImageModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-lg font-semibold text-gray-800">Incident Photo</h2>

      <!-- Image Container -->
      <div class="w-full mt-2 overflow-hidden rounded-lg">
        <img id="modalImage" alt="Incident Photo" class="w-full h-auto object-cover rounded-lg">
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="closeDeleteModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
        <i class="ph-fill ph-x text-xl"></i>
      </button>

      <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm Deletion</h2>
      <p id="deleteMessage" class="text-gray-700 mb-6">Are you sure you want to delete this report?</p>

      <div class="flex justify-end gap-3">
        <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Cancel</button>
        <form id="deleteForm" method="POST" class="inline-block">
          @csrf
          @method('DELETE')
          <input type="hidden" name="report_id" id="deleteReportId">
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>

</x-transactions-layout>