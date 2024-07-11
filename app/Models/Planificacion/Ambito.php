<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambito extends Model
{
    use HasFactory;
    protected $table = 'planificacion.ambito_proyecto';

    protected $fillable = [
        'codigo', 'resumen', 'descripcion', 'estatus'
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('codigo', 'ilike',"%$search%")->orWhere('resumen', 'ilike', "%$search%")->orWhere('descripcion', 'ilike', "%$search%")->orWhere('estatus', 'ilike', "%$search%");
    }
}
