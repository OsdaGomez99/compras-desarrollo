<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificacionCompra extends Model
{
    use HasFactory;

    protected $table = 'compras.modificaciones_compra';
    protected $primaryKey = 'id';
    protected $fillable = [
        'numero',
        'fecha',
        'id_status',
        'detalle_descripcion',
        'detalle_modificacion',
    ];

    public function compra()
    {
        return $this->belongsTo(\App\Models\Compras\Compra::class, 'id_compra');
    }

    public function proveedor()
    {
        return $this->belongsTo(\App\Models\Compras\Proveedor::class, 'id_proveedor');
    }
}
