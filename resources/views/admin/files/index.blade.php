@extends('layouts.master')

@section('title', 'File Management')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 bg-dark text-white">
                    <div class="card-header bg-secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">File Management</h4>
                            <!--
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#uploadModal">
                                <i class="fas fa-upload me-1"></i> Upload New File
                            </button>
                            -->
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped text-white">
                                <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Size</th>
                                        <th>Plan</th>
                                        <th>Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($files as $file)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        @php
                                                            $iconClass = 'fa-file';
                                                            if (
                                                                in_array($file->extension, [
                                                                    'jpg',
                                                                    'jpeg',
                                                                    'png',
                                                                    'gif',
                                                                    'bmp',
                                                                    'svg',
                                                                ])
                                                            ) {
                                                                $iconClass = 'fa-file-image';
                                                            } elseif (in_array($file->extension, ['pdf'])) {
                                                                $iconClass = 'fa-file-pdf';
                                                            } elseif (in_array($file->extension, ['doc', 'docx'])) {
                                                                $iconClass = 'fa-file-word';
                                                            } elseif (
                                                                in_array($file->extension, ['xls', 'xlsx', 'csv'])
                                                            ) {
                                                                $iconClass = 'fa-file-excel';
                                                            } elseif (
                                                                in_array($file->extension, ['zip', 'rar', '7z'])
                                                            ) {
                                                                $iconClass = 'fa-file-archive';
                                                            } elseif (
                                                                in_array($file->extension, ['mp3', 'wav', 'ogg'])
                                                            ) {
                                                                $iconClass = 'fa-file-audio';
                                                            } elseif (
                                                                in_array($file->extension, ['mp4', 'avi', 'mov', 'wmv'])
                                                            ) {
                                                                $iconClass = 'fa-file-video';
                                                            } elseif (in_array($file->extension, ['txt', 'rtf'])) {
                                                                $iconClass = 'fa-file-alt';
                                                            } elseif (in_array($file->extension, ['ppt', 'pptx'])) {
                                                                $iconClass = 'fa-file-powerpoint';
                                                            }
                                                        @endphp
                                                        <i class="fas {{ $iconClass }} fa-2x text-danger"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $file->description }}</h6>
                                                        <small
                                                            class="text-muted">{{ Str::limit($file->description, 30) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ number_format($file->size / 1024, 2) }} KB
                                                <div class="small">{{ strtoupper($file->extension) }}</div>
                                            </td>
                                            <td>
                                                {{ $file->description }}
                                            </td>
                                            <td>
                                                {{ $file->created_at->format('M d, Y') }}
                                                <div class="small">{{ $file->created_at->format('h:i A') }}</div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                <!--
                                                    <button type="button" class="btn btn-sm btn-info view-file"
                                                        data-bs-toggle="modal" data-bs-target="#viewModal"
                                                        data-file-id="{{ $file->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    -->
                                                    <a href="{{ route('files.download', $file) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <!--
                                                    <button type="button" class="btn btn-sm btn-warning edit-file"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-file-id="{{ $file->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger delete-file"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-file-id="{{ $file->id }}"
                                                        data-file-name="{{ $file->name }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    -->
                                                    
                                                    <a href="{{ route('plans.purchases', ['plan' => $file->plan_id]) }}" class="btn btn-info mt-2">

   Purchaces
