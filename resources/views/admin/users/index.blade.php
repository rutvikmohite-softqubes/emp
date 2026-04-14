@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Include Reusable Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Users</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create User
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
                </div>
                <div class="card-body">
                    <form id="filter-form" class="row g-3">
                        <div class="col-md-3">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="role_filter" class="form-label">Role</label>
                            <select class="form-select" id="role_filter" name="role_filter">
                                <option value="">All Roles</option>
                                @foreach($roles ?? \App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ request('role_filter') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" id="clear-filters" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times"></i> Clear
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover" id="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.users.index") }}',
            data: function(d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
                d.role_filter = $('#role_filter').val();
            }
        },
        columns: [
            { data: 'id', name: 'users.id' },
            { data: 'name', name: 'users.name' },
            { data: 'email', name: 'users.email' },
            { data: 'role', name: 'role.name', orderable: false, searchable: false },
            { data: 'created_at', name: 'users.created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'asc']]
    });

    // Filter form submission
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // Clear filters
    $('#clear-filters').on('click', function() {
        $('#from_date').val('');
        $('#to_date').val('');
        $('#role_filter').val('');
        table.ajax.reload();
    });

    // Auto-filter on change
    $('#from_date, #to_date, #role_filter').on('change', function() {
        table.ajax.reload();
    });

    // Delete user with SweetAlert
    $(document).on('click', '.delete-user', function(e) {
        e.preventDefault();
        
        var form = $(this).closest('form');
        var userId = $(this).data('user-id');
        var userName = $(this).data('user-name');
        
        Swal.fire({
            title: 'Are you sure?',
            html: 'You are about to delete <strong>' + userName + '</strong>.<br>This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return $.ajax({
                    url: form.attr('action'),
                    type: 'DELETE',
                    data: form.serialize(),
                    dataType: 'json'
                });
            }
        }).then(function(result) {
            if (result.value) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'User has been deleted successfully.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Reload table
                table.ajax.reload();
            }
        }).catch(function(error) {
            if (error.statusText !== 'cancel') {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error deleting user.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // View user leave assignments
    $(document).on('click', '.view-leave-assignments', function() {
        var userId = $(this).data('user-id');
        var userName = $(this).data('user-name');
        
        // Fetch user leave assignments
        $.ajax({
            url: '/admin/leave-assignments/user/' + userId,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var assignmentsHtml = '';
                    
                    if (response.assignments.length > 0) {
                        assignmentsHtml = '<h6><strong>Leave Assignments:</strong></h6>';
                        assignmentsHtml += '<div class="table-responsive mt-3">';
                        assignmentsHtml += '<table class="table table-sm table-striped">';
                        assignmentsHtml += '<thead><tr><th>Leave Type</th><th>Allocated Days</th><th>Used Days</th></tr></thead>';
                        assignmentsHtml += '<tbody>';
                        
                        response.assignments.forEach(function(assignment) {
                            assignmentsHtml += '<tr>';
                            assignmentsHtml += '<td><span class="badge bg-info">' + assignment.leave_type.name + '</span></td>';
                            assignmentsHtml += '<td><input type="number" id="allocated_' + assignment.id + '" class="form-control form-control-sm" value="' + assignment.days_allocated + '" min="0" max="365" style="width: 80px;"></td>';
                            assignmentsHtml += '<td><input type="number" id="used_' + assignment.id + '" class="form-control form-control-sm" value="' + assignment.days_used + '" min="0" max="365" style="width: 80px;"></td>';
                            assignmentsHtml += '</tr>';
                        });
                        
                        assignmentsHtml += '</tbody></table>';
                        assignmentsHtml += '</div>';
                        assignmentsHtml += '<div class="mt-3"><button type="button" onclick="updateAllAssignments()" class="btn btn-primary">Update All Assignments</button></div>';
                    } else {
                        assignmentsHtml = '<h6><strong>Assign Leave to ' + userName + ':</strong></h6>';
                        assignmentsHtml += '<form id="quickAssignForm" style="margin-top: 15px;">';
                        assignmentsHtml += '<input type="hidden" name="user_id" value="' + userId + '">';
                        assignmentsHtml += '<input type="hidden" name="year" value="' + new Date().getFullYear() + '">';
                        assignmentsHtml += '<div class="row">';
                        
                        // Add leave types with input boxes
                        var leaveTypes = [
                            'Sick Leave', 'Casual Leave', 'Annual Leave', 'Maternity Leave', 
                            'Paternity Leave', 'Emergency Leave', 'Study Leave', 'Unpaid Leave',
                            'Compensatory Off', 'Bereavement Leave'
                        ];
                        
                        leaveTypes.forEach(function(leaveType, index) {
                            assignmentsHtml += '<div class="col-6 mb-2">';
                            assignmentsHtml += '<label style="font-size: 12px; margin-bottom: 2px;">' + leaveType + '</label>';
                            assignmentsHtml += '<input type="number" name="leave_assignments[' + (index + 1) + '][days_allocated]" ';
                            assignmentsHtml += 'class="form-control form-control-sm" min="0" max="365" placeholder="0">';
                            assignmentsHtml += '<input type="hidden" name="leave_assignments[' + (index + 1) + '][leave_type_id]" value="' + (index + 1) + '">';
                            assignmentsHtml += '</div>';
                        });
                        
                        assignmentsHtml += '</div>';
                        assignmentsHtml += '<div class="mt-3">';
                        assignmentsHtml += '<button type="button" onclick="submitQuickAssign()" class="btn btn-primary btn-sm">Assign Leaves</button>';
                        assignmentsHtml += '</div>';
                        assignmentsHtml += '</form>';
                    }
                    
                    Swal.fire({
                        title: 'Leave Assignments - ' + userName,
                        html: assignmentsHtml,
                        width: '600px',
                        showConfirmButton: true,
                        confirmButtonText: 'Close',
                        showCancelButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load leave assignments.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while fetching leave assignments.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

// Function to handle quick leave assignment
function submitQuickAssign() {
    var formData = $('#quickAssignForm').serialize();
    
    $.ajax({
        url: '/admin/leave-assignments',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'Leave assignments created successfully!',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Refresh the assignments modal
                var userId = $('input[name="user_id"]').val();
                var userName = $('.swal2-title').text().replace('Leave Assignments - ', '');
                showUserAssignments(userId, userName);
            });
        },
        error: function(xhr) {
            var errorMessage = 'Error creating leave assignments.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

// Function to update all assignments at once
function updateAllAssignments() {
    var assignments = [];
    var userId = $('input[name="user_id"]').val();
    
    // Collect all assignment data from the form inputs
    $('input[id^="allocated_"]').each(function() {
        var assignmentId = $(this).attr('id').replace('allocated_', '');
        var allocatedDays = $(this).val();
        var usedDays = $('#used_' + assignmentId).val();
        
        assignments.push({
            id: assignmentId,
            days_allocated: allocatedDays,
            days_used: usedDays
        });
    });
    
    // Send bulk update request
    $.ajax({
        url: '/admin/leave-assignments/bulk-update',
        type: 'POST',
        data: {
            assignments: assignments,
            _method: 'PUT'
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'All assignments updated successfully!',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Refresh the assignments modal
                var userName = $('.swal2-title').text().replace('Leave Assignments - ', '');
                showUserAssignments(userId, userName);
            });
        },
        error: function(xhr) {
            var errorMessage = 'Error updating assignments.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

</script>
@endpush
@endsection
