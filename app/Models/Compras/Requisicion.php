<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisicion extends Model
{
    use HasFactory;

    protected $table = 'compras.requisiciones';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'tipo',
        'id_solicitante',
        'id_linea',
        'id_prioridad',
        'user_id',
        'numero',
        'fecha_requisicion',
        'fecha_recepcion',
        'trimestre',
        'num_referencia',
        'id_anno',
        'justificacion',
        'estatus',
        'created_at',
        'updated_at',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('numero', 'ilike',"%$search%");
    }

    public function detalle_req()
    {
        return $this->hasMany(\App\Models\Compras\DetalleRequisicion::class, 'id_requisicion');
    }

    public function unidad()
    {
        return $this->belongsTo(\App\Models\Planificacion\UnidadEjecutora::class, 'id_solicitante');
    }

    public function anno()
    {
        return $this->belongsTo(\App\Models\Planificacion\AnnoFiscal::class, 'id_anno');
    }

    public function linea()
    {
        return $this->belongsTo(\App\Models\Compras\Linea::class, 'id_linea')->withDefault();
    }

    public function prioridad()
    {
        return $this->belongsTo(\App\Models\Global\Prioridad::class, 'id_prioridad');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function cotizacion ()
    {
        return $this->hasMany(\App\Models\Compras\Cotizacion::class, 'id_requisicion');
    }

}
