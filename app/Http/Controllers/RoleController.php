<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            $roles = $this->roleRepository->search($search);
        } else {
            $roles = $this->roleRepository->paginate(10);
        }

        return view('admin.roles.index', compact('roles', 'search'));
    }

    public function create()
    {
        $permissions = $this->permissionRepository->all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = $this->roleRepository->create([
                'name' => $request->name,
                'slug' => $request->slug,
            ]);

            // Sync permissions if provided
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating role: ' . $e->getMessage());
        }
    }

    public function show(int $id)
    {
        $role = $this->roleRepository->find($id);
        
        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found.');
        }

        return view('admin.roles.show', compact('role'));
    }

    public function edit(int $id)
    {
        $role = $this->roleRepository->find($id);
        
        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found.');
        }

        $permissions = $this->permissionRepository->all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, int $id)
    {
        $role = $this->roleRepository->find($id);
        
        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'slug')->ignore($role->id),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $this->roleRepository->update($id, [
                'name' => $request->name,
                'slug' => $request->slug,
            ]);

            // Sync permissions
            $role->syncPermissions($request->permissions ?? []);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating role: ' . $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        $role = $this->roleRepository->find($id);
        
        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found.');
        }

        try {
            $this->roleRepository->delete($id);

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }
}
