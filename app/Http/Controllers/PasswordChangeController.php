<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class PasswordChangeController extends Controller
{
    public function showChangeForm(): View
    {
        return view('auth.passwords.change');
    }

    public function change(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);

        $user = Auth::user();

        // Verificar la contraseña actual
        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        // Actualizar la contraseña
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
            'password_changed_at' => Carbon::now()
        ]);

        return redirect()->route('dashboard')->with('status', 'Contraseña actualizada correctamente.');
    }
}
