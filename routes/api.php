<?php

use Illuminate\Support\Facades\Http;

Route::get('/get-country-code', static function () {
    $response = rescue(static fn () => Http::get('https://ipinfo.io/json')->json('country'), app()->getLocale(), report: false);
    return response()->json($response);
});
