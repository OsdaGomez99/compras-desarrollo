<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $table = 'compras.ofertas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_cotizacion',
        'id_proveedor',
        'fecha_entrega',
        'fecha_recepcion',
        'fecha_oferta',
        'fecha_vigencia',
        'condiciones_venta',
        'descuento',
        'van',
        'tipo',
        'estatus',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('id_cotizacion', 'ilike',"%$search%");
    }

    public function cotizacion ()
    {
        return $this->belongsTo(\App\Models\Compras\Cotizacion::class, 'id_cotizacion');
    }

    public function proveedor ()
    {
        return $this->belongsTo(\App\Models\Compras\Proveedor::class, 'id_proveedor');
    }

    public function detalles_of ()
    {
        return $this->hasMany(\App\Models\Compras\DetalleOferta::class, 'id_oferta');
    }


}
