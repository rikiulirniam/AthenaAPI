<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\AuthSanctum;
use App\Http\Middleware\SetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::middleware([SetResponse::class, AuthSanctum::class])->group(function () {
    Route::post("/auth/login", [AuthController::class, "login"]);
    Route::post('/auth/logout', [AuthController::class, "logout"]);
    Route::get('/auth/me', [AuthController::class, "index"]);

    Route::apiResource("/siswa", SiswaController::class);
    Route::apiResource('/messages', MessageController::class)->middleware('auth');
});
// Route::apiResource('/siswa')

Route::fallback(function () {
    return response()->json([
        'message' => "Not found. mau diapain api nya le",
    ], 404);
});
