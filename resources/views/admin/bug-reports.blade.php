<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Bug Reports</h1>
        <p class="text-gray-600">Manage and track bug reports from users</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $bugReports->where('status',
                        'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">In Progress</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $bugReports->where('status',
                        'in_progress')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Resolved</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $bugReports->where('status',
                        'resolved')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bug Reports Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($bugReports as $bugReport)
        <div class="bg-white rounded-lg shadow border hover:shadow-lg transition-shadow">
            <!-- Compact Header -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1 min-w-0">
                        @if($bugReport->user)
                        <h3 class="font-semibold text-gray-900 truncate">{{ $bugReport->user->name }}</h3>
                        <p class="text-xs text-gray-500 truncate">{{ $bugReport->user->email }}</p>
                        @else
                        <h3 class="font-semibold text-gray-900">Anonymous User</h3>
                        <p class="text-xs text-gray-500">No account</p>
                        @endif
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ml-2 flex-shrink-0
                            @if($bugReport->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($bugReport->status === 'in_progress') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif">
                        {{ ucfirst(str_replace('_', ' ', $bugReport->status)) }}
                    </span>
                </div>

                <div class="text-xs text-gray-500 space-y-1">
                    <p>Reported: {{ $bugReport->created_at->format('M d, Y H:i') }}</p>
                    @if($bugReport->page_url)
                    <p class="truncate">Page:
                        <a href="{{ $bugReport->page_url }}" target="_blank"
                            class="text-orange-600 hover:text-orange-800">
                            {{ Str::limit(parse_url($bugReport->page_url, PHP_URL_PATH) ?: $bugReport->page_url, 30)
                            }}
                        </a>
                    </p>
                    @endif
                </div>
            </div>

            <!-- Compact Content -->
            <div class="p-4 space-y-3">
                <!-- Description -->
                <div>
                    <h4 class="text-xs font-medium text-gray-700 mb-1">Bug Description:</h4>
                    <div class="text-sm text-gray-900 overflow-hidden">
                        <span id="description-preview-{{ $bugReport->id }}">
                            {{ Str::limit($bugReport->description, 80) }}
                        </span>
                        @if(strlen($bugReport->description) > 80)
                        <button
                            onclick="showFullDescription({{ $bugReport->id }}, `{{ addslashes($bugReport->description) }}`)"
                            class="text-orange-600 hover:text-orange-800 text-xs mt-1">
                            Read more
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Screenshot -->
                @if($bugReport->screenshot_path)
                <div>
                    <button onclick="viewScreenshot('{{ asset('storage/' . $bugReport->screenshot_path) }}')"
                        class="text-orange-600 hover:text-orange-800 text-xs font-medium">
                        📷 View Screenshot
                    </button>
                </div>
                @endif

                <!-- Admin Notes -->
                <div>
                    <h4 class="text-xs font-medium text-gray-700 mb-1">Admin Notes:</h4>
                    <div class="text-sm text-gray-900">
                        @if($bugReport->admin_notes)
                        <span id="notes-preview-{{ $bugReport->id }}">
                            {{ Str::limit($bugReport->admin_notes, 60) }}
                        </span>
                        @if(strlen($bugReport->admin_notes) > 60)
                        <button
                            onclick="showFullNotes({{ $bugReport->id }}, `{{ addslashes($bugReport->admin_notes) }}`)"
                            class="text-orange-600 hover:text-orange-800 text-xs mt-1">
                            Read more
                        </button>
                        @endif
                        @else
                        <p class="text-gray-500 italic text-xs">No notes added yet</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex space-x-2">
                    <button
                        onclick="openStatusModal({{ $bugReport->id }}, '{{ $bugReport->status }}', `{{ addslashes($bugReport->admin_notes) }}`)"
                        class="flex-1 px-3 py-2 bg-orange-500 text-white text-sm rounded-md hover:bg-orange-600 transition-colors">
                        Update Status
                    </button>
                    <button
                        onclick="openDeleteModal({{ $bugReport->id }}, '{{ $bugReport->user ? $bugReport->user->name : 'Anonymous User' }}')"
                        class="px-3 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white p-8 rounded-lg shadow border text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Bug Reports</h3>
                <p class="text-gray-500">There are no bug reports to display.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($bugReports->hasPages())
    <div class="mt-6">
        {{ $bugReports->links() }}
    </div>
    @endif
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal"
        class="fixed px-1 inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Bug Report Status</h3>
                <form id="statusUpdateForm">
                    @csrf
                    <input type="hidden" id="bugReportId" name="bug_report_id">

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="adminNotes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                        <textarea id="adminNotes" name="admin_notes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="Add notes about the bug report..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeStatusModal()"
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed px-1 inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center mb-4">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Bug Report</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Are you sure you want to delete the bug report from <span id="deleteUserName"
                            class="font-medium"></span>?
                        This action cannot be undone.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <button onclick="closeDeleteModal()"
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button onclick="confirmDelete()"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Screenshot Modal -->
    <div id="screenshotModal"
        class="fixed px-1 inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="p-5 border w-11/12 max-w-3xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Screenshot</h3>
                    <button onclick="closeScreenshotModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="text-center">
                    <img id="screenshotImage" class="w-full h-auto max-h-96 object-contain mx-auto"
                        alt="Bug Report Screenshot">
                </div>
            </div>
        </div>
    </div>

    <!-- Full Description Modal -->
    <div id="descriptionModal"
        class="fixed px-1 inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Bug Description</h3>
                    <button onclick="closeDescriptionModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg max-h-64 overflow-y-auto">
                    <p id="fullDescription" class="text-gray-900 whitespace-pre-wrap break-words"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Notes Modal -->
    <div id="fullNotesModal"
        class="fixed px-1 inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Admin Notes</h3>
                    <button onclick="closeFullNotesModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg max-h-64 overflow-y-auto">
                    <p id="fullNotes" class="text-gray-900 whitespace-pre-wrap break-words"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Delete modal variables
        let deleteBugReportId = null;



        // Delete modal functions
        function openDeleteModal(id, userName) {
            deleteBugReportId = id;
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteBugReportId = null;
        }

        function confirmDelete() {
            if (deleteBugReportId) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/bug-reports/${deleteBugReportId}`;
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Add method override
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function openStatusModal(id, status, notes) {
            console.log('Opening status modal for bug report:', id, 'with status:', status);
            document.getElementById('bugReportId').value = id;
            document.getElementById('status').value = status;
            document.getElementById('adminNotes').value = notes || '';
            document.getElementById('statusModal').classList.remove('hidden');
            
            // Verify the form is populated correctly
            console.log('Form values after population:');
            console.log('ID:', document.getElementById('bugReportId').value);
            console.log('Status:', document.getElementById('status').value);
            console.log('Notes:', document.getElementById('adminNotes').value);
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function viewScreenshot(imageSrc) {
            document.getElementById('screenshotImage').src = imageSrc;
            document.getElementById('screenshotModal').classList.remove('hidden');
        }

        function closeScreenshotModal() {
            document.getElementById('screenshotModal').classList.add('hidden');
        }

        function showFullDescription(id, description) {
            document.getElementById('fullDescription').textContent = description;
            document.getElementById('descriptionModal').classList.remove('hidden');
        }

        function closeDescriptionModal() {
            document.getElementById('descriptionModal').classList.add('hidden');
        }

        function showFullNotes(id, notes) {
            document.getElementById('fullNotes').textContent = notes;
            document.getElementById('fullNotesModal').classList.remove('hidden');
        }

        function closeFullNotesModal() {
            document.getElementById('fullNotesModal').classList.add('hidden');
        }

        // Handle status update form submission
        document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const bugReportId = document.getElementById('bugReportId').value;
            const status = document.getElementById('status').value;
            const adminNotes = document.getElementById('adminNotes').value;
            
            console.log('Submitting status update for bug report:', bugReportId);
            console.log('Status:', status);
            console.log('Admin notes content:', adminNotes);
            
            // Test if the form data is correct
            if (!bugReportId) {
                alert('Error: Bug report ID is missing');
                return;
            }
            
            if (!status) {
                alert('Error: Status is required');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Create form data with all required fields
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('_method', 'PATCH');
            formData.append('status', status);
            formData.append('admin_notes', adminNotes);
            
            // Test the request URL
            const requestUrl = `/admin/bug-reports/${bugReportId}/status`;
            console.log('Request URL:', requestUrl);
            
            fetch(requestUrl, {
                method: 'POST', // Using POST with _method for compatibility
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    closeStatusModal();
                    location.reload();
                } else {
                    alert('Failed to update status: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
                alert('Error updating status: ' + error.message);
            });
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'statusModal') {
                closeStatusModal();
            }
            if (e.target.id === 'deleteModal') {
                closeDeleteModal();
            }
            if (e.target.id === 'screenshotModal') {
                closeScreenshotModal();
            }
            if (e.target.id === 'descriptionModal') {
                closeDescriptionModal();
            }
            if (e.target.id === 'fullNotesModal') {
                closeFullNotesModal();
            }
        });
    </script>

</x-admin-layout>