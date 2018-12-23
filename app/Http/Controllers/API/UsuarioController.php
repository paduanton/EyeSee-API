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

    public function index()
    {
        // Auth::user()->nome

        $user = [
            'id' => Auth::user()->getAuthIdentifier(),
            'nome' => Auth::user()->nome,
            'sobrenome' => Auth::user()->sobrenome,
            'email' => Auth::user()->email,
            'deficiente' => Auth::user()->deficiente,
            'criado_em' => Auth::user()->criado_em,
            'atualizado_em' => Auth::user()->atualizado_em
        ];

        return response()->json([
            'auth_user' => $user
        ], 200);
    }

    public function get_blind()
    {
        $count = DB::table('usuario')->where('deficiente', '=', true)->count();

        return response()->json([
            'mensagem' => 'cegos',
            'usuarios' => $count
        ], 200);
    }

    public function get_noblind()
    {
        $count = DB::table('usuario')->where('deficiente', '=', false)->count();

        return response()->json([
            'mensagem' => 'não cegos',
            'usuarios' => $count
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
            'mensagem' => 'não foi possível atualizar os dados',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario, Request $request)
    {
        $logout = $request->user()->token()->revoke();
        $delete = Auth()->user()->delete();

        if ($delete && $logout) {
            return response()->json([
                'mensagem' => 'cadastro deletado com sucesso'
            ], 200);
        }
        return response()->json([
            'mensagem' => 'error 500'
        ], 500);

    }
}