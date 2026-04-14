<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;
    
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    
    public function find(int $id): ?Role;
    
    public function create(array $data): Role;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
    
    public function findByName(string $name): ?Role;
    
    public function search(string $term): \Illuminate\Database\Eloquent\Collection;
}
