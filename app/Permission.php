<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $fillable = [
        'name',
        'slug',
        'body',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
