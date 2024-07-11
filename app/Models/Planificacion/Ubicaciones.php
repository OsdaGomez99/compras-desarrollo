<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicaciones extends Model
{
    use HasFactory;
    protected $table = 'planificacion.ubicacion';

    protected $fillable = [
        'codigo', 'descripcion', 'sede', 'estatus'
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('codigo', 'ilike',"%$search%")->orWhere('descripcion', 'ilike', "%$search%")->orWhere('sede', 'ilike', "%$search%")->orWhere('estatus', 'ilike', "%$search%");
    }
}
