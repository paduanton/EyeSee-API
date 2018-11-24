<?php

namespace App\Http\Controllers\API;

use Illuminate\Console\Parser;
use Illuminate\Support\Facades\DB;
use App\Usuario;
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
            'mensagem' => 'usuário cegos',
            'usuarios' => $users
        ], 200);
    }

    public function get_noblind()
    {
        $users = DB::table('usuario')->where('deficiente', '=', 0)->count();

        return response()->json([
            'mensagem' => 'usuários não cegos',
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
                'mensagem' => 'dados atualizados com sucesso',
            ], 200);
        }

        return response()->json([
            'mensagem' => 'não foi possível concluir a operação',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        $token = $request->user()->token()->revoke(); // all devices

        if ($token) {
            return response()->json([
                'mensagem' => 'desconectado com sucesso',
            ], 200);
        }
        return response()->json([
            'mensagem' => 'não foi possível desconectar',
        ], 500);
    }

    public function destroy(Usuario $usuario)
    {
        $delete = Auth()->user()->delete();

        if ($delete) {
            return response()->json([
                'mensagem' => 'cadastro deletado com sucesso'
            ], 200);
        }
        return response()->json([
            'mensagem' => 'error 500'
        ], 500);

    }
}