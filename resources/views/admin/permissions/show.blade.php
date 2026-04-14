@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Include Reusable Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Permission Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Back to Permissions
                    </a>
                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Permission
                    </a>
                </div>
            </div>

            <!-- Permission Details Card -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-key"></i> Permission Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $permission->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td><span class="badge bg-primary">{{ $permission->name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $permission->description ?? 'No description provided' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $permission->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $permission->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-pie"></i> Permission Statistics
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h3 class="text-primary">{{ $permission->id }}</h3>
                                        <p class="text-muted mb-0">Permission ID</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3 class="text-success">{{ \App\Models\Permission::count() }}</h3>
                                    <p class="text-muted mb-0">Total Permissions</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-cog"></i> Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Permission
                                </a>
                                <form method="POST" action="{{ route('admin.permissions.destroy', $permission->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this permission?')">
                                        <i class="fas fa-trash"></i> Delete Permission
                                    </button>
                                </form>
                                    </a>
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
@endsection
