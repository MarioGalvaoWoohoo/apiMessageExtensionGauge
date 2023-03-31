<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }

        $sessionId = $this->authService->authenticateUser($request->email, $request->password);

        if (!$sessionId) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        return response()->json(
            [
                'session_id' => $sessionId,
                'user_logged' => new UserResource(auth()->user())
            ]);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        $sessionId = session()->getId();
        $this->authService->invalidateSession($sessionId);

        return response()->json(['message' => 'Logout efetuado com sucesso.'], 200);
    }
}
