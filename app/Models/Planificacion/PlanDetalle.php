<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDetalle extends Model
{
    use HasFactory;
    protected $table = 'planificacion.planes_detalles';

    protected $fillable = [
        'id', 'id_plan', 'id_proyecto_accion_detalle', 'id_ambito','id_unidad_ejecutora', 'codificacion'

    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('id_centros_costo', 'ilike',"%$search%")->orWhere('id_plan', 'ilike', "%$search%")->orWhere('descripcion', 'ilike', "%$search%");
    }
    public function CentroCosto(){
        return $this->belongsTo(CentroCosto::class,'id_centros_costo','id');
    }
    public function Plan(){
        return $this->belongsTo(Planes::class,'id_plan','id');
    }
}
