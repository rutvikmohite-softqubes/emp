<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function all(): Collection
    {
        return $this->model->orderBy('name')->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->orderBy('name')->paginate($perPage);
    }

    public function find(int $id): ?Permission
    {
        return $this->model->find($id);
    }

    public function create(array $data): Permission
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $permission = $this->find($id);
        
        if (!$permission) {
            return false;
        }

        return $permission->update($data);
    }

    public function delete(int $id): bool
    {
        $permission = $this->find($id);
        
        if (!$permission) {
            return false;
        }

        return $permission->delete();
    }

    public function findByName(string $name): ?Permission
    {
        return $this->model->where('name', $name)->first();
    }

    public function search(string $term): Collection
    {
        return $this->model->where('name', 'LIKE', "%{$term}%")
                           ->orWhere('description', 'LIKE', "%{$term}%")
                           ->orderBy('name')
                           ->get();
    }

}