</a>




                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                                                    <h5>No files uploaded yet</h5>
                                                    <button type="button" class="btn btn-primary mt-3"
                                                        data-bs-toggle="modal" data-bs-target="#uploadModal">
                                                        <i class="fas fa-upload me-1"></i> Upload Your First File
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            {{ $files->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload File Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload New File</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">Select File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control bg-secondary text-white" id="file" name="file"
                                required>
                            <small class="form-text text-muted">Maximum file size: 10MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control bg-secondary text-white" id="description" name="description" rows="3"></textarea>
                        </div>
                      
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i> Upload File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View File Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">File Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4" id="file-icon-container">
                        <i class="fas fa-file fa-4x text-danger"></i>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>File Name:</strong> <span id="view-name"></span></p>
                            <p><strong>Original Name:</strong> <span id="view-original-name"></span></p>
                            <p><strong>Description:</strong> <span id="view-description"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>File Size:</strong> <span id="view-size"></span></p>
                            <p><strong>File Type:</strong> <span id="view-type"></span></p>
                            <p><strong>Uploaded:</strong> <span id="view-created"></span></p>
                            <p><strong>Plan:</strong> <span id="view-plan"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <a href="#" class="btn btn-primary" id="view-download-btn">
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit File Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit File</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editFileForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">File Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-secondary text-white" id="edit-name"
                                name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_file" class="form-label">Replace File (Optional)</label>
                            <input type="file" class="form-control bg-secondary text-white" id="new_file"
                                name="new_file">
                            <small class="form-text text-muted">Leave empty to keep the current file. Maximum file size:
                                10MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Description</label>
                            <textarea class="form-control bg-secondary text-white" id="edit-description" name="description" rows="3"></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete File Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the file "<span id="delete-file-name"></span>"?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteFileForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Delete File
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View File Details
            const viewFileButtons = document.querySelectorAll('.view-file');
            viewFileButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-file-id');
                    fetch(`/files/${fileId}/get`)
                        .then(response => response.json())
                        .then(file => {
                            document.getElementById('view-name').textContent = file.name;
                            document.getElementById('view-original-name').textContent = file
                                .original_name;
                            document.getElementById('view-description').textContent = file
                                .description || 'No description';
                            document.getElementById('view-size').textContent = (file.size /
                                1024).toFixed(2) + ' KB';
                            document.getElementById('view-type').textContent = file.extension
                                .toUpperCase();

                            // Format the date
                            const created = new Date(file.created_at);
                            document.getElementById('view-created').textContent = created
                                .toLocaleString();

                            // Set plan info
                            document.getElementById('view-plan').textContent = file.plan ? file
                                .plan.name : 'No Plan';

                            // Set download link
                            document.getElementById('view-download-btn').href =
                                `/files/${fileId}/download`;

                            // Set appropriate file icon
                            const iconContainer = document.getElementById(
                            'file-icon-container');
                            let iconClass = 'fa-file';

                            // Determine file icon based on extension
                            const extension = file.extension.toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'].includes(
                                extension)) {
                                iconClass = 'fa-file-image';
                            } else if (extension === 'pdf') {
                                iconClass = 'fa-file-pdf';
                            } else if (['doc', 'docx'].includes(extension)) {
                                iconClass = 'fa-file-word';
                            } else if (['xls', 'xlsx', 'csv'].includes(extension)) {
                                iconClass = 'fa-file-excel';
                            } else if (['zip', 'rar', '7z'].includes(extension)) {
                                iconClass = 'fa-file-archive';
                            } else if (['mp3', 'wav', 'ogg'].includes(extension)) {
                                iconClass = 'fa-file-audio';
                            } else if (['mp4', 'avi', 'mov', 'wmv'].includes(extension)) {
                                iconClass = 'fa-file-video';
                            } else if (['txt', 'rtf'].includes(extension)) {
                                iconClass = 'fa-file-alt';
                            } else if (['ppt', 'pptx'].includes(extension)) {
                                iconClass = 'fa-file-powerpoint';
                            }

                            iconContainer.innerHTML =
                                `<i class="fas ${iconClass} fa-4x text-danger"></i>`;
                        })
                        .catch(error => {
                            console.error('Error fetching file details:', error);
                            alert('Error loading file details.');
                        });
                });
            });

            // Edit File
            const editFileButtons = document.querySelectorAll('.edit-file');
            editFileButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-file-id');

                    // Set form action URL
                    document.getElementById('editFileForm').action = `/files/${fileId}`;

                    // Fetch file details to populate the form
                    fetch(`/files/${fileId}/get`)
                        .then(response => response.json())
                        .then(file => {
                            document.getElementById('edit-name').value = file.name;
                            document.getElementById('edit-description').value = file
                                .description || '';

                            // Set plan dropdown
                            const planSelect = document.getElementById('edit-plan_id');
                            if (file.plan_id) {
                                planSelect.value = file.plan_id;
                            } else {
                                planSelect.value = '';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching file details:', error);
                            alert('Error loading file details for editing.');
                        });
                });
            });

            // Delete File
            const deleteFileButtons = document.querySelectorAll('.delete-file');
            deleteFileButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-file-id');
                    const fileName = this.getAttribute('data-file-name');

                    // Set form action URL for delete
                    document.getElementById('deleteFileForm').action = `/files/${fileId}`;

                    // Set file name in confirmation message
                    document.getElementById('delete-file-name').textContent = fileName;
                });
            });
        });
    </script>
@endpush
