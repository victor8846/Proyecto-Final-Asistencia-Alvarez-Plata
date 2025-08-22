<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   // 👈 falta importar Request
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;          // 👈 falta importar tu modelo User

class UserManagementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)   // mínimo 8 caracteres
                    ->letters()    // debe incluir letras
                    ->numbers()    // debe incluir números
                    ->symbols()    // debe incluir símbolos
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
        // Enviar correo de verificación
        $user->sendEmailVerificationNotification();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente. Se envió un correo de verificación.');
    }

    
}
            