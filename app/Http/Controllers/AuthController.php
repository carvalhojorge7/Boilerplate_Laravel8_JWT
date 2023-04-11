<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => "campo obrigatório",
            'password.required' => "campo obrigatório"
        ]);

        if ($validator->fails()) {
            return response()->json(['mensagem' => 'Dados Inválidos', 'error' => $validator->messages()], 400);
        }

        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Não Autorizado'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logado()
    {
        $user = auth('api')->user();
        $response = User::with('foto_perfil:id,user_id,imagem_url,tipo_mime')->find($user->id);
        
        return response()->json($response);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['mensagem' => 'Deslogado com sucesso']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
