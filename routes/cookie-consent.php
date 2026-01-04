<?php

use Illuminate\Support\Facades\Route;
use w01ki3\CookieConsent\Http\Controllers\CookieConsentController;

Route::group(['middleware' => ['web']], function () {
    Route::controller(CookieConsentController::class)->group(function () {
        Route::get('/cookie-consent/script-utils', 'scriptUtils')->name('cookie-consent.script-utils');
        Route::post('/cookie-consent/log', 'store')->name('cookie-consent.log');
    });
});
