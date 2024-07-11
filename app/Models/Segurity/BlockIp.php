<?php

namespace App\Models\Segurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockIp extends Model
{
    use HasFactory;

    protected $table = 'segurity.block_ip';

    protected $fillable = ['ip'];

}
