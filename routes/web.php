<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NSController;
use App\Http\Controllers\ChoiceController;

Route::get('/', function () {
    $stations = (new NSController())->getStations();
    return view('home', ['stations' => $stations]);
})->name('home');

Route::get('/dobbel', function () {
    $startStationUic = request('station');
    if(!$startStationUic) return redirect()->route('home');
    $data = ChoiceController::chooseTrain($startStationUic);
    return view('dobbel', ['departure' => $data]);
})->name('dobbel');