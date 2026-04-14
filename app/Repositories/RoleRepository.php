<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    protected $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function all(): Collection
    {
        return $this->model->orderBy('name')->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->orderBy('name')->paginate($perPage);
    }

    public function find(int $id): ?Role
    {
        return $this->model->find($id);
    }

    public function create(array $data): Role
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $role = $this->find($id);
        
        if (!$role) {
            return false;
        }

        return $role->update($data);
    }

    public function delete(int $id): bool
    {
        $role = $this->find($id);
        
        if (!$role) {
            return false;
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            throw new \Exception('Cannot delete role with assigned users');
        }

        return $role->delete();
    }

    public function findByName(string $name): ?Role
    {
        return $this->model->where('name', $name)->first();
    }

    public function search(string $term): Collection
    {
        return $this->model->where('name', 'LIKE', "%{$term}%")
                           ->orderBy('name')
                           ->get();
    }
}
