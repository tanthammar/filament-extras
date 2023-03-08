<?php

use Illuminate\Support\Facades\Route;

Route::get('/filament-phone-flags.png', static function () {
    return response()->file(__DIR__.'/../images/vendor/intl-tel-input/build/flags.png');
});

Route::get('/filament-phone-flags@2x.png', static function () {
    return response()->file(__DIR__.'/../images/vendor/intl-tel-input/build/flags@2x.png');
});
