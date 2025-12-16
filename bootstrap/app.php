<?php

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
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Exceção de autenticação (API)
        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }
        });

        // Exceção de autorização
        $exceptions->render(function (
            \Illuminate\Auth\Access\AuthorizationException $e,
            $request
        ) {
            return response()->json([
                'message' => 'Forbidden.'
            ], 403);
        });

        // Exceção genérica (fallback)
        $exceptions->render(function (
            \Throwable $e,
            $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Internal server error',
                    'exception' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        });

    })
    ->create();
