<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'permissions'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array'
    ];

    /**
     * Return users belongs to this role
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    /**
     * Check if this role has given permissions
     */
    public function hasAccess(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission(string $permission) : bool
    {
        return $this->permissions[$permission] ?? false;
    }
}
