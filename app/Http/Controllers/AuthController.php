<?php

namespace App\Http\Controllers;

use App\Constants\Geral;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Credenciais inválidas. Verifique seu email e senha.',
            ], 401); 
        }

        $user = $request->user();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => Geral::USUARIO_LOGADO,
            'usuario' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();

            return ['status' => true, 'message' => Geral::USUARIO_DESLOGADO];
        }

        return response()->json([
            'status' => false, 
            'message' => 'Falha ao deslogar. Token não encontrado ou inválido.',
        ], 401);
    }
}