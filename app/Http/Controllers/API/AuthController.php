<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 24/11/18
 * Time: 01:38
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Usuario;

class AuthController
{
    /**
     * Create user
     *
     * @param  [string] nome
     * @param  [string] sobrenome
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] deficiente
     * @return [string] mensagem
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'sobrenome' => 'required|string',
            'email' => 'required|email|unique:usuario',
            'password' => 'required',
//            'c_password' => 'required|same:password',
            'deficiente' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        if ($usuario = Usuario::create($input)) {
            return response()->json([
                'mensagem' => 'Usuário registrado com sucesso'
            ], 201);
        }
        return response()->json([
            'mensagem' => 'Não foi possível cadastrar o usuário'
        ], 500);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
//            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token()->revoke();

        if ($token) {
            return response()->json([
                'mensagem' => 'desconectado com sucesso',
            ], 200);
        }
        return response()->json([
            'mensagem' => 'não foi possível desconectar',
        ], 500);
    }
}