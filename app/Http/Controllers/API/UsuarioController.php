<?php

namespace App\Http\Controllers\API;

use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $usuario = Auth()->user();
        return response()->json([
            'usuario' => $usuario,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
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

        $update = Auth()->user()->update($data);
        return response()->json([
            'mensagem' => 'Usuário atualizado com sucesso'
        ], 200);

//        if ($update) {
//            return response()->json([
//                'mensagem' => 'Usuário atualizado com sucesso'
//            ], 200);
//        }
//        return response()->json([
//            'menssagem' => 'Erro ao atualizar'
//        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        $delete = Auth()->user()->delete();

        return response()->json([
            'mensagem' => 'Notícia deletada com sucesso'
        ], 200);
    }
}
