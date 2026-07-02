<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminVerificationController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/verificaciones/{verification}', [AdminVerificationController::class, 'show'])->name('admin.verifications.show');
        Route::post('/admin/verificaciones/{verification}/aprobar', [AdminVerificationController::class, 'approve'])->name('admin.verifications.approve');
        Route::post('/admin/verificaciones/{verification}/rechazar', [AdminVerificationController::class, 'reject'])->name('admin.verifications.reject');
    });
    Route::middleware('role:cliente')->group(function () {
        Route::view('/cliente', 'dashboards.cliente')->name('cliente.dashboard');
        Route::view('/cliente/solicitudes', 'dashboards.cliente.solicitudes')->name('cliente.solicitudes');
        Route::view('/cliente/conductores', 'dashboards.cliente.conductores')->name('cliente.conductores');
        Route::view('/cliente/seguimiento', 'dashboards.cliente.seguimiento')->name('cliente.seguimiento');
    });
    Route::view('/conductor', 'dashboards.conductor')->middleware('role:conductor')->name('conductor.dashboard');
});
