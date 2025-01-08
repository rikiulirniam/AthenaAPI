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


Route::middleware(SetResponse::class)->group(function () {

    Route::post("/siswa", [SiswaController::class, 'store']);
    Route::post("/auth/login", [AuthController::class, "login"]);
    Route::middleware(AuthSanctum::class)->group(function () {
        Route::get('/auth/me', [AuthController::class, "index"]);
        Route::post('/auth/logout', [AuthController::class, "logout"]);

        Route::apiResource("/siswa", SiswaController::class)->except("store");
        Route::apiResource('/messages', MessageController::class)->middleware('auth');
    });
    Route::fallback(function () {
        return response()->json([
            'message' => "Not found. mau diapain api nya le",
        ], 404);
    });
});


