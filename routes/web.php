<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CountryController::class, 'index'])->name('country.index');
Route::post('/store', [CountryController::class, 'store'])->name('country.store');

Route::get('/get/countries', [CountryController::class, 'getCountries'])->name('country.getCountries');

Route::get('/get/country', [CountryController::class, 'getCountry'])->name('country.getCountry');
Route::post('/update', [CountryController::class, 'updateCountry'])->name('country.updateCountry');
