<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::controller(CountryController::class)->group(function () {
    Route::get('/', 'index')->name('country.index');

    Route::post('/store', 'store')->name('country.store');

    Route::get('/get/countries', 'getCountries')->name('country.getCountries');

    Route::get('/get/country', 'getCountry')->name('country.getCountry');

    Route::post('/update', 'updateCountry')->name('country.updateCountry');

    Route::post('/delete', 'deleteCountry')->name('country.deleteCountry');

    Route::post('/delete-multiple', 'deleteMultipleCountry')->name('country.deleteMultipleCountry');
});
