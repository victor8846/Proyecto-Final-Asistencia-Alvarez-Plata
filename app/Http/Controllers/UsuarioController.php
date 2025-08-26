<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\PasswordService;
use App\Notifications\NewUserCredentials;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('role')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
        ]);

        $password = PasswordService::generateRandomPassword();
        
        $user = User::create([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($password),
            'must_change_password' => true,
        ]);

        try {
            // Enviar correo con las credenciales
            $user->notify(new NewUserCredentials($password));

            return redirect()->route('usuarios.index')
                ->with('success', "Usuario {$user->name} creado exitosamente. La contraseña ha sido enviada al correo {$user->email}");
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')
                ->with('warning', "Usuario creado, pero hubo un problema al enviar el correo. Por favor, intente regenerar la contraseña.");
        }
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|confirmed|min:6',
        ]);

        try {
            $usuario->update([
                'name' => $request->name,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'password' => $request->password ? Hash::make($request->password) : $usuario->password,
            ]);

            $nombreCompleto = "{$usuario->name} {$usuario->apellido_paterno} {$usuario->apellido_materno}";
            return redirect()->route('usuarios.index')
                ->with('success', "Usuario {$nombreCompleto} actualizado exitosamente");
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Hubo un error al actualizar el usuario. Por favor, intente nuevamente.');
        }
    }

    public function destroy(User $usuario)
    {
        try {
            $nombreCompleto = "{$usuario->name} {$usuario->apellido_paterno} {$usuario->apellido_materno}";
            $usuario->delete();
            
            return redirect()->route('usuarios.index')
                ->with('success', "Usuario {$nombreCompleto} eliminado exitosamente");
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Hubo un error al eliminar el usuario. Por favor, intente nuevamente.');
        }
    }
}
