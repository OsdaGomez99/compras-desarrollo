<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaProgramatic extends Model
{
    use HasFactory;
    protected $table = 'planificacion.apertura_programatica';

    protected $fillable = [
        'codigo', 'descripcion', 'estatus'
    ];
    public function scopeSearch($query, $search)
    {
        return $query->where('codigo', 'ilike',"%$search%")->orWhere('descripcion', 'ilike', "%$search%")->orWhere('estatus', 'ilike', "%$search%");
    }
}
