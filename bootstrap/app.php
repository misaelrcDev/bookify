<?php

use App\Providers\EventServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
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
        //
    })

    ->withProviders([
        // EventServiceProvider::class, // Adicione esta linha
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->withSchedule(function (Schedule $schedule) {
        // Agendar o envio diário do relatório às 8h para um e-mail específico
        $schedule->command('report:send misael.cabral89@gmail.com')->dailyAt('16:13');
    })
    ->create();
