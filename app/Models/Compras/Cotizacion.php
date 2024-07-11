<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'compras.cotizaciones';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'tipo',
        'user_id',
        'numero',
        'fecha_cotizacion',
        'fecha_vigencia',
        'fecha_tope',
        'hora_tope',
        'fecha_visita',
        'hora_visita',
        'lugar_visita',
        'porc_iva',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('numero', 'LIKE',"%$search%");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function requisicion()
    {
        return $this->belongsTo(\App\Models\Compras\Requisicion::class, 'id_requisicion');
    }

    public function detalles_cot ()
    {
        return $this->hasMany(\App\Models\Compras\DetalleCotizacion::class, 'id_cotizacion');
    }
}
