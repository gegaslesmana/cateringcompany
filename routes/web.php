<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Operator\OrderController as OperatorOrderController;
use App\Http\Controllers\HRD\ApprovalController as HRDApprovalController;
use App\Http\Controllers\Security\MonitoringController as SecurityMonitoringController;

// HOME / WELCOME
Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// PROFILE (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// OPERATOR ROUTES
Route::middleware(['web', 'auth', 'role:operator'])->prefix('operator')->group(function () {
    Route::get('/orders', [OperatorOrderController::class, 'index'])->name('operator.orders.index');
    Route::post('/orders', [OperatorOrderController::class, 'store'])->name('operator.orders.store');
    Route::get('/orders/create', [OperatorOrderController::class, 'create'])->name('operator.orders.create');
    Route::get('/orders/{order}', [OperatorOrderController::class, 'show'])->name('operator.orders.show');
    Route::put('/orders/{order}', [OperatorOrderController::class, 'update'])->name('operator.orders.update');
    Route::delete('/orders/{order}', [OperatorOrderController::class, 'destroy'])->name('operator.orders.destroy');
});

// HRD ROUTES
Route::middleware(['web', 'auth', 'role:hrd'])->prefix('hrd')->group(function () {
    Route::get('/dashboard', [HRDApprovalController::class, 'dashboard'])->name('hrd.dashboard');
    Route::get('/orders', [HRDApprovalController::class, 'index'])->name('hrd.orders.index');
    Route::post('/orders/{id}/approve', [HRDApprovalController::class, 'approve'])->name('hrd.orders.approve');
});

// SECURITY ROUTES
Route::middleware(['web', 'auth', 'role:security'])->prefix('security')->group(function () {
    Route::get('/monitoring', [SecurityMonitoringController::class, 'index'])->name('security.monitoring.index');
});
Route::get('/security/monitoring/print', [App\Http\Controllers\Security\MonitoringController::class, 'printPdf'])->name('monitoring.print');
Route::post('/hrd/orders/bulk-approve', [App\Http\Controllers\HRD\ApprovalController::class, 'bulkApprove'])
    ->name('hrd.orders.bulkApprove');
Route::delete('/hrd/orders/{id}', [HRDApprovalController::class, 'destroy'])->name('hrd.orders.destroy');
// LOAD AUTH ROUTES
require __DIR__.'/auth.php';