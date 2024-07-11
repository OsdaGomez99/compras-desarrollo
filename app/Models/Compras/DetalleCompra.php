<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'compras.detalles_compra';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_compra',
        'id_detalle_oferta',
        'id_centro_costo',
    ];

    public function compra ()
    {
        return $this->belongsTo(\App\Models\Compras\Compra::class, 'id_compra');
    }

    public function detalle_of ()
    {
        return $this->belongsTo(\App\Models\Compras\DetalleOferta::class, 'id_detalle_oferta');
    }
}
