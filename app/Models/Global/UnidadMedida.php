<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;

    protected $table = 'global.unidades_medida';

    protected $fillable = [
        'codigo',
        'descripcion',
    ];

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'id_unidad_medida');
    }
}
