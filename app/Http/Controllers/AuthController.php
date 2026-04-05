<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    // ── Registro ──────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'telefono' => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol'      => 'cliente', // por defecto
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada. Inicia sesión.');
    }

    // ── Login ─────────────────────────────────────────────────

    public function showLogin()
    {
        $rememberedEmail = Cookie::get('remembered_email');
        return view('auth.login', compact('rememberedEmail'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credenciales incorrectas.']);
        }

        // Manejo de Cookie (Recordar Usuario)
        if ($request->has('remember')) {
            Cookie::queue('remembered_email', $request->email, 60 * 24 * 7); // 1 semana
        } else {
            Cookie::queue(Cookie::forget('remembered_email'));
        }

        // Guardar en sesión los datos requeridos
        session([
            'id_usuario' => $user->id,
            'nombre'     => $user->name,
            'rol'        => $user->rol,
        ]);

        return redirect()->route('dashboard');
    }

    // ── Logout ────────────────────────────────────────────────

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
