<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoEnvio extends Model
{
    use HasFactory;

    protected $table = 'global.puntos_envio';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'descripcion'
    ];
}
