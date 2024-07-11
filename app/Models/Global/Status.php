<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'global.status';
    protected $primaryKey = 'id';

    public function requisiciones()
    {
        return $this->hasMany(\App\Models\Compras\Requisicion::class, 'id_status');
    }

}
