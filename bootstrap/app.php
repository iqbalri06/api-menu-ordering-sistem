<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (){
            

            // USER MANAGEMENT ROUTE
            Route::middleware('api')
                ->prefix('api/role')
                ->name('role.')
                ->group(base_path('routes/Role/role.php'));

            Route::middleware('api')
               ->prefix('api/user')
               ->name('user.')
               ->group(base_path('routes/User/User.php'));
               Route::middleware('api')
               ->prefix('api/menu')
               ->name('menu.')
               ->group(base_path('routes/Menu/Menu.php'));
        }
        
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
