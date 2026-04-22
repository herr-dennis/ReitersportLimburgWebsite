<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleFromSession
{
    public function handle($request, Closure $next)
    {
        //Holen wir uns die Session, Fallback config-Local
        $locale = Session::get('locale', config('app.locale'));

        //ist de und nl nicht im Array
        if (! in_array($locale, ['de', 'nl'])) {
            $locale = config('app.locale');
        }

        //Setzen die Sprache um
        App::setLocale($locale);

        return $next($request);
    }
}
