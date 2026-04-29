<?php

use App\Http\Controllers\ClientDocumentRequestController;
use App\Http\Controllers\ClientProfileController;
use App\Livewire\ScheduleAppointment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/agendar-cita', ScheduleAppointment::class)
    ->name('appointments.schedule');

Route::get('/cliente/{client}/imprimir', [ClientProfileController::class, 'downloadPdf'])
    ->name('cliente.imprimir');

Route::get('/cliente/{client}/editar-perfil', [ClientProfileController::class, 'edit'])
    ->name('cliente.editar-perfil');

Route::post('/cliente/{client}/editar-perfil', [ClientProfileController::class, 'update'])
    ->name('cliente.editar-perfil.update');

Route::get('/cliente/{client}/documentos', [ClientDocumentRequestController::class, 'create'])
    ->name('cliente.documentos');

Route::get('/cliente/{client}/imprimir', [ClientProfileController::class, 'downloadPdf'])
    ->name('cliente.imprimir');

Route::post('/cliente/{client}/documentos', [ClientDocumentRequestController::class, 'store'])
    ->name('cliente.documentos.store');
