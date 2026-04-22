<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocaleFallback
{
    public function handle($request, Closure $next)
    {
        // Falls Sprache nicht de/nl ist, setze Standard = de
        if (! in_array(App::getLocale(), ['de', 'nl'])) {
            App::setLocale('nl');
        }

        return $next($request);
    }
}

