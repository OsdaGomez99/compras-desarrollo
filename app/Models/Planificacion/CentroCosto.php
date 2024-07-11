<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Planificacion\UnidadEjecutora;
use App\Models\Planificacion\Ambito;
use App\Models\Planificacion\Ubicaciones;
use App\Models\Planificacion\especificadegasto;
use App\Models\Planificacion\AperturaProgramatic;
class CentroCosto extends Model
{
    use HasFactory;
    protected $table = 'planificacion.centros_costo';

    protected $fillable = [
        'id',
        'id_ubicacion',
        'id_unidad_ejecutora',
        'id_apertura_programatica',
        'id_especifica_gastos',
        'id_ambito_proyecto',
        'descripcion',
        'estatus'
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('descripcion', 'ilike',"%$search%")->orWhere('id_especifica_gastos', 'ilike', "%$search%");
    }
    public function unidad(){
        return $this->belongsTo(UnidadEjecutora::class,'id_unidad_ejecutora','id');
    }
    public function ubicacion(){
        return $this->belongsTo(Ubicaciones::class,'id_ubicacion','id');
    }
    public function ambito(){
        return $this->belongsTo(Ambito::class,'id_ambito_proyecto','id');
    }
    public function apertura(){
        return $this->belongsTo(AperturaProgramatic::class,'id_apertura_programatica','id');
    }
    public function especificaGasto(){
        return $this->belongsTo(especificadegasto::class,'id_especifica_gastos','id');
    }

    public function requisiciones()
    {
        return $this->hasMany(\App\Models\Compras\Requisicion::class, 'id_centro_costo');
    }

}
