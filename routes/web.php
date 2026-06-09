<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('tickets', TicketController::class)->only([
        'index',
        'create',
        'store',
        'show'
    ]);

    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::post('/tickets/{ticket}/status', [TicketController::class, 'changeStatus'])->name('tickets.status');

    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/status', [TaskController::class, 'changeStatus'])->name('tasks.status');
    Route::post('/tasks/{task}/notes', [TaskController::class, 'storeNote'])->name('tasks.notes.store');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('users', UserController::class);
    });

    Route::middleware('role:admin,website_manager')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('projects', ProjectController::class);

        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [AdminPaymentController::class, 'createForm'])->name('payments.create');
        Route::post('/payments', [AdminPaymentController::class, 'store'])->name('payments.store');
        Route::post('/payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

        Route::get('/debtors', [AdminPaymentController::class, 'debtors'])->name('payments.debtors');
    });

    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/payments', [CustomerPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [CustomerPaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [CustomerPaymentController::class, 'store'])->name('payments.store');
    });
});
