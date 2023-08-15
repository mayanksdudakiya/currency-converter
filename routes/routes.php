<?php

namespace Mayanksdudakiya\CurrencyConverter\Routes;

use Illuminate\Support\Facades\Route;
use Mayanksdudakiya\CurrencyConverter\CurrencyConverterController;

Route::middleware('api')
    ->prefix('api/v1')
    ->get('convert-currency', CurrencyConverterController::class)
    ->name('convert.currency');
