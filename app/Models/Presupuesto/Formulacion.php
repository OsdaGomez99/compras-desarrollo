<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulacion extends Model
{
    use HasFactory;
    protected $table = 'presupuesto.presupuesto';

    protected $fillable = [
        'id',
        'monto',
        'descripcion',
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
    public function Detalles(){
        return $this->belongsTo(DetalleFormulacion::class,'id','id_presupuesto');
    }
    
}
