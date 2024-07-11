<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{

    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use SoftDeletes;

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    public $guarded = [];

    protected $dates = ['deleted_at'];

    public function user_roles()
    {
        return $this->hasManyDeep(User::class, ['segurity.permission_role', Role::class, 'segurity.role_user']);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE',"%$search%")->orWhere('display_name', 'LIKE', "%$search%")->orWhere('description', 'LIKE', "%$search%");
    }

}
