<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('events', [EventsController::class, 'getEvents']);
Route::post('event', [EventsController::class, 'storeEvent']);