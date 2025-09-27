<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'permission_group');
    }
}
