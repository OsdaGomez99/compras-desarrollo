<?php

namespace App\Classes;

use Spatie\Honeypot\SpamResponder\SpamResponder;
use Closure;
use Illuminate\Http\Request;
use App\Models\Segurity\BotLog;
use App\Models\Segurity\BlockIp;
use Carbon\Carbon;

class SpamView implements SpamResponder {

    public function respond(Request $request, Closure $next){

        $ip_bot = request()->ip();

        // Buscamos la ip y cuantas veces se ha registrado en la BD en el dia actual
        $cant_intentos = BotLog::where('ip', request()->ip())->whereDate('created_at', Carbon::now()->startOfDay()->toDateTimeString())->count();

        if($cant_intentos >= 5) {
            BlockIp::create([
                'ip' => $ip_bot
            ]);
        }else {
            BotLog::create([
                'ip' => $ip_bot,
                'user_agent' => $request->header('User-Agent')
            ]);
        }

        return abort(403);
    }

}
