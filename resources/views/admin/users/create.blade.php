@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Include Reusable Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Create New User</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>

            <!-- Create User Form -->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-user-plus"></i> Create New User
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.users.store') }}">
                                @csrf

                                <!-- Basic Information Section -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-user"></i> Basic Information
                                        </h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" 
                                                   placeholder="Enter user name" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" 
                                                   placeholder="Enter user email" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password *</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" 
                                                   placeholder="Enter password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Role *</label>
                                            <select class="form-select @error('role_id') is-invalid @enderror" 
                                                    id="role_id" name="role_id" required>
                                                <option value="">Select a role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information Section -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-info mb-3">
                                            <i class="fas fa-info-circle"></i> Additional Information
                                        </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="mobile_number" class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" 
                                                   id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}" 
                                                   placeholder="Enter mobile number">
                                            @error('mobile_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select @error('gender') is-invalid @enderror" 
                                                    id="gender" name="gender">
                                                <option value="">Select gender</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="blood_group" class="form-label">Blood Group</label>
                                            <select class="form-select @error('blood_group') is-invalid @enderror" 
                                                    id="blood_group" name="blood_group">
                                                <option value="">Select blood group</option>
                                                <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                            </select>
                                            @error('blood_group')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Parent Information Section -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-warning mb-3">
                                            <i class="fas fa-users"></i> Parent/Guardian Information
                                        </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="parent_name" class="form-label">Parent Name</label>
                                            <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                                   id="parent_name" name="parent_name" value="{{ old('parent_name') }}" 
                                                   placeholder="Enter parent name">
                                            @error('parent_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="relation" class="form-label">Relation</label>
                                            <select class="form-select @error('relation') is-invalid @enderror" 
                                                    id="relation" name="relation">
                                                <option value="">Select relation</option>
                                                <option value="father" {{ old('relation') == 'father' ? 'selected' : '' }}>Father</option>
                                                <option value="mother" {{ old('relation') == 'mother' ? 'selected' : '' }}>Mother</option>
                                                <option value="brother" {{ old('relation') == 'brother' ? 'selected' : '' }}>Brother</option>
                                                <option value="sister" {{ old('relation') == 'sister' ? 'selected' : '' }}>Sister</option>
                                                <option value="uncle" {{ old('relation') == 'uncle' ? 'selected' : '' }}>Uncle</option>
                                                <option value="aunt" {{ old('relation') == 'aunt' ? 'selected' : '' }}>Aunt</option>
                                            </select>
                                            @error('relation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="parent_mobile_number" class="form-label">Parent Mobile</label>
                                            <input type="text" class="form-control @error('parent_mobile_number') is-invalid @enderror" 
                                                   id="parent_mobile_number" name="parent_mobile_number" value="{{ old('parent_mobile_number') }}" 
                                                   placeholder="Enter parent mobile">
                                            @error('parent_mobile_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Permanent Address Section -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-success mb-3">
                                            <i class="fas fa-home"></i> Permanent Address
                                        </h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="permanent_address1" class="form-label">Address Line 1</label>
                                            <textarea class="form-control @error('permanent_address1') is-invalid @enderror" 
                                                      id="permanent_address1" name="permanent_address1" rows="2" 
                                                      placeholder="Enter address line 1">{{ old('permanent_address1') }}</textarea>
                                            @error('permanent_address1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="permanent_address2" class="form-label">Address Line 2</label>
                                            <textarea class="form-control @error('permanent_address2') is-invalid @enderror" 
                                                      id="permanent_address2" name="permanent_address2" rows="2" 
                                                      placeholder="Enter address line 2">{{ old('permanent_address2') }}</textarea>
                                            @error('permanent_address2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="permanent_state_id" class="form-label">State</label>
                                            <select class="form-select @error('permanent_state_id') is-invalid @enderror" 
                                                    id="permanent_state_id" name="permanent_state_id">
                                                <option value="">Select state</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('permanent_state_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="permanent_city_id" class="form-label">City</label>
                                            <select class="form-select @error('permanent_city_id') is-invalid @enderror" 
                                                    id="permanent_city_id" name="permanent_city_id">
                                                <option value="">Select city</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('permanent_city_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="permanent_pincode" class="form-label">Pincode</label>
                                            <input type="text" class="form-control @error('permanent_pincode') is-invalid @enderror" 
                                                   id="permanent_pincode" name="permanent_pincode" value="{{ old('permanent_pincode') }}" 
                                                   placeholder="Enter pincode">
                                            @error('permanent_pincode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Address Section -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-secondary mb-3">
                                            <i class="fas fa-map-marker-alt"></i> Current Address
                                        </h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="current_address1" class="form-label">Address Line 1</label>
                                            <textarea class="form-control @error('current_address1') is-invalid @enderror" 
                                                      id="current_address1" name="current_address1" rows="2" 
                                                      placeholder="Enter address line 1">{{ old('current_address1') }}</textarea>
                                            @error('current_address1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="current_address2" class="form-label">Address Line 2</label>
                                            <textarea class="form-control @error('current_address2') is-invalid @enderror" 
                                                      id="current_address2" name="current_address2" rows="2" 
                                                      placeholder="Enter address line 2">{{ old('current_address2') }}</textarea>
                                            @error('current_address2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="current_state_id" class="form-label">State</label>
                                            <select class="form-select @error('current_state_id') is-invalid @enderror" 
                                                    id="current_state_id" name="current_state_id">
                                                <option value="">Select state</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('current_state_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="current_city_id" class="form-label">City</label>
                                            <select class="form-select @error('current_city_id') is-invalid @enderror" 
                                                    id="current_city_id" name="current_city_id">
                                                <option value="">Select city</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('current_city_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="current_pincode" class="form-label">Pincode</label>
                                            <input type="text" class="form-control @error('current_pincode') is-invalid @enderror" 
                                                   id="current_pincode" name="current_pincode" value="{{ old('current_pincode') }}" 
                                                   placeholder="Enter pincode">
                                            @error('current_pincode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create User
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
                                <i class="fas fa-info-circle"></i> User Management Guide
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Best Practices:</h6>
                                    <ul>
                                        <li>Use strong, unique passwords</li>
                                        <li>Assign appropriate roles</li>
                                        <li>Keep email addresses professional</li>
                                        <li>Regular review user access</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Common Roles:</h6>
                                    <ul>
                                        <li><strong>Super Admin:</strong> Full system access</li>
                                        <li><strong>HR:</strong> User management</li>
                                        <li><strong>Manager:</strong> Team management</li>
                                        <li><strong>Employee:</strong> Basic access</li>
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
