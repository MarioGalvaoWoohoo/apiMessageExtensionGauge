<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
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

            session(['user' => $user]);
            session(['isLoggedIn' => true]);

            return redirect()->route('home');
        }

        return redirect()->route('login')->withErrors(['error' => 'Login inválido']);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser(Auth::user());
            return response()->json([
                'token' => $token,
                'user' => new UserResource($user)
            ]);
        }

        return response()->json(['error' => 'Login e/ou senha inválidos', 'status' => 401], 401);
    }

    public function logoutApp(Request $request): RedirectResponse
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Logout realizado com sucesso', 'status' => 200], 200);
        } catch (JWTException $exception) {
            return response()->json(['error' => 'Falha ao fazer logout, tente novamente.'], 500);
        }
    }
}
