<?php

use App\Filament\Pages\Subscription;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionExpiry;
use App\Models\User;

Route::get('/', function () {
    return redirect('/admin');
})->middleware(Authenticate::class);



// Rota para carregar a página de assinatura
Route::get('/filament/pages/subscription', Subscription::class)->name('filament.pages.subscription');

// Rota para processar o formulário de assinatura
Route::post('/filament/pages/subscription', [Subscription::class, 'updateSubscription'])->name('filament.pages.subscription.update');



// routes/web.php
Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');

use App\Http\Controllers\TestEmailController;

Route::get('/send-test-email', [TestEmailController::class, 'sendTestEmail']);

Route::get('/send-test-email', function () {
    $user = auth()->user();
    if (!$user) {
        return 'Nenhum usuário autenticado.';
    }
    $subscription = $user->subscription('default');

    Mail::to($user->email)->send(new SubscriptionExpiry($user, $subscription));

    return 'E-mail de teste enviado com sucesso para ' . $user->email;
});

