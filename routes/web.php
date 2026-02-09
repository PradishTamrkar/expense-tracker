<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Add this named login route
Route::get('/login', function () {
    return response()->json([
        'message' => 'Unauthenticated. Please login via /api/login'
    ], 401);
})->name('login');