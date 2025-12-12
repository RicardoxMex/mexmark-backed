<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LogoutAllController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ResendVerificationController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\TokenController;

// Public authentication routes
Route::post('/auth/register', RegisterController::class);
Route::post('/auth/login', LoginController::class);
Route::post('/auth/forgot-password', ForgotPasswordController::class);
Route::post('/auth/reset-password', ResetPasswordController::class);

// Protected authentication routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', LogoutController::class);
    Route::post('/auth/logout-all', LogoutAllController::class);
    Route::post('/auth/email/verification-notification', ResendVerificationController::class);
    Route::get('/auth/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    
    // Profile routes
    Route::get('/auth/profile', [ProfileController::class, 'show']);
    Route::put('/auth/profile', [ProfileController::class, 'update']);
    Route::delete('/auth/profile', [ProfileController::class, 'destroy']);
    
    // Token management routes
    Route::get('/auth/tokens', [TokenController::class, 'index']);
    Route::delete('/auth/tokens/{tokenId}', [TokenController::class, 'destroy']);
});

// Legacy route for compatibility
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
