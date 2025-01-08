<?php

use Illuminate\Support\Facades\Route;
use Filament\Http\Middleware\Authenticate;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect('/admin');
})->middleware(Authenticate::class);

Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');
