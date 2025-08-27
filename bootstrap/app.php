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
        // Deteksi namespace yang tersedia (beda versi Spatie kadang beda folder)
        $roleMw = class_exists(\Spatie\Permission\Middlewares\RoleMiddleware::class)
            ? \Spatie\Permission\Middlewares\RoleMiddleware::class
            : \Spatie\Permission\Middleware\RoleMiddleware::class;

        $permMw = class_exists(\Spatie\Permission\Middlewares\PermissionMiddleware::class)
            ? \Spatie\Permission\Middlewares\PermissionMiddleware::class
            : \Spatie\Permission\Middleware\PermissionMiddleware::class;

        $ropMw = class_exists(\Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class)
            ? \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class
            : \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class;

        $middleware->alias([
            'role' => $roleMw,
            'permission' => $permMw,
            'role_or_permission' => $ropMw,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
