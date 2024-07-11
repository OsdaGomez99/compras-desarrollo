<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras.compras';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'numero',
        'fecha_compra',
        'fecha_entrega_oc',
        'fecha_entrega_mat',
        'fecha_resolucion_cu',
        'num_resolucion_cu',
        'iva_incluido',
        'porc_iva',
        'subtotal',
        'monto_imput_iva',
        'porc_ret_iva',
        'porc_descuento',
        'total',
        'req_rendicion',
        'num_procedimiento',
        'nota1',
        'nota2',
        'id_cotizacion',
        'id_proveedor',
        'id_adjudicante',
        'id_tipo_adjudicacion',
        'id_forma_pago',
        'id_punto_envio',
        'estatus',
        'tipo',
        'user_id',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('numero', 'ilike',"%$search%");
    }

    public function cotizacion ()
    {
        return $this->belongsTo(\App\Models\Compras\Cotizacion::class, 'id_cotizacion');
    }

    public function oferta ()
    {
        return $this->belongsTo(\App\Models\Compras\Oferta::class, 'id_oferta');
    }

    public function proveedor ()
    {
        return $this->belongsTo(\App\Models\Compras\Proveedor::class, 'id_proveedor');
    }

    public function forma_pago ()
    {
        return $this->belongsTo(\App\Models\Global\FormaPago::class, 'id_forma_pago');
    }

    public function punto_envio ()
    {
        return $this->belongsTo(\App\Models\Global\PuntoEnvio::class, 'id_punto_envio');
    }

    public function adjudicante ()
    {
        return $this->belongsTo(\App\Models\Global\Adjudicante::class, 'id_adjudicante');
    }

    public function tipo_adjudicacion ()
    {
        return $this->belongsTo(\App\Models\Global\TipoAdjudicacion::class, 'id_tipo_adjudicacion');
    }

    public function user ()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
