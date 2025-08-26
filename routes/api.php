<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NfcLecturaController;
use App\Http\Controllers\Api\NfcController;

// Rutas para el registro y manejo de NFC
Route::post('/nfc-lectura', [NfcLecturaController::class, 'registrarLectura']);
Route::get('/nfc-lectura/ultimo', [NfcLecturaController::class, 'ultimoUid']);
Route::post('/nfc-lectura/confirmar', [NfcLecturaController::class, 'confirmar']);
