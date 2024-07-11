<?php

namespace App\Models\Planificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnoFiscal extends Model
{
    use HasFactory;

    protected $table = 'planificacion.annos_fiscales';

    protected $fillable = [
        'anno', 'is_activo'
    ];
}
