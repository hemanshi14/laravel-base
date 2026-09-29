<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function attemptLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('login')->withErrors($e->errors());
        }

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return view('dashboard')->with('success', 'Welcome Back!');
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials.']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function attemptRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return view('dashboard');
    }

    public function dashboard()
    {
        if (auth()->check()) {
            return view('dashboard')->with('success', 'Welcome Back!');
        }

        return redirect()->route('login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
