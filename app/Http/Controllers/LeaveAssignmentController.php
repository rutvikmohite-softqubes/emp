<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveType;
use App\Models\LeaveAssignment;
use Illuminate\Http\Request;

class LeaveAssignmentController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $users = User::with('role')->get();
        $leaveAssignments = LeaveAssignment::with(['user', 'leaveType'])->get();
        
        return view('admin.leave-assignments.index', compact('leaveTypes', 'users', 'leaveAssignments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2020|max:2030',
            'leave_assignments' => 'required|array',
            'leave_assignments.*.days_allocated' => 'nullable|integer|min:0|max:365',
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $year = $request->year;
            $assignmentsCreated = 0;

            foreach ($request->leave_assignments as $leaveTypeId => $assignmentData) {
                if (isset($assignmentData['days_allocated']) && $assignmentData['days_allocated'] > 0) {
                    LeaveAssignment::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'leave_type_id' => $leaveTypeId,
                            'year' => $year,
                        ],
                        [
                            'days_allocated' => $assignmentData['days_allocated'],
                            'days_used' => 0,
                        ]
                    );
                    $assignmentsCreated++;
                }
            }

            if ($assignmentsCreated > 0) {
                return redirect()->route('admin.leave-assignments.index')
                    ->with('success', "Successfully created {$assignmentsCreated} leave assignments for {$user->name}.");
            } else {
                return redirect()->route('admin.leave-assignments.index')
                    ->with('error', 'No leave assignments were created. Please specify at least one leave type with days allocated.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.leave-assignments.index')
                ->with('error', 'Error creating leave assignments: ' . $e->getMessage());
        }
    }

    public function update(Request $request, LeaveAssignment $leaveAssignment)
    {
        $request->validate([
            'days_allocated' => 'required|integer|min:0|max:365',
            'days_used' => 'required|integer|min:0|max:365',
        ]);

        try {
            $leaveAssignment->update([
                'days_allocated' => $request->days_allocated,
                'days_used' => $request->days_used,
            ]);

            return redirect()->route('admin.leave-assignments.index')
                ->with('success', 'Leave assignment updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.leave-assignments.index')
                ->with('error', 'Error updating leave assignment: ' . $e->getMessage());
        }
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.id' => 'required|exists:leave_assignments,id',
            'assignments.*.days_allocated' => 'required|integer|min:0|max:365',
            'assignments.*.days_used' => 'required|integer|min:0|max:365',
        ]);

        try {
            $updatedCount = 0;
            
            foreach ($request->assignments as $assignmentData) {
                $assignment = LeaveAssignment::findOrFail($assignmentData['id']);
                $assignment->update([
                    'days_allocated' => $assignmentData['days_allocated'],
                    'days_used' => $assignmentData['days_used'],
                ]);
                $updatedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} assignments."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating assignments: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(LeaveAssignment $leaveAssignment)
    {
        try {
            $leaveAssignment->delete();

            return redirect()->route('admin.leave-assignments.index')
                ->with('success', 'Leave assignment deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.leave-assignments.index')
                ->with('error', 'Error deleting leave assignment: ' . $e->getMessage());
        }
    }

    public function getUserAssignments($user)
    {
        $userData = User::findOrFail($user);
        $leaveAssignments = LeaveAssignment::with('leaveType')
            ->where('user_id', $user)
            ->get();
        
        return response()->json([
            'success' => true,
            'user' => $userData,
            'assignments' => $leaveAssignments
        ]);
    }
}
