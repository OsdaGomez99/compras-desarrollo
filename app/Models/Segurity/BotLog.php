<?php

namespace App\Models\Segurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotLog extends Model
{
    use HasFactory;

    protected $table = 'segurity.bot_log';

    protected $fillable = ['ip', 'user_agent'];

}
