<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\LoginService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $loginService;
    protected $userService;

    public function __construct(LoginService $loginService, UserService $userService)
    {
        $this->loginService = $loginService;
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        try {

            $validatedData = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $this->loginService->login($request->email, $request->password);

            return response()->json([
                'message' => 'Usuário logado com sucesso!',
                'data' => true,
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }




        $user = $this->loginService->login(
            $request->input('email'),
            $request->input('password')
        );

        if (!$user) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 200);
    }
}
