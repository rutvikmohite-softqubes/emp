@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Leave Assignments</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Leave Assignment Form -->
                    <form action="{{ route('admin.leave-assignments.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="user_id" class="form-label">Select User</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="">Choose a user...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" class="form-control" id="year" name="year" value="{{ date('Y') }}" min="2020" max="2030" required>
                            </div>
                        </div>

                        <div class="row">
                            @foreach($leaveTypes as $leaveType)
                                <div class="col-md-6 mb-3">
                                    <label for="leave_{{ $leaveType->id }}" class="form-label">
                                        {{ $leaveType->name }}
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="leave_{{ $leaveType->id }}"
                                           name="leave_assignments[{{ $leaveType->id }}][days_allocated]" 
                                           min="0" 
                                           max="365" 
                                           placeholder="Enter days">
                                    <input type="hidden" name="leave_assignments[{{ $leaveType->id }}][leave_type_id]" value="{{ $leaveType->id }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit Leave Assignment</button>
                            </div>
                        </div>
                    </form>

                    @if($leaveAssignments->count() > 0)
                    <hr>
                    
                    <!-- Existing Assignments -->
                    <h5 class="mb-3">Existing Leave Assignments</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Leave Type</th>
                                    <th>Days Allocated</th>
                                    <th>Days Used</th>
                                    <th>Remaining</th>
                                    <th>Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveAssignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->user->name }}</td>
                                        <td>{{ $assignment->leaveType->name }}</td>
                                        <td>{{ $assignment->days_allocated }}</td>
                                        <td>{{ $assignment->days_used }}</td>
                                        <td>{{ $assignment->days_allocated - $assignment->days_used }}</td>
                                        <td>{{ $assignment->year }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning edit-assignment" 
                                                    data-id="{{ $assignment->id }}"
                                                    data-days-allocated="{{ $assignment->days_allocated }}"
                                                    data-days-used="{{ $assignment->days_used }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.leave-assignments.destroy', $assignment->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Assignment Modal -->
<div class="modal fade" id="editAssignmentModal" tabindex="-1" aria-labelledby="editAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAssignmentModalLabel">Edit Leave Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAssignmentForm" action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_assignment_id" name="assignment_id">
                    
                    <div class="mb-3">
                        <label for="edit_days_allocated" class="form-label">Days Allocated</label>
                        <input type="number" class="form-control" id="edit_days_allocated" name="days_allocated" min="0" max="365" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_days_used" class="form-label">Days Used</label>
                        <input type="number" class="form-control" id="edit_days_used" name="days_used" min="0" max="365" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit assignment button clicks
    const editButtons = document.querySelectorAll('.edit-assignment');
    const editModal = new bootstrap.Modal(document.getElementById('editAssignmentModal'));
    const editForm = document.getElementById('editAssignmentForm');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const daysAllocated = this.dataset.daysAllocated;
            const daysUsed = this.dataset.daysUsed;
            
            document.getElementById('edit_assignment_id').value = id;
            document.getElementById('edit_days_allocated').value = daysAllocated;
            document.getElementById('edit_days_used').value = daysUsed;
            
            editForm.action = `/admin/leave-assignments/${id}`;
            editModal.show();
        });
    });
});
</script>
@endpush
