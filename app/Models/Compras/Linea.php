<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    use HasFactory;

    protected $table = 'compras.lineas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descripcion', 'tipo', 'status'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('descripcion', 'ilike',"%$search%");
    }

    public function articulos()
    {
        return $this->hasMany(\App\Models\Compras\Articulo::class, 'id_linea');
    }

    public function requisiciones()
    {
        return $this->hasMany(\App\Models\Compras\Requisicion::class, 'id_linea');
    }

}
