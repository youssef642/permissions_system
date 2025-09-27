<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_group');
    }
}
