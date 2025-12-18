<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CountryController::class, 'index'])->name('country.index');
Route::post('/store', [CountryController::class, 'store'])->name('country.store');
