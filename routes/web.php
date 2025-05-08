<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:global'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('quotes.index');
    });

    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
});
