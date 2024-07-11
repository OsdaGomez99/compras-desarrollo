<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCotizacion extends Model
{
    use HasFactory;

    protected $table = 'compras.detalles_cotizacion';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_cotizacion',
        'id_detalle_requisicion',
        'num_linea',
        'cantidad',
    ];

    public function cotizacion ()
    {
        return $this->belongsTo(\App\Models\Compras\Cotizacion::class, 'id_cotizacion');
    }

    public function detalle_req ()
    {
        return $this->belongsTo(\App\Models\Compras\DetalleRequisicion::class, 'id_detalle_requisicion');
    }

}
