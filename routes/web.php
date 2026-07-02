<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\ClientDriverController;
use App\Http\Controllers\ClientMessageController;
use App\Http\Controllers\ClientTrackingController;
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
        Route::get('/cliente/conductores', [ClientDriverController::class, 'index'])->name('cliente.conductores');
        Route::get('/cliente/conductores/mejor', [ClientDriverController::class, 'best'])->name('cliente.conductores.best');
        Route::post('/cliente/conductores/{driver}/favorito', [ClientDriverController::class, 'favorite'])->name('cliente.conductores.favorite');
        Route::post('/cliente/conductores/{driver}/solicitar', [ClientDriverController::class, 'requestService'])->name('cliente.conductores.request');
        Route::post('/cliente/conductores/{driver}/mensaje', [ClientDriverController::class, 'message'])->name('cliente.conductores.message');
        Route::post('/cliente/conductores/{driver}/reportar', [ClientDriverController::class, 'report'])->name('cliente.conductores.report');
        Route::get('/cliente/seguimiento', [ClientTrackingController::class, 'index'])->name('cliente.seguimiento');
        Route::get('/cliente/seguimiento/en-vivo', [ClientTrackingController::class, 'live'])->name('cliente.seguimiento.live');
        Route::get('/cliente/mensajes', [ClientMessageController::class, 'index'])->name('cliente.mensajes');
        Route::get('/cliente/mensajes/{conversation}', [ClientMessageController::class, 'show'])->name('cliente.mensajes.show');
        Route::post('/cliente/mensajes/{conversation}', [ClientMessageController::class, 'send'])->name('cliente.mensajes.send');
        Route::post('/cliente/mensajes/{conversation}/archivo', [ClientMessageController::class, 'upload'])->name('cliente.mensajes.upload');
        Route::post('/cliente/mensajes/{conversation}/ubicacion', [ClientMessageController::class, 'location'])->name('cliente.mensajes.location');
        Route::view('/cliente/pagos', 'dashboards.cliente.pagos')->name('cliente.pagos');
        Route::view('/cliente/historial', 'dashboards.cliente.historial')->name('cliente.historial');
        Route::view('/cliente/calificaciones', 'dashboards.cliente.calificaciones')->name('cliente.calificaciones');
        Route::view('/cliente/notificaciones', 'dashboards.cliente.notificaciones')->name('cliente.notificaciones');
        Route::view('/cliente/perfil', 'dashboards.cliente.perfil')->name('cliente.perfil');
        Route::view('/cliente/seguridad', 'dashboards.cliente.seguridad')->name('cliente.seguridad');
        Route::view('/cliente/configuracion', 'dashboards.cliente.configuracion')->name('cliente.configuracion');
    });
    Route::view('/conductor', 'dashboards.conductor')->middleware('role:conductor')->name('conductor.dashboard');
});
