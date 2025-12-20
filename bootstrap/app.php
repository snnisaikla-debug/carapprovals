<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: __DIR__.'/../routes/health.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ ใส่ใน group web เท่านั้น (มี session แน่นอน)
        $middleware->appendToGroup('web', SetLocale::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    //
    })
->create();
