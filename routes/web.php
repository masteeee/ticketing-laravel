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
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------submitpost-------------------
*/

// PUBLIC ROUTES (no login required)
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/knowledge', [KnowledgeBaseController::class, 'index'])->name('knowledge.base');
Route::get('/knowledge/category', [KnowledgeBaseController::class, 'showCategory'])->name('knowledge.category');
Route::get('/ticket/create', [TicketController::class, 'create'])->name('ticket.create');
Route::post('/ticket/submit', [TicketController::class, 'store'])->name('ticket.public.store');
Route::get('/ticket/success', function () {
    $invoice = request('inv');
    $email = request('email');

    if (!$invoice || !$email) {
        return redirect('/');
    }

    return view('public.ticket.success', compact('invoice', 'email'));
        })->name('ticket.success');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('public.articles.show');

// PUBLIC TICKET VIEW
Route::get('/ticket/view', [App\Http\Controllers\TicketController::class, 'viewForm'])->name('ticket.view.form');
Route::get('/ticket/detail', [App\Http\Controllers\TicketController::class, 'publicDetail'])->name('ticket.public.detail');
Route::post('/ticket/reply', [App\Http\Controllers\TicketController::class, 'publicReply'])->name('ticket.public.reply');
Route::get('/get-services/{department_id}', [TicketController::class, 'getServices'])->name('get.services');


// AUTH ROUTES (Breeze)
require __DIR__.'/auth.php';

// NOTIFICATION ROUTES (login required)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/mention-suggestions', [AdminTicketController::class, 'getMentionSuggestions'])->name('mention.suggestions');
});

// ADMIN ROUTES (login required, role = admin)
Route::middleware(['auth',])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::get('/departments/refresh', [DepartmentController::class, 'refresh'])->name('departments.refresh');
    Route::resource('services', ServiceController::class);
    Route::get('/admin/services/by-department/{departmentId}', [ServiceController::class, 'getByDepartment']);
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{id}/update-status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/admin/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])->name('tickets.assign');
    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Debug route to check roles
    Route::get('/debug/roles', function() {
        $roles = \App\Models\Role::all();
        dd($roles->toArray());
    });
    Route::get('/services/by-department/{id}', function ($id) {
        return \App\Models\Service::where('department_id', $id)->get();
    });
   
});

// STAFF ROUTES (login required, role = staff)
Route::middleware(['auth',])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
      Route::resource('articles', ArticleController::class);

      Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
      Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
      Route::post('/tickets/{id}/update-status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
      Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
     
    
});

// USER PROFILE ROUTES (login required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
