@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Include Reusable Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Create New Role</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Roles
                    </a>
                </div>
            </div>

            <!-- Create Role Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-shield-alt"></i> Role Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.roles.store') }}">
                                @csrf

                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="Enter role name" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Choose a descriptive name for this role (e.g., "Editor", "Manager", "Viewer").
                                    </div>
                                </div>

                                <!-- Slug Field -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug') }}" 
                                           placeholder="Enter role slug" required>
                                    @error('slug')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        URL-friendly version of the role name (e.g., "editor", "manager", "viewer").
                                    </div>
                                </div>

                                <!-- Permissions Field -->
                                <div class="mb-3">
                                    <label for="permissions" class="form-label">Permissions</label>
                                    <select class="form-select @error('permissions') is-invalid @enderror" 
                                            id="permissions" name="permissions[]" multiple="multiple">
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }} - {{ $permission->description ?? 'No description' }}</option>
                                        @endforeach
                                    </select>
                                    @error('permissions')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Select permissions for this role. You can choose multiple permissions.
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Role
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle"></i> Role Management Guide
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Best Practices:</h6>
                                    <ul>
                                        <li>Use clear, descriptive role names</li>
                                        <li>Assign only necessary permissions</li>
                                        <li>Follow principle of least privilege</li>
                                        <li>Regularly review role assignments</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Common Role Types:</h6>
                                    <ul>
                                        <li><strong>Admin:</strong> All permissions</li>
                                        <li><strong>Editor:</strong> Create, edit content</li>
                                        <li><strong>Viewer:</strong> Read-only access</li>
                                        <li><strong>Moderator:</strong> Manage user content</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
    padding: 0.75rem 1rem;
    border-radius: 0.25rem;
    margin: 0.125rem 0;
}

.sidebar .nav-link:hover {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
}

.sidebar .nav-link.active {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
}

.sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
}

@media (max-width: 767.98px) {
    .sidebar {
        position: static;
        height: auto;
        padding: 0;
    }
    
    .sidebar-sticky {
        height: auto;
    }
}
</style>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#permissions').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select permissions...',
        allowClear: true
    });

    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
        slugInput.value = slug;
    });
});
</script>
@endsection
