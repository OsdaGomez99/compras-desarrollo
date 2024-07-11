<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecificaIngresos extends Model
{
    use HasFactory;
    protected $table = 'planificacion.especificas_ingresos';

    protected $fillable = [
        'id',
        'codigo',
        'nivel',
        'movim',
        'mostrar',
        'status'
      
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('descripcion', 'ilike',"%$search%")->orWhere('descripcion', 'ilike', "%$search%");
    }
}
