<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function verMenu()
    {
        return view('menuPrincipal');
    }
 
    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'El campo de correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe tener un formato válido.',
        'password.required' => 'El campo de contraseña es obligatorio.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return redirect()->back()->with('error', 'Credenciales inválidas');
    }

    return redirect()->route('menuPrincipal');
}

public function logout()
{
    // Elimina el token almacenado en la sesión
    session()->forget('remote_token');

    Auth::logout();

    return redirect()->route('login');
}
}
