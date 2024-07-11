<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Segurity\BlockIp;
use Carbon\Carbon;

class RestrictIpAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $start_date = Carbon::now()->subMonths(3)->toDateString();
        $end_date = Carbon::now();

        $ip_restringida = BlockIp::whereBetween('created_at', [$start_date, $end_date])->pluck('ip')->toArray();

        if(in_array($request->ip(), $ip_restringida)) {
            return abort(403, 'Su conexión ha sido bloqueada');
        }

        return $next($request);
    }
}
