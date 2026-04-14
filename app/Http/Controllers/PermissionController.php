<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            $permissions = $this->permissionRepository->search($search);
        } else {
            $permissions = $this->permissionRepository->paginate(10);
        }

        return view('admin.permissions.index', compact('permissions', 'search'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $this->permissionRepository->create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating permission: ' . $e->getMessage());
        }
    }

    public function show(int $id)
    {
        $permission = $this->permissionRepository->find($id);
        
        if (!$permission) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Permission not found.');
        }

        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(int $id)
    {
        $permission = $this->permissionRepository->find($id);
        
        if (!$permission) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Permission not found.');
        }

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, int $id)
    {
        $permission = $this->permissionRepository->find($id);
        
        if (!$permission) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Permission not found.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($permission->id),
            ],
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $this->permissionRepository->update($id, [
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating permission: ' . $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        $permission = $this->permissionRepository->find($id);
        
        if (!$permission) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Permission not found.');
        }

        try {
            $this->permissionRepository->delete($id);

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting permission: ' . $e->getMessage());
        }
    }
}
