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
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Models\Role;
use App\Models\Service;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================
// ✅ PUBLIC ROUTES
// =====================
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

Route::get('/articles/{article}', [ArticleController::class, 'show'])
    ->whereNumber('article') // ✅ Hindari bentrok dengan 'create'
    ->name('public.articles.show');

Route::get('/ticket/view', [TicketController::class, 'viewForm'])->name('ticket.view.form');
Route::get('/ticket/detail', [TicketController::class, 'publicDetail'])->name('ticket.public.detail');
Route::post('/ticket/reply', [TicketController::class, 'publicReply'])->name('ticket.public.reply');
Route::get('/get-services/{department_id}', [TicketController::class, 'getServices'])->name('get.services');

// =====================
// ✅ AUTH ROUTES (breeze)
// =====================
require __DIR__.'/auth.php';

// =====================
// ✅ AUTHENTICATED ROUTES
// =====================
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Departments
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::get('/departments/refresh', [DepartmentController::class, 'refresh'])->name('departments.refresh');

    // Services
    Route::resource('services', ServiceController::class);
    Route::get('/services/by-department/{id}', function ($id) {
        return Service::where('department_id', $id)->get();
    });

    // Tickets
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{id}/update-status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])->name('tickets.assign');

    // Articles
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); // ✅ fix bentrok
    Route::resource('articles', ArticleController::class)->except(['create', 'show'])->where(['article' => '[0-9]+']);
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show')->whereNumber('article'); // ✅ explicit

    // Categories
    Route::resource('categories', CategoryController::class);

    // Roles & Permissions
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // Users
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/mention-suggestions', [AdminTicketController::class, 'getMentionSuggestions'])->name('mention.suggestions');

    // Debug Route
    Route::get('/debug/roles', function () {
        $roles = Role::all();
        dd($roles->toArray());
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
