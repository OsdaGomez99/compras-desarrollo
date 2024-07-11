<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOferta extends Model
{
    use HasFactory;

    protected $table = 'compras.detalles_oferta';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_oferta',
        'id_detalle_requisicion',
        'cantidad_cotizada',
        'cantidad_ofertada',
        'precio',
        'exento_iva'
    ];

    public function oferta ()
    {
        return $this->belongsTo(\App\Models\Compras\Oferta::class, 'id_oferta');
    }

    public function detalle_req ()
    {
        return $this->belongsTo(\App\Models\Compras\DetalleRequisicion::class, 'id_detalle_requisicion');
    }
}
