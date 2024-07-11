<?php

namespace App\Providers;

use App\Providers\FortifyServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFortifyServiceProvider extends FortifyServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Fortify::authenticateUsing(function (LoginRequest $request) {

            $user = User::where('username', $request->username)->first();

            if ($user && Hash::check($request->password, $user->password))
            {
                return $user;
            }
        });
    }
}
