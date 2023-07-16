<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthAppController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginApp(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Auth::login($user);
            session(['user' => $user]);
            session(['isLoggedIn' => true]);

            return redirect()->route('home');
        }

        return redirect()->route('login')->withErrors(['error' => 'Login inválido']);
    }

    public function logoutApp(Request $request): RedirectResponse
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
