<?php

namespace App\Models\Presupuesto;

use App\Models\Planificacion\EspecificaIngresos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reformulacion extends Model
{
    use HasFactory;
    protected $table = 'presupuesto.reformulaciones';

    protected $fillable = [
        'id',
        'id_presupuesto',
        'id_especifica_ingreso',
        'monto',
        'descripcion',
        'nro_reformulacion'
      
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('descripcion', 'ilike',"%$search%")->orWhere('descripcion', 'ilike', "%$search%");
    }
    public function especifica_ingresos(){
        return $this->belongsTo(EspecificaIngresos::class,'id_presupuesto','id');
    }
}
