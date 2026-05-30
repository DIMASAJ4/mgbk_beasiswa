<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the custom login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle the custom login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            if ($user->hasRole('Admin')) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->hasRole('Guru BK')) {
                return redirect()->intended('/guru/dashboard');
            } elseif ($user->hasRole('Siswa')) {
                return redirect()->intended('/siswa/dashboard');
            }

            // Default fallback
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
