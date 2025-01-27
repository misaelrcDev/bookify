<?php

use App\Filament\Pages\Subscription;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use Filament\Http\Middleware\Authenticate;


Route::get('/', function () {
    return redirect('/admin');
})->middleware(Authenticate::class);



// Rota para carregar a página de assinatura
Route::get('/filament/pages/subscription', Subscription::class)->name('filament.pages.subscription');

// Rota para processar o formulário de assinatura
Route::post('/filament/pages/subscription', [Subscription::class, 'updateSubscription'])->name('filament.pages.subscription.update');


// routes/web.php
Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');
