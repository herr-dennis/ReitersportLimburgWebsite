<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocaleNl
{
    public function handle($request, Closure $next)
    {
        App::setLocale('nl');
        return $next($request);
    }
}
