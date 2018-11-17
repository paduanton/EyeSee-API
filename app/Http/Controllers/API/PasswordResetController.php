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
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Usuario;
use App\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{

    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */

    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = Usuario::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => 'Não foi possível achar um usuário com esse endereço de email'
            ], 404);

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            'mensagem' => 'Te enviamos um email com link para restaurar senha'
        ]);

    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid . '
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid . '
            ], 404);
        }
        return response()->json($passwordReset);
    }

    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required | string | email',
            'password' => 'required | string | confirmed',
            'token' => 'required | string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid . '
            ], 404);
        $user = Usuario::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $email = DB::table('usuario')->where('email', '=', $request->email)->exists();
        if (!$email)
            return response()->json([
                'message' => 'Não foi possível achar um usuário com esse endereço de email'
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