<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\AuthSanctum;
use App\Http\Middleware\SetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;



Route::middleware(SetResponse::class)->group(function () {

    Route::get("/jurusans", [JurusanController::class, 'index']);
    Route::post("/siswa", [SiswaController::class, 'store']);
    Route::post("/auth/login", [AuthController::class, "login"]);
    Route::middleware(AuthSanctum::class)->group(function () {
        Route::get('/auth/me', [AuthController::class, "index"]);
        Route::post('/auth/logout', [AuthController::class, "logout"]);

        Route::apiResource("/siswa", SiswaController::class)->except("store");
        Route::apiResource("/jurusans", JurusanController::class)->except("index");
        Route::apiResource('/messages', MessageController::class)->middleware('auth');
    });
    Route::fallback(function () {
        return response()->json([
            'message' => "Not found. mau diapain api nya le",
        ], 404);
    });
});



// use Illuminate\Support\Facades\Mail;

// Route::get('/test-email', function () {
//     Mail::raw('Ini adalah email percobaan.', function ($message) {
//         $message->to('rikiulir@gmail.com')
//             ->subject('Email Test');
//     });

//     return 'Email berhasil dikirim.';
// });

// use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Route::get('/qr/{number}', function ($number) {
//     return QrCode::size(300)->generate($number);
// });
