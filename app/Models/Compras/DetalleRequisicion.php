<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRequisicion extends Model
{
    use HasFactory;

    protected $table = 'compras.detalles_requisicion';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_requisicion',
        'id_articulo',
        'descripcion',
        'id_unidad_medida',
        'cantidad',
    ];

    public function requisicion ()
    {
        return $this->belongsTo(\App\Models\Compras\Requisicion::class, 'id_requisicion');
    }

    public function articulo ()
    {
        return $this->belongsTo(\App\Models\Compras\Articulo::class, 'id_articulo');
    }

    public function medida()
    {
        return $this->belongsTo(\App\Models\Global\UnidadMedida::class, 'id_unidad_medida');
    }

    public function detalles_cot ()
    {
        return $this->hasMany(\App\Models\Compras\DetalleCotizacion::class, 'id_detalle_requisicion');
    }
}
