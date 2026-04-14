@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Include Reusable Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Role Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Back to Roles
                    </a>
                    @if ($role->name !== 'Super Admin')
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit Role
                        </a>
                    @endif
                </div>
            </div>

            <!-- Role Details Card -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-shield-alt"></i> Role Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Role ID:</th>
                                    <td>#{{ $role->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td><span class="badge bg-primary">{{ $role->name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $role->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $role->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Users Count:</th>
                                    <td><span class="badge bg-info">{{ $role->users()->count() }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-pie"></i> Role Statistics
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h3 class="text-primary">{{ $role->users()->count() }}</h3>
                                        <p class="text-muted mb-0">Total Users</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3 class="text-success">{{ \App\Models\Role::count() }}</h3>
                                    <p class="text-muted mb-0">Total Roles</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="progress" style="height: 20px;">
                                    <?php
                                    $totalUsers = \App\Models\User::count();
                                    $roleUsers = $role->users()->count();
                                    $percentage = $totalUsers > 0 ? ($roleUsers / $totalUsers) * 100 : 0;
                                    ?>
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($percentage, 1) }}% of all users
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users with this Role -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-users"></i> Users with this Role ({{ $role->users()->count() }})
                            </h6>
                            <span class="badge bg-info">{{ $role->users()->count() }} users</span>
                        </div>
                        <div class="card-body">
                            @if ($role->users()->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($role->users()->paginate(10) as $user)
                                                <tr>
                                                    <td>#{{ $user->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                <span class="text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                            </div>
                                                            {{ $user->name }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-sm btn-outline-primary" disabled>
                                                                <i class="fas fa-eye"></i> View
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-warning" disabled>
                                                                <i class="fas fa-edit"></i> Edit
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $role->users()->paginate(10)->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No users assigned</h5>
                                    <p class="text-muted">This role has no users assigned to it yet.</p>
                                </div>
                            @endif
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
                                <i class="fas fa-tools"></i> Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary btn-block">
                                        <i class="fas fa-list"></i> All Roles
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('admin.roles.create') }}" class="btn btn-outline-success btn-block">
                                        <i class="fas fa-plus"></i> New Role
                                    </a>
                                </div>
                                @if ($role->name !== 'Super Admin')
                                    <div class="col-md-3 mb-2">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-outline-warning btn-block">
                                            <i class="fas fa-edit"></i> Edit Role
                                        </a>
                                    </div>
                                @endif
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-block">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
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

.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
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
