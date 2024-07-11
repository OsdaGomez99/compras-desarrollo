<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFormulacion extends Model
{
    use HasFactory;
    protected $table = 'presupuesto.detalle_presupuesto';

    protected $fillable = [

        'id',
        'id_presupuesto',
        'descripcion',
        'id_centro_costo',
        'monto_origen',
        'monto_disponible',
        'monto_reformulaciones',
        'monto_traspasos',
        'monto_comprometido',
        'estatus',
        'created_at',
        'anno',
        'version',
      
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('descripcion', 'ilike',"%$search%")->orWhere('anno', 'ilike', "%$search%");
    }
   
}
