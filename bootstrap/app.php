<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// V-- INI DIA PERUBAHANNYA --V



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // V--- DAN INI PERUBAHANNYA ---V
        $exceptions->renderable(function (AccessDeniedHttpException $e, $request) {
            
            // Cek apakah ini adalah permintaan API
            if ($request->is('api/*') || $request->wantsJson()) {
                
                // Kembalikan pesan JSON kustom kita
                return response()->json([
                    'message' => 'Anda tidak memiliki hak akses untuk melakukan aksi ini.'
                ], 403); // 403 = Forbidden (Dilarang)
            }
        });

    })->create();