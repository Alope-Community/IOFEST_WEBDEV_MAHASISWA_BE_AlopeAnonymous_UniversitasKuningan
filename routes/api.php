<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramRelawanController;
use App\Http\Controllers\Api\SertifikatController;
use App\Http\Controllers\Api\ProgramDonasiController;
use App\Http\Controllers\Api\TestimoniRatingController;
use App\Http\Controllers\Api\BlogArtikelController;
use App\Http\Controllers\Api\ForumController;

// ============================
// AUTHENTICATION
// ============================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/isAuth', [AuthController::class, 'isAuth']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});


// ============================
// PROGRAM RELAWAN
// ============================
Route::prefix('relawan')->group(function () {
    Route::get('/', [ProgramRelawanController::class, 'index'])->name('relawan.index');
    Route::get('/{id}', [ProgramRelawanController::class, 'show'])->name('relawan.show');

    Route::middleware('auth:sanctum')->post('/daftar', [ProgramRelawanController::class, 'store']);

    // Testimoni
    Route::get('all/testimoni', [TestimoniRatingController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/testimoni', [TestimoniRatingController::class, 'store']);
});

Route::prefix('sertifikat')->group(function () {
    Route::middleware('auth:sanctum')->post('/{program}', [SertifikatController::class, 'show'])->name('Sertifkat.show');
});

// ============================
// PROGRAM DONASI
// ============================
Route::prefix('donasi')->group(function () {
    Route::get('/', [ProgramDonasiController::class, 'index'])->name('donasi.index');
    Route::get('/{id}', [ProgramDonasiController::class, 'show'])->name('donasi.show');

    Route::middleware('auth:sanctum')->post('/{id}/daftar', [ProgramDonasiController::class, 'store']);
});

// ============================
// ARTIKEL
// ============================
Route::prefix('artikel')->group(function () {
    Route::get('/', [BlogArtikelController::class, 'index']);
    Route::get('/{id}', [BlogArtikelController::class, 'show']);
});

// ============================
// FORUM DISKUSI
// ============================
Route::prefix('forum')->group(function () {
    Route::get('/', [ForumController::class, 'index']);
    Route::get('/{id}', [ForumController::class, 'show']);
    Route::middleware('auth:sanctum')->post('/{id}/komentar', [ForumController::class, 'store']);
});

// ============================
// USER INFO (Test Endpoint)
// ============================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});