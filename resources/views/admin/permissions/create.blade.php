@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Include Reusable Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Create New Permission</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Permissions
                    </a>
                </div>
            </div>

            <!-- Create Permission Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-key"></i> Permission Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.permissions.store') }}">
                                @csrf

                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="Enter permission name" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Use a descriptive name (e.g., "create-user", "edit-post", "delete-comment").
                                    </div>
                                </div>

                                <!-- Description Field -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3" 
                                              placeholder="Enter permission description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Brief description of what this permission allows.
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Permission
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
                                <i class="fas fa-info-circle"></i> Permission Management Guide
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Best Practices:</h6>
                                    <ul>
                                        <li>Use clear, action-oriented names</li>
                                        <li>Be specific about what the permission allows</li>
                                        <li>Use consistent naming conventions</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Common Permission Types:</h6>
                                    <ul>
                                        <li><strong>Users:</strong> create-user, edit-user, delete-user</li>
                                        <li><strong>Content:</strong> create-post, edit-post, delete-post</li>
                                        <li><strong>Settings:</strong> manage-settings, view-logs</li>
                                        <li><strong>Reports:</strong> view-reports, export-data</li>
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
