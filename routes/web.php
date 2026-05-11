<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AplFileController;
use App\Http\Controllers\AplSheetController;
use App\Http\Controllers\AplItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('landing.index');
});

// Role-based dashboard redirect after login
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }

    return match($user->role) {
        'mekanik' => redirect()->route('mekanik.dashboard'),
        'gl' => redirect()->route('management.dashboard'),
        'tere' => redirect()->route('management.dashboard'),
        'planner' => redirect()->route('management.dashboard'),
        default => redirect()->route('mekanik.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// MEKANIK ROUTES
Route::middleware(['auth', 'role:mekanik'])->prefix('mekanik')->name('mekanik.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'mekanikIndex'])->name('dashboard');
    Route::get('/input', [DashboardController::class, 'mekanikInput'])->name('input');
    Route::get('/input-data', [DashboardController::class, 'mekanikInputData'])->name('input-data');
    Route::post('/store', [DashboardController::class, 'storeActivity'])->name('store');
    Route::get('/historical', [DashboardController::class, 'mekanikHistorical'])->name('historical');
    Route::get('/profile', [DashboardController::class, 'mekanikProfile'])->name('profile');

    // APL Files - View Only for Mekanik
    Route::get('/apl-files', [AplFileController::class, 'index'])->name('apl-files');
    Route::get('/apl-files/{aplFile}', [AplFileController::class, 'show'])->name('apl-files.show');

    // Activities CRUD (resource controller)
    Route::resource('activities', ActivityController::class);
});

// MANAGEMENT ROUTES (GL/TERE/PLANNER)
Route::middleware(['auth', 'role:gl,tere,planner'])->prefix('management')->name('management.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'managementIndex'])->name('dashboard');
    Route::get('/historical', [DashboardController::class, 'managementHistorical'])->name('historical');
    Route::get('/profile', [DashboardController::class, 'managementProfile'])->name('profile');

    // APL Files - GL/TERE view only, PLANNER uses separate routes below
    Route::get('/apl-files', [AplFileController::class, 'index'])->name('apl-files');

    // GL Approval Routes
    Route::middleware(['role:gl'])->group(function () {
        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
        Route::post('/activities/{activity}/approve', [ActivityController::class, 'approve'])->name('activities.approve');
        Route::post('/activities/{activity}/reject', [ActivityController::class, 'reject'])->name('activities.reject');
    });

    // TERE User Management Routes
    Route::middleware(['role:tere'])->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
});

// PLANNER only routes - specific routes BEFORE dynamic {aplFile} route
Route::middleware(['auth', 'role:planner'])->prefix('management')->name('management.')->group(function () {
    // APL Files - CREATE first (static route before dynamic)
    Route::get('/apl-files/create', [AplFileController::class, 'create'])->name('apl-files.create');
    Route::post('/apl-files', [AplFileController::class, 'store'])->name('apl-files.store');

    // APL Files - EDIT (static route before dynamic)
    Route::get('/apl-files/{aplFile}/edit', [AplFileController::class, 'edit'])->name('apl-files.edit');
    Route::put('/apl-files/{aplFile}', [AplFileController::class, 'update'])->name('apl-files.update');
    Route::delete('/apl-files/{aplFile}', [AplFileController::class, 'destroy'])->name('apl-files.destroy');

    // APL Files - SHOW (dynamic route AFTER static routes are defined)
    Route::get('/apl-files/{aplFile}', [AplFileController::class, 'show'])->name('apl-files.show');

    // APL Sheet CRUD
    Route::post('/apl-files/{aplFile}/sheets', [AplSheetController::class, 'store'])->name('apl-files.sheets.store');
    Route::put('/sheets/{aplSheet}', [AplSheetController::class, 'update'])->name('sheets.update');
    Route::delete('/sheets/{aplSheet}', [AplSheetController::class, 'destroy'])->name('sheets.destroy');

    // APL Item CRUD
    Route::post('/sheets/{aplSheet}/items', [AplItemController::class, 'store'])->name('sheets.items.store');
    Route::put('/items/{aplItem}', [AplItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{aplItem}', [AplItemController::class, 'destroy'])->name('items.destroy');

    // Historical Export for Planner
    Route::get('/historical/export', [DashboardController::class, 'managementHistoricalExport'])->name('historical.export');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__.'/auth.php';