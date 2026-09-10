<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class HelperService
{
    //    static method to forget cache item if it exists
    public static function cacheForget($key): void
    {
        if (Cache::has($key)) {
            Cache::forget($key);
        }
    }
}
