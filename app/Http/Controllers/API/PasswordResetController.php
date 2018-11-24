<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 17/11/18
 * Time: 15:57
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $email = DB::table('usuario')->where('email', '=', $request->email)->exists();
        if (!$email)
            return response()->json([
                'mensagem' => 'Não foi possível achar um usuário com esse endereço de email'
            ], 404);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response)) {

            return response()->json([
                'mensagem' => 'Foi enviado um email para você com link para restaurar senha',
            ], 200);
        }

        return response()->json([
            'mensagem' => 'Erro ao enviar email',
        ], 200);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    public function broker()
    {
        return Password::broker();
    }

}