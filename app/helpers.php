<?php

use Carbon\Carbon;

if (! function_exists('cambiarMes')) {
    function cambiarMes ($date)
    {
        $mes = Carbon::parse($date)->format('m');
        $meses = [
            '01' => 'A',
            '02' => 'B',
            '03' => 'C',
            '04' => 'D',
            '05' => 'E',
            '06' => 'F',
            '07' => 'G',
            '08' => 'H',
            '09' => 'I',
            '10' => 'J',
            '11' => 'K',
            '12' => 'L',
        ];
        return $meses[$mes];
    }
}

if (! function_exists('trimestre')) {

    function trimestre($datetime)
        {
            $mes = date("m",strtotime($datetime));//Referencias: http://stackoverflow.com/a/3768112/1883256
            $mes = is_null($mes) ? date('m') : $mes;
            $trim=floor(($mes-1) / 3)+1;
            return $trim;
        }
}