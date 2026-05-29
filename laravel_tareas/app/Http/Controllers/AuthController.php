<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegistro()
    {
        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:100'],
            'email'             => ['required', 'email', 'max:150', 'unique:users,email'],
            'password'          => ['required', 'string', 'min:6'],
            'confirmar_password' => ['required', 'same:password'],
        ], [
            'name.required'              => 'El campo nombre es obligatorio.',
            'email.required'             => 'El campo email es obligatorio.',
            'email.email'                => 'El campo email debe ser un correo válido.',
            'email.unique'               => 'Este correo ya está registrado.',
            'password.required'          => 'El campo contraseña es obligatorio.',
            'password.min'               => 'El campo contraseña debe tener al menos 6 caracteres.',
            'confirmar_password.required' => 'El campo confirmar contraseña es obligatorio.',
            'confirmar_password.same'     => 'El campo confirmar contraseña no coincide.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('flash_success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'El campo email es obligatorio.',
            'email.email'       => 'El campo email debe ser un correo válido.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors(['login' => 'Credenciales incorrectas. Intenta de nuevo.'])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('tareas.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
