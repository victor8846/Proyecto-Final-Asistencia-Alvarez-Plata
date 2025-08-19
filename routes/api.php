<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NfcLecturaController;
use App\Http\Controllers\Api\NfcController;

// Rutas para el registro y manejo de NFC

    // POST → usado por el dispositivo
Route::post('/nfc-lectura', [NfcController::class, 'registrarLectura']);

// GET → para pruebas rápidas desde navegador/Postman
Route::get('/nfc-lectura', [NfcController::class, 'registrarLecturaGet']);
    Route::get('/nfc-lectura/ultimo', [NfcLecturaController::class, 'ultimoUid']);
    Route::post('/nfc-lectura/confirmar', [NfcLecturaController::class, 'confirmar']);
Route::get('/nfc-lectura/pendientes', [NfcController::class, 'pendientes']); // JS consulta UID pendiente
Route::post('/nfc-lectura/confirmar', [NfcController::class, 'confirmar']); // JS confirma UID





Route::post('/nfc-lectura', [NfcController::class, 'registrarLectura']);
Route::get('/nfc-lectura/ultimo', [NfcController::class, 'ultimo']);
Route::post('/nfc-lectura/confirmar', [NfcController::class, 'confirmar']);
