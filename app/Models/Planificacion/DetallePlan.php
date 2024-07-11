<?php

namespace App\Models\planificacion;

use App\Models\Planificacion\CentroCosto;
use App\Models\Planificacion\Planes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePlan extends Model
{
    use HasFactory;
    protected $table = 'planificacion.detalles_plan';

    protected $fillable = [
        'id','id_plan', 'id_centros_costo','monto', 'descripcion', 'estatus'
    ];
    // public function scopeSearch($query, $search)
    // {
    //     return $query->where('anno', 'ilike',"%$search%")->orWhere('version', 'ilike', "%$search%")->orWhere('descripcion', 'ilike', "%$search%")->orWhere('estatus', 'ilike', "%$search%");
    // }

    public function centrosCostos(){
        return $this->hasMany(CentroCosto::class,'id_centros_costo','id');
    }
    public function plan(){
        return $this->belongsTo(Planes::class,'id_plan','id');
    }
}
