<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ PUBLIC ROUTES (no login required)
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/knowledge-base', [PublicController::class, 'knowledgeBase'])->name('public.knowledgeBase');
Route::get('/submit-ticket', [PublicController::class, 'submitTicket'])->name('public.submitTicket');


// ✅ ADMIN ROUTES (login required, role=admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Tambahkan route admin lain di sini
});


// ✅ STAFF ROUTES (login required, role=staff)
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    // Tambahkan route staff lain di sini
});


// ✅ USER PROFILE (login required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ✅ AUTH ROUTES (Breeze)
require __DIR__.'/auth.php';
