<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;


// Route to get all users
Route::get('/users', function () {
    return response()->json([
        'users' => App\Models\User::all()
    ]);
});

// Route to test the Laravel setup
Route::get('/test', function () {
    return 'I am from Laravel';
});

Route::get('events', [EventsController::class, 'getEvents']);
Route::post('events', [EventsController::class, 'storeEvent']);