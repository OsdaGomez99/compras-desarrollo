<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends LaratrustRole
{
    use SoftDeletes;

    protected $table = 'segurity.roles';

    public $guarded = [];

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE',"%$search%")->orWhere('display_name', 'LIKE', "%$search%")->orWhere('description', 'LIKE', "%$search%");
    }

}
