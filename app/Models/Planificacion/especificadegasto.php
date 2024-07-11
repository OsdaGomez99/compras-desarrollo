<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class especificadegasto extends Model
{
    use HasFactory;
    protected $table = 'planificacion.especificas_gastos';

    protected $fillable = [
        'cod_ocepre', 'descripcion', 'descripcion_corta',
        'nivel', 'movim', 'mostrar',
        'tipo_gasto', 'cod_ls', 'formula',
        'accion_central', 'bloqueo_opsu', 'estatus'

    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('cod_ocepre', 'ilike',"%$search%")->orWhere('descripcion', 'ilike', "%$search%")->orWhere('descripcion_corta', 'ilike', "%$search%")->orWhere('accion_central', 'ilike', "%$search%");
    }
}

