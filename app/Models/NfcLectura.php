<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NfcLectura extends Model
{
    protected $table = 'nfc_lecturas';

    protected $fillable = [
        'uid_nfc', 'lector', 'confirmado'
    ];

    protected $casts = [
        'confirmado' => 'boolean',
    ];
}

