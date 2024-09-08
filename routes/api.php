<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GoogleCalendarController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('events', [EventsController::class, 'getEvents']);
Route::post('event', [EventsController::class, 'storeEvent']);
Route::get('even', [GoogleCalendarController::class, 'fetchEvents']);
