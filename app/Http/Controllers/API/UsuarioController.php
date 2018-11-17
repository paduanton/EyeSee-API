<?php

namespace App\Http\Controllers\API;

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

        Auth()->user()->update($data);
        
        return response()->json([
            'message' => 'Atualizado com sucesso',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {

    }
}