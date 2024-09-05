<?php

use Illuminate\Support\Facades\Route;

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
