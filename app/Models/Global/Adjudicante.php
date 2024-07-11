<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjudicante extends Model
{
    use HasFactory;

    protected $table = 'global.adjudicantes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nombre'
    ];
}
