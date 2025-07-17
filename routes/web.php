<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ PUBLIC ROUTES (no login required)
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/knowledge-base', [PublicController::class, 'knowledgeBase'])->name('public.knowledge-base');
Route::get('/submit-ticket', [PublicController::class, 'submitTicket'])->name('public.submit-ticket');

// ✅ AUTH ROUTES (Breeze)
require __DIR__.'/auth.php';

// ✅ ADMIN ROUTES (login required, role = admin)
Route::middleware(['auth',])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('departments', DepartmentController::class)->except(['show']);
    // Tambahkan route admin lainnya di sini
});

// ✅ STAFF ROUTES (login required, role = staff)
Route::middleware(['auth',])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    // Tambahkan route staff lainnya di sini
});

// ✅ USER PROFILE ROUTES (login required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
