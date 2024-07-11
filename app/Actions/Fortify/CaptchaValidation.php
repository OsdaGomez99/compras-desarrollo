<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaptchaValidation
{
    public function __invoke(Request $request, $next)
    {
        $captcha_value = captcha_check($request['captcha']);

        Validator::make($request->all(), [
            'captcha' => ['required', function($attribute, $value, $fail) use (&$captcha_value) {
                if($captcha_value === false){
                    $fail('Captcha es invalido');
                }
            }]
        ])->validate();

        return $next($request);
    }
}
