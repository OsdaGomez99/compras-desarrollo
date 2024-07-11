<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planes extends Model
{
    use HasFactory;
    protected $table = 'planificacion.plan';

    protected $fillable = [
        'id','anno', 'version', 'descripcion', 'estatus'
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('anno', 'ilike',"%$search%")->orWhere('version', 'ilike', "%$search%")->orWhere('descripcion', 'ilike', "%$search%")->orWhere('estatus', 'ilike', "%$search%");
    }

}
