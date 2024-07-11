<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'compras.articulos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'descripcion',
        'ultimo_precio',
        'id_linea',
        'id_unidad_medida',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('descripcion', 'ilike',"%$search%");
    }

    public function linea()
    {
        return $this->belongsTo(\App\Models\Compras\Linea::class, 'id_linea')->withDefault();
    }

    public function medida()
    {
        return $this->belongsTo(\App\Models\Global\UnidadMedida::class, 'id_unidad_medida')->withDefault();
    }

}
