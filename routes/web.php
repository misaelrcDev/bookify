<?php

use App\Http\Controllers\ReportController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
})->middleware(Authenticate::class);

Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');
