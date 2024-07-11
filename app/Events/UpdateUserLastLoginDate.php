<?php

namespace App\Events;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class UpdateUserLastLoginDate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
        try {
            $user = $event->user;
            $user->last_login = Carbon::now()->toDateTimeString();
            $user->last_ip_login = request()->ip();
            $user->save();

        }catch(\Throwable $th){
            report($th);
        }
    }
}
