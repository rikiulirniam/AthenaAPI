<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Middleware\AuthSanctum;
use App\Http\Middleware\SetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::middleware(SetResponse::class)->group(function () {
    Route::post("/auth/login", [AuthController::class, "login"]);
    Route::post('/auth/logout', [AuthController::class, "logout"]);
    Route::get('/auth/me', [AuthController::class, "index"]);

    Route::apiResource('/messages', MessageController::class)->middleware('auth');
});
// Route::apiResource('/siswa')