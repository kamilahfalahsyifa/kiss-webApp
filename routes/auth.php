<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES AUDIT - May 2026
|--------------------------------------------------------------------------
| ACTIVE (in use):
|   - login, logout (AuthenticatedSessionController)
|   - password.update (PasswordController)
|
| COMMENTED OUT (not used - can be re-enabled if needed):
|   - register (RegisteredUserController) - no user self-registration in this app
|   - forgot-password (PasswordResetLinkController) - no password reset feature
|   - reset-password (NewPasswordController) - no password reset feature
|   - verify-email (EmailVerificationPromptController, VerifyEmailController) - User doesn't implement MustVerifyEmail
|   - confirm-password (ConfirmablePasswordController) - not used
|   - email/verification-notification - not used
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // [DISABLED] Register - no self-registration in this app
    // Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // [DISABLED] Forgot password - no password reset feature
    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // [DISABLED] Reset password - no password reset feature
    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    // Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    // [DISABLED] Email verification - User model doesn't implement MustVerifyEmail
    // Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    //     ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //     ->middleware('throttle:6,1')->name('verification.send');

    // [DISABLED] Confirm password - not used in this app
    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});