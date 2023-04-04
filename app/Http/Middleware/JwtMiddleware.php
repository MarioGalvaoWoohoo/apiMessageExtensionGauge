<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token inválido', 'status' => 401], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token expirado', 'status' => 401], 401);
            } else {
                return response()->json(['error' => 'Token de autenticação não encontrado', 'status' => 401], 401);
            }
        }


        return $next($request);
    }
}

