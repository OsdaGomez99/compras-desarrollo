<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    use HasFactory;

    protected $table = 'global.prioridades';

    public function requisiciones()
    {
        return $this->hasMany(Requisicion::class, 'id_prioridad');
    }
}
