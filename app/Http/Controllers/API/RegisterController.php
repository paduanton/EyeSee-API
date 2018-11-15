<?php
/**
 * Created by PhpStorm.
 * Usuario: antonio
 * Date: 15/11/18
 * Time: 19:43
 */


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as Validator;


class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        /*$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }*/


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Usuario::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['nome'] = $user->nome;


        return $this->sendResponse($success, 'Usuario register successfully.');
    }
}