<?php
/**
 * Created by PhpStorm.
 * User: Mukta
 * Date: 24/10/2020
 * Time: 6:50 PM
 */

namespace App\Http\Services;


use Illuminate\Support\Facades\Log;

class SwapiLog
{
    public static function write(string $level = 'debug', string $msg = ''){
        Log::channel('swapi')->$level($msg);
    }
}
