<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NSController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/nearest', function (Request $request) {
    $lat = $request->input('lat');
    $lng = $request->input('lng');
    $station = (new NSController())->getClosestStation($lat, $lng);
    return $station;
})->name('api.nearest');