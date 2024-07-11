<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadEjecutora extends Model
{
    use HasFactory;
    protected $table = 'planificacion.unidades_ejecutoras';

    protected $fillable = [
        'id','id_personal', 'id_sede', 'nombre', 'is_activo'
    ];

    public function requisiciones()
    {
        return $this->hasMany(Requisicion::class, 'id_solicitante');
    }
}
