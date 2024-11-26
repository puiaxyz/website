<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';

// Welcome route
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->usertype === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }

    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('admin/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::post('admin/reports/generate', [ReportController::class, 'generate'])->name('admin.reports.generate');
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('admin/payment/history', [PaymentHistoryController::class, 'adminPaymentHistory'])->name('admin.payment.history');
    Route::get('/admin/assign-payment', [UserController::class, 'showAssignPaymentForm'])->name('admin.assign.payment');
    Route::post('/admin/assign-payment', [UserController::class, 'assignPayments'])->name('admin.assign.payment.submit');

    // Ensure this route is defined here
    Route::post('admin/users/assign-payments', [UserController::class, 'assignPayments'])->name('admin.users.assignPayments');
});
Route::get('/dashboard', [HomeController::class, 'studentDashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route for initiating the payment process
    Route::get('/payment/initiate/{payment}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/receipt/{payment}', [PaymentController::class, 'showReceipt'])->name('payment.receipt');
    Route::get('/payment/history', [PaymentController::class, 'studentPaymentHistory'])->name('student.payment.history');
});

