<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            $role->slug = Str::slug($role->name);
        });

        static::updating(function ($role) {
            if ($role->isDirty('name')) {
                $role->slug = Str::slug($role->name);
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function givePermission(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function hasPermission(Permission $permission)
    {
        return $this->permissions->contains($permission);
    }

    public function syncPermissions(array $permissions)
    {
        return $this->permissions()->sync($permissions);
    }
}
