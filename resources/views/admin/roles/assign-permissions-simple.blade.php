@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Include Reusable Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Assign Permissions to Role</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Role
                    </a>
                </div>
            </div>

            <!-- Role Info -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-1">
                                        <i class="fas fa-shield-alt"></i> 
                                        Role: <span class="badge bg-primary">{{ $role->name }}</span>
                                    </h5>
                                    <p class="text-muted mb-0">
                                        Users in this role: {{ $role->users()->count() }} | 
                                        Currently assigned permissions: {{ count($rolePermissions) }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i> View Role
                                        </a>
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit Role
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Permission Assignment Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-key"></i> Select Permissions
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.permissions.store', $role->id) }}">
                        @csrf

                        <!-- Quick Actions -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPermissions()">
                                    <i class="fas fa-check-square"></i> Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPermissions()">
                                    <i class="fas fa-square"></i> Deselect All
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="badge bg-info" id="selectedCount">0</span> permissions selected
                            </div>
                        </div>

                        <!-- Permissions List -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-list"></i> Available Permissions ({{ $permissions->count() }})
                                        </h6>
                                    </div>
                                    <div class="card-body p-2">
                                        @foreach($permissions as $permission)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input permission-checkbox" 
                                                       type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}"
                                                       id="permission_{{ $permission->id }}"
                                                       {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    <strong>{{ $permission->name }}</strong>
                                                    @if($permission->description)
                                                        <br><small class="text-muted">{{ $permission->description }}</small>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Assign Permissions
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle"></i> Permission Assignment Guide
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Tips:</h6>
                                    <ul>
                                        <li>Select all permissions that this role should have</li>
                                        <li>Consider principle of least privilege</li>
                                        <li>Review assignments before saving</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Current Status:</h6>
                                    <ul>
                                        <li><strong>Role:</strong> {{ $role->name }}</li>
                                        <li><strong>Users:</strong> {{ $role->users()->count() }} assigned</li>
                                        <li><strong>Current Permissions:</strong> {{ count($rolePermissions) }}</li>
                                        <li><strong>Available Permissions:</strong> {{ $permissions->count() }}</li>
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

.form-check {
    padding-left: 0;
}

.form-check-input:checked + .form-check-label {
    background-color: rgba(0, 123, 255, 0.1);
    border-radius: 0.25rem;
    padding: 0.5rem;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedCount();
    
    // Update count when checkboxes change
    document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', updateSelectedCount);
    });
});

function updateSelectedCount() {
    const checkedBoxes = document.querySelectorAll('.permission-checkbox:checked');
    const count = checkedBoxes.length;
    document.getElementById('selectedCount').textContent = count;
}

function selectAllPermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
        checkbox.checked = true;
    });
    updateSelectedCount();
}

function deselectAllPermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
        checkbox.checked = false;
    });
    updateSelectedCount();
}
</script>
@endsection
