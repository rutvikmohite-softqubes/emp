<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;
    
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    
    public function find(int $id): ?Permission;
    
    public function create(array $data): Permission;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
    
    public function findByName(string $name): ?Permission;
    
    public function search(string $term): \Illuminate\Database\Eloquent\Collection;
}
