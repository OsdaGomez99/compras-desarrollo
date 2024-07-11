<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    use HasFactory;

    protected $table = 'global.formas_pago';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'descripcion'
    ];
}
