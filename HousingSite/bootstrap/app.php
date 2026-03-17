<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add this section:
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        
        // If you want to keep your existing middleware groups, add them too:
        $middleware->web(append: [
            // Your web middleware
        ]);
        
        $middleware->api(append: [
            // Your api middleware  
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();