<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\TicketController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\Admin\AdminTicketController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// PUBLIC ROUTES (no login required)
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/knowledge', [KnowledgeBaseController::class, 'index'])->name('knowledge.base');
Route::get('/ticket/create', [TicketController::class, 'create'])->name('ticket.create');
Route::post('/ticket/submit', [TicketController::class, 'store'])->name('ticket.public.store');
// Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');
// Route::get('/ticket/create', [TicketingController::class, 'create'])->name('ticket.create');

// AUTH ROUTES (Breeze)
require __DIR__.'/auth.php';

// ADMIN ROUTES (login required, role = admin)
Route::middleware(['auth',])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::get('/departments/refresh', [DepartmentController::class, 'refresh'])->name('departments.refresh');
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::patch('/admin/tickets/{id}/update-status', [AdminTicketController::class, 'updateStatus'])
    ->name('admin.tickets.update-status');
    // Route::get('tickets/data', [TicketingController::class, 'data'])->name('admin.tickets.data');

    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
    // Tambahkan route admin lainnya di sini
});

// STAFF ROUTES (login required, role = staff)
Route::middleware(['auth',])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    // Tambahkan route staff lainnya di sini
});

// USER PROFILE ROUTES (login required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
