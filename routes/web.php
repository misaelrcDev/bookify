<?php

use App\Http\Controllers\ReportController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
})->middleware(Authenticate::class);


Route::post('/filament/pages/subscription', function (\Illuminate\Http\Request $request) {
    $company = Auth::user()->company;

    $request->validate([
        'plan' => 'required|string',
    ]);

    $company->newSubscription('default', $request->plan)->create($request->paymentMethod);

    return redirect()->route('filament.pages.subscription')->with('success', 'Assinatura atualizada com sucesso!');
})->name('filament.pages.subscription');


Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');
