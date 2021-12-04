<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;

Route::group(['as' => 'auth.', 'prefix' => 'v1/auth', 'middleware' => ["throttle:5,1"]], function () {
    Route::post('/register', [AuthController::class, 'store'])->name('register');
});
