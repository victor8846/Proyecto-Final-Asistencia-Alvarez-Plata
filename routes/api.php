<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NfcController;

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});
Route::post('/nfc/register', [NfcController::class, 'registerUid'])
    ->middleware('api.key');