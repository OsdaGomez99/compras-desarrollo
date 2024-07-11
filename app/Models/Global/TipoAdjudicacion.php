<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAdjudicacion extends Model
{
    use HasFactory;

    protected $table = 'global.tipos_adjudicacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'descripcion'
    ];
}
