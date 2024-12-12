<?php

use Illuminate\Support\Facades\Route;
use Filament\Http\Middleware\Authenticate;

Route::get('/', function () {
    return redirect('/admin');
})->middleware(Authenticate::class);
