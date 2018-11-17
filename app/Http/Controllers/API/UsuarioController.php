<?php

namespace App\Http\Controllers\API;

use Illuminate\Console\Parser;
use Illuminate\Support\Facades\DB;
use App\Usuario;
use App\PasswordReset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_blind()
    {
        $users = DB::table('usuario')->where('deficiente', '=', 1)->count();

        return response()->json([
            'mensagem' => 'Usuário cegos',
            'usuarios' => $users
        ], 200);
    }

    public function get_noblind()
    {
        $users = DB::table('usuario')->where('deficiente', '=', 0)->count();

        return response()->json([
            'mensagem' => 'Usuário não cegos',
            'usuarios' => $users
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->all();
        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if (Auth()->user()->update($data)) {
            return response()->json([
                'mensagem' => 'Dados atualizados com sucesso',
            ], 200);
        }

        return response()->json([
            'mensagem' => 'Não foi possível atualizar os dados',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        $value = $request->bearerToken();
        $token = $request->user()->token()->revoke(); // all devices

        if ($token) {
            return response()->json([
                'mensagem' => 'Deslogado com sucesso',
            ], 200);
        }
        return response()->json([
            'mensagem' => 'Não funcionou',
        ], 200);
    }

    public function destroy(Usuario $usuario)
    {
        $delete = Auth()->user()->delete();

        if ($delete) {
            return response()->json([
                'mensagem' => 'Usuário deletado com sucesso'
            ], 200);
        }
        return response()->json([
            'mensagem' => 'Erro na aplicação'
        ], 200);

    }
}