<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConverterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currency-converter', [CurrencyConverterController::class, 'index'])->name('currency-converter.index');
Route::post('/currency-converter', [CurrencyConverterController::class, 'convert'])->name('currency-converter.convert');

