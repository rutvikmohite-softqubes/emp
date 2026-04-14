<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('role')
                ->where('id', '!=', auth()->id())
                ->select(['users.id', 'users.name', 'users.email', 'users.role_id', 'users.created_at']);
            
            // Apply date range filter
            if ($request->from_date) {
                $users->whereDate('users.created_at', '>=', $request->from_date);
            }
            if ($request->to_date) {
                $users->whereDate('users.created_at', '<=', $request->to_date);
            }
            
            // Apply role filter
            if ($request->role_filter) {
                $users->where('users.role_id', $request->role_filter);
            }
            
            return DataTables::of($users)
                ->addColumn('role', function ($user) {
                    return $user->role ? 
                        '<span class="badge bg-primary">' . $user->role->name . '</span>' : 
                        '<span class="badge bg-secondary">No Role</span>';
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at->format('M d, Y');
                })
                ->addColumn('action', function ($user) {
                    $buttons = '<div class="btn-group" role="group">
                        <a href="' . route('admin.users.show', $user->id) . '" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-info view-leave-assignments" 
                                data-user-id="' . $user->id . '" 
                                data-user-name="' . e($user->name) . '">
                            <i class="fas fa-calendar-alt"></i>
                        </button>
                        <form method="POST" action="' . route('admin.users.destroy', $user->id) . '" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="btn btn-sm btn-outline-danger delete-user" 
                                    data-user-id="' . $user->id . '" 
                                    data-user-name="' . e($user->name) . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>';
                    return $buttons;
                })
                ->rawColumns(['role', 'action'])
                ->make(true);
        }
        
        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $states = \App\Models\State::where('is_active', true)->orderBy('name')->get();
        $cities = \App\Models\City::where('is_active', true)->orderBy('name')->get();
        return view('admin.users.create', compact('roles', 'states', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            // User Details validation (optional)
            'mobile_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'parent_name' => 'nullable|string|max:255',
            'relation' => 'nullable|in:father,mother,brother,sister,uncle,aunt',
            'parent_mobile_number' => 'nullable|string|max:20',
            'permanent_address1' => 'nullable|string',
            'permanent_address2' => 'nullable|string',
            'permanent_city_id' => 'nullable|integer|exists:cities,id',
            'permanent_state_id' => 'nullable|integer|exists:states,id',
            'permanent_pincode' => 'nullable|string|max:10',
            'current_address1' => 'nullable|string',
            'current_address2' => 'nullable|string',
            'current_city_id' => 'nullable|integer|exists:cities,id',
            'current_state_id' => 'nullable|integer|exists:states,id',
            'current_pincode' => 'nullable|string|max:10',
        ]);

        try {
            // Store the plain password before hashing
            $plainPassword = $request->password;
            
            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            // Fire the UserRegistered event
            event(new UserRegistered($user, $plainPassword));

            // Create User Details if any detail field is provided
            \Log::info('User Details Request Data:', [
                'permanent_city_id' => $request->permanent_city_id,
                'permanent_state_id' => $request->permanent_state_id,
                'current_city_id' => $request->current_city_id,
                'current_state_id' => $request->current_state_id,
                'all_request_data' => $request->all()
            ]);
            
            if ($request->hasAny([
                'mobile_number', 'gender', 'blood_group', 'parent_name', 'relation',
                'parent_mobile_number', 'permanent_address1', 'permanent_address2',
                'permanent_city_id', 'permanent_state_id', 'permanent_pincode',
                'current_address1', 'current_address2', 'current_city_id',
                'current_state_id', 'current_pincode'
            ])) {
                $userDetailData = [
                    'mobile_number' => $request->mobile_number,
                    'email' => $request->email, // Optional separate email
                    'gender' => $request->gender,
                    'blood_group' => $request->blood_group,
                    'parent_name' => $request->parent_name,
                    'relation' => $request->relation,
                    'parent_mobile_number' => $request->parent_mobile_number,
                    'permanent_address1' => $request->permanent_address1,
                    'permanent_address2' => $request->permanent_address2,
                    'permanent_city_id' => $request->permanent_city_id,
                    'permanent_state_id' => $request->permanent_state_id,
                    'permanent_pincode' => $request->permanent_pincode,
                    'current_address1' => $request->current_address1,
                    'current_address2' => $request->current_address2,
                    'current_city_id' => $request->current_city_id,
                    'current_state_id' => $request->current_state_id,
                    'current_pincode' => $request->current_pincode,
                ];
                
                \Log::info('Creating User Details with data:', $userDetailData);
                
                $user->userDetail()->create($userDetailData);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully. Welcome email sent to ' . $user->email);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('userDetail')->findOrFail($id);
        $roles = Role::all();
        $states = \App\Models\State::where('is_active', true)->orderBy('name')->get();
        $cities = \App\Models\City::where('is_active', true)->orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles', 'states', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            // User Details validation (optional)
            'mobile_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'parent_name' => 'nullable|string|max:255',
            'relation' => 'nullable|in:father,mother,brother,sister,uncle,aunt',
            'parent_mobile_number' => 'nullable|string|max:20',
            'permanent_address1' => 'nullable|string',
            'permanent_address2' => 'nullable|string',
            'permanent_city_id' => 'nullable|integer|exists:cities,id',
            'permanent_state_id' => 'nullable|integer|exists:states,id',
            'permanent_pincode' => 'nullable|string|max:10',
            'current_address1' => 'nullable|string',
            'current_address2' => 'nullable|string',
            'current_city_id' => 'nullable|integer|exists:cities,id',
            'current_state_id' => 'nullable|integer|exists:states,id',
            'current_pincode' => 'nullable|string|max:10',
        ]);

        try {
            $user = User::findOrFail($id);
            
            // Update User
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            // Update or Create User Details
            $detailData = [
                'mobile_number' => $request->mobile_number,
                'email' => $request->email, // Optional separate email
                'gender' => $request->gender,
                'blood_group' => $request->blood_group,
                'parent_name' => $request->parent_name,
                'relation' => $request->relation,
                'parent_mobile_number' => $request->parent_mobile_number,
                'permanent_address1' => $request->permanent_address1,
                'permanent_address2' => $request->permanent_address2,
                'permanent_city_id' => $request->permanent_city_id,
                'permanent_state_id' => $request->permanent_state_id,
                'permanent_pincode' => $request->permanent_pincode,
                'current_address1' => $request->current_address1,
                'current_address2' => $request->current_address2,
                'current_city_id' => $request->current_city_id,
                'current_state_id' => $request->current_state_id,
                'current_pincode' => $request->current_pincode,
            ];

            if ($user->userDetail) {
                $user->userDetail->update($detailData);
            } else {
                $user->userDetail()->create($detailData);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully.'
                ]);
            }
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting user: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
