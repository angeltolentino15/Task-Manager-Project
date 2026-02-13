<?php

// Import authentication controllers
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Guest routes - accessible only to non-authenticated users
Route::middleware('guest')->group(function () {
    // Display registration form
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Process registration form submission
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Display login form
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Process login form submission
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Display forgot password form
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Send password reset link via email
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Display password reset form with token
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Process password reset form submission
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Authenticated routes - accessible only to logged-in users
Route::middleware('auth')->group(function () {
    // Display email verification notice/prompt
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Verify email address via signed URL with rate limiting (6 attempts per minute)
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Resend email verification notification with rate limiting (6 attempts per minute)
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Display password confirmation form
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // Process password confirmation form submission
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Update user password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Process logout request
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});