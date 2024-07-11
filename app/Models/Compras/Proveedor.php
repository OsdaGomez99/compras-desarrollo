<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'compras.proveedores';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nombre',
        'rif',
        'representante',
        'telefono',
        'telefono_alt',
        'email',
        'direccion',
        'num_rnc',
        'nro_alsobocaroni',
        'cod_grupo_alsobocaroni',
        'ruc_alsobocaroni',
        'id_cuenta_contable',
        'id_tipo_persona',
        'id_tipo_empresa',
        'status',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'ilike',"%$search%")->orWhere('rif', 'LIKE', "%$search%")->orWhere('representante', 'ilike', "%$search%");
    }

    public function persona()
    {
        return $this->belongsTo(\App\Models\Global\TipoPersona::class, 'id_tipo_persona');
    }

    public function empresa()
    {
        return $this->belongsTo(\App\Models\Global\TipoEmpresa::class, 'id_tipo_empresa');
    }
}
