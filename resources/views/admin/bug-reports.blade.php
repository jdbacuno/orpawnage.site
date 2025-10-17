<x-admin-layout>
    <div class="max-w-[1600px] mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Bug Reports Management</h1>
            <p class="text-sm text-gray-600 mt-2">Review and manage bug reports submitted by users.</p>
        </div>

        @if (session('success'))
        <div id="global-alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-lg bg-green-50 border-l-4 border-green-400" role="alert">
            <svg class="shrink-0 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">{!! session('success') !!}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 h-8 w-8" onclick="this.parentElement.remove()">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        @endif

        <!-- Status Tabs and Search -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
            <!-- Status Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto scrollbar-hidden" aria-label="Tabs">
                    <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
                            {{ !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="ph-fill ph-files mr-2"></i>
                        All Reports
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
                            {{ request('status') === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="ph-fill ph-clock mr-2"></i>
                        Pending
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'in_progress']) }}"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
                            {{ request('status') === 'in_progress' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="ph-fill ph-gear mr-2"></i>
                        In Progress
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'resolved']) }}"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors
                            {{ request('status') === 'resolved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="ph-fill ph-check-circle mr-2"></i>
                        Resolved
                    </a>
                </nav>
            </div>

            <!-- Search Bar -->
            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap gap-4 items-center">
                    <div class="flex-1 min-w-[300px]">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by username, bug description, admin notes, or report ID"
                                class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 pl-10 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition" />
                            <div class="absolute left-3 inset-y-0 flex items-center h-full pointer-events-none">
                                <i class="ph-fill ph-magnifying-glass text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="status" value="{{ request('status') }}" />

                    @if(request('search'))
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                        class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
                        <i class="ph-fill ph-x mr-1"></i>Clear
                    </a>
                    @endif
                </form>
            </div>
        </div>

        @if($bugReports->isEmpty())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i class="ph-fill ph-bug text-5xl text-gray-300 mb-4"></i>
            <p class="text-lg text-gray-500">No bug reports found.</p>
        </div>
        @else
        <div class="space-y-6">
            @foreach($bugReports as $bugReport)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Report Header -->
                <div class="bg-gradient-to-r from-orange-50 to-red-50 border-b border-gray-200 p-6">
                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <div class="flex-1 min-w-0 w-full">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-4">
                                <div class="min-w-0 flex-1">
                                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                                        @if($bugReport->user)
                                        {{ $bugReport->user->username }}
                                        @else
                                        Anonymous Reporter
                                        @endif
                                        <span class="text-base text-gray-500">#{{ $bugReport->id }}</span>
                                    </h2>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                      @if($bugReport->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                      @elseif($bugReport->status === 'in_progress') bg-blue-100 text-blue-800 border border-blue-200
                      @else bg-green-100 text-green-800 border border-green-200
                      @endif">
                                            <i class="ph-fill ph-{{ $bugReport->status === 'pending' ? 'clock' : ($bugReport->status === 'in_progress' ? 'gear' : 'check-circle') }} mr-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $bugReport->status)) }}
                                        </span>
                                        @if($bugReport->user)
                                        <span class="px-3 py-1 bg-white border border-gray-300 rounded-full text-sm text-gray-700">
                                            <i class="ph-fill ph-envelope mr-1"></i>{{ $bugReport->user->email }}
                                        </span>
                                        @elseif($bugReport->email)
                                        <span class="px-3 py-1 bg-white border border-gray-300 rounded-full text-sm text-gray-700">
                                            <i class="ph-fill ph-envelope mr-1"></i>{{ $bugReport->email }}
                                        </span>
                                        @endif
                                        @if($bugReport->screenshot_path)
                                        <span class="px-3 py-1 bg-orange-100 border border-orange-300 rounded-full text-sm text-orange-700">
                                            <i class="ph-fill ph-image mr-1"></i>Screenshot
                                        </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-sm text-gray-600">
                                        <span>
                                            <i class="ph-fill ph-calendar mr-1"></i>
                                            {{ $bugReport->created_at->format('M d, Y H:i') }}
                                        </span>
                                        @if($bugReport->resolved_at)
                                        <span class="text-green-600">
                                            <i class="ph-fill ph-check-circle mr-1"></i>
                                            {{ \Carbon\Carbon::parse($bugReport->resolved_at)->format('M d, Y') }}
                                        </span>
                                        @endif
                                    </div>
                                    @if($bugReport->page_url)
                                    <div class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                        <i class="ph-fill ph-link"></i>
                                        <a href="{{ $bugReport->page_url }}" target="_blank" class="text-orange-600 hover:text-orange-800 truncate">
                                            {{ Str::limit(parse_url($bugReport->page_url, PHP_URL_PATH) ?: $bugReport->page_url, 50) }}
                                        </a>
                                    </div>
                                    @endif
                                </div>

                                <div class="flex gap-2">
                                    <button onclick="openStatusModal({{ $bugReport->id }}, '{{ $bugReport->status }}', `{{ addslashes($bugReport->admin_notes ?? '') }}`)"
                                        class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium">
                                        <i class="ph-fill ph-pencil-simple mr-1"></i>Update
                                    </button>
                                    <button onclick="openDeleteModal({{ $bugReport->id }}, '{{ $bugReport->user ? $bugReport->user->username : 'Anonymous Reporter' }}')"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium">
                                        <i class="ph-fill ph-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <button onclick="toggleBugDetails('{{ $bugReport->id }}')"
                                class="w-full bg-white hover:bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-left transition-colors flex items-center justify-between group">
                                <span class="font-medium text-gray-700 group-hover:text-gray-900 flex items-center gap-2">
                                    <i id="bug-icon-{{ $bugReport->id }}" class="ph-fill ph-caret-right text-gray-400 group-hover:text-orange-600 transition-transform duration-200"></i>
                                    View Bug Details & Description
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Details Section -->
                <div id="bug-details-{{ $bugReport->id }}" class="hidden border-t border-gray-200">
                    <div class="p-6 bg-gray-50 space-y-6">
                        <!-- Bug Description -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="ph-fill ph-text-align-left mr-2 text-orange-600"></i>
                                Bug Description
                            </h3>
                            <div class="bg-white border border-gray-300 rounded-lg p-4">
                                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $bugReport->description }}</p>
                            </div>
                        </div>

                        <!-- Screenshot -->
                        @if($bugReport->screenshot_path)
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="ph-fill ph-image mr-2 text-orange-600"></i>
                                Screenshot
                            </h3>
                            <button onclick="viewScreenshot('{{ asset('storage/' . $bugReport->screenshot_path) }}')" 
                                class="flex items-center gap-2 px-4 py-3 bg-orange-50 border-2 border-orange-300 text-orange-700 rounded-lg hover:bg-orange-100 transition-colors text-sm font-medium">
                                <i class="ph-fill ph-image text-lg"></i>
                                <span>View Screenshot</span>
                            </button>
                        </div>
                        @endif

                        <!-- Admin Notes -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="ph-fill ph-note mr-2 text-orange-600"></i>
                                Admin Notes
                            </h3>
                            <div class="bg-white border border-gray-300 rounded-lg p-4">
                                @if($bugReport->admin_notes)
                                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $bugReport->admin_notes }}</p>
                                @else
                                <div class="text-center py-4">
                                    <i class="ph-fill ph-note-blank text-3xl text-gray-300 mb-2"></i>
                                    <p class="text-sm text-gray-500 italic">No admin notes</p>
                                    <button onclick="openStatusModal({{ $bugReport->id }}, '{{ $bugReport->status }}', '')" 
                                        class="mt-2 text-orange-600 hover:text-orange-800 text-sm font-medium">
                                        <i class="ph-fill ph-plus mr-1"></i>Add Notes
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Technical Info -->
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="ph-fill ph-code mr-2 text-orange-600"></i>
                                Technical Information
                            </h3>
                            <div class="bg-white border border-gray-300 rounded-lg p-4 space-y-3">
                                @if($bugReport->user_agent)
                                <div>
                                    <label class="text-xs font-medium text-gray-600 uppercase tracking-wider">Browser/Device</label>
                                    <p class="mt-1 text-xs text-gray-700 bg-gray-50 p-2 rounded break-all">{{ $bugReport->user_agent }}</p>
                                </div>
                                @endif
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs font-medium text-gray-600 uppercase tracking-wider">Report ID</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">#{{ $bugReport->id }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-600 uppercase tracking-wider">Submitted</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $bugReport->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($bugReports->hasPages())
        <div class="mt-6">
            {{ $bugReports->links() }}
        </div>
        @endif
        @endif
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-auto">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Update Bug Report</h3>
                        <p class="text-sm text-gray-600 mt-2">Update the status and add notes about this bug report.</p>
                    </div>
                    <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="ph-fill ph-x text-2xl"></i>
                    </button>
                </div>

                <form id="statusUpdateForm">
                    @csrf
                    <input type="hidden" id="bugReportId" name="bug_report_id">

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="adminNotes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                        <textarea id="adminNotes" name="admin_notes" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none" placeholder="Add notes about the bug report, actions taken, or resolution details..." maxlength="1000"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maximum 1000 characters</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeStatusModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 bg-orange-500 px-4 py-2 text-white hover:bg-orange-600 rounded-lg transition-colors font-medium">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-auto">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Delete Bug Report</h3>
                        <p class="text-sm text-gray-600 mt-2">Are you sure you want to delete this bug report?</p>
                    </div>
                    <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="ph-fill ph-x text-2xl"></i>
                    </button>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex">
                        <i class="ph-fill ph-warning text-red-600 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm text-red-800 font-medium">This action cannot be undone</p>
                            <p class="text-sm text-red-700">
                                Bug report from <span id="deleteUserName" class="font-semibold"></span> will be permanently deleted.
                            </p>
                        </div>
                    </div>
                </div>

                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 bg-red-600 px-4 py-2 text-white hover:bg-red-700 rounded-lg transition-colors font-medium">
                            Delete Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Screenshot Modal -->
    <div id="screenshotModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl mx-auto">
            <button onclick="closeScreenshotModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
                <i class="ph-fill ph-x text-2xl"></i>
            </button>
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <div class="p-4 bg-gray-900 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Bug Report Screenshot</h3>
                    <a id="screenshotDownload" href="" download class="text-white hover:text-gray-300">
                        <i class="ph-fill ph-download text-lg"></i>
                    </a>
                </div>
                <div class="flex items-center justify-center bg-gray-100 p-4 max-h-[70vh] overflow-auto">
                    <img id="screenshotImage" class="max-w-full h-auto rounded shadow-lg" alt="Bug Report Screenshot">
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBugDetails(id) {
            const details = document.getElementById('bug-details-' + id);
            const icon = document.getElementById('bug-icon-' + id);
            const isHidden = details.classList.contains('hidden');
            
            details.classList.toggle('hidden');
            icon.classList.toggle('ph-caret-right', !isHidden);
            icon.classList.toggle('ph-caret-down', isHidden);
        }

        function openStatusModal(id, status, notes) {
            document.getElementById('bugReportId').value = id;
            document.getElementById('status').value = status;
            document.getElementById('adminNotes').value = notes || '';
            
            const modal = document.getElementById('statusModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function openDeleteModal(id, userName) {
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteForm').action = `/admin/bug-reports/${id}`;
            
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function viewScreenshot(imageSrc) {
            document.getElementById('screenshotImage').src = imageSrc;
            document.getElementById('screenshotDownload').href = imageSrc;
            
            const modal = document.getElementById('screenshotModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeScreenshotModal() {
            const modal = document.getElementById('screenshotModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Handle status update form submission
        document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const bugReportId = document.getElementById('bugReportId').value;
            const status = document.getElementById('status').value;
            const adminNotes = document.getElementById('adminNotes').value;

            if (!bugReportId || !status) {
                alert('Error: Required fields are missing');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('_method', 'PATCH');
            formData.append('status', status);
            formData.append('admin_notes', adminNotes);

            // Disable submit button
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Updating...';

            fetch(`/admin/bug-reports/${bugReportId}/status`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeStatusModal();
                    location.reload();
                } else {
                    alert('Failed to update status: ' + (data.message || 'Unknown error'));
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
                alert('Error updating status');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });

        // Close modals when clicking outside
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    if (this.id === 'statusModal') closeStatusModal();
                    if (this.id === 'deleteModal') closeDeleteModal();
                    if (this.id === 'screenshotModal') closeScreenshotModal();
                }
            });
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStatusModal();
                closeDeleteModal();
                closeScreenshotModal();
            }
        });

        // Auto-hide success alert after 5 seconds
        const successAlert = document.getElementById('global-alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }, 5000);
        }
    </script>
</x-admin-layout>
