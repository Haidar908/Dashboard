<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtamaControl;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Tampilkan combo.blade.php sebagai halaman pertama
Route::view('/', 'combo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//User Routes
Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
});

//Admin Routes
Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

//Super Admin Routes
Route::middleware(['auth', 'superAdminMiddleware'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
});
Route::get('/combo', [ComboController::class, 'index'])->name('combo');
Route::get('/utama', [UtamaControl::class, 'index'])->name('halaman_utama');
Route::get('/combo', [ComboController::class, 'index'])->name('combo');
Route::get('/logout-combo', [AuthenticatedSessionController::class, 'logoutAndRedirect'])->name('logout.combo');