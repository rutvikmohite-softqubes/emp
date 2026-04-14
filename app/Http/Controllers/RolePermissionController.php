<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function create($roleId)
    {
        $role = $this->roleRepository->find($roleId);
        
        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found.');
        }

        return view('admin.roles.show', compact('role'));
    }
}
