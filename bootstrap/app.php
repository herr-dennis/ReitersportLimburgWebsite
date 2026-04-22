<?php

use App\Http\Middleware\SetLocaleFromSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocaleFallback::class,
            SetLocaleFromSession::class,
        ]);
        $middleware->alias([
            'locale.fallback' => \App\Http\Middleware\SetLocaleFallback::class,
            'locale.de'       => \App\Http\Middleware\SetLocaleDe::class,
            'locale.nl'       => \App\Http\Middleware\SetLocaleNl::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
