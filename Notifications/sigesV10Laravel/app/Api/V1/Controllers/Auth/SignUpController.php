<?php

namespace App\Api\V1\Controllers\Auth;

use Config;
use Carbon\Carbon;
use Tymon\JWTAuth\JWTAuth;
use App\Api\V1\Entities\User;
use App\Mail\AccountActivationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Api\V1\Requests\Auth\SignUpRequest;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $data = $request->all();
        $data['activation_code'] = sha1(time());

        $user = new User($data);
        
        if(!$user->save()) {
            throw new HttpException(422);
        }

        if(!Config::get('boilerplate.sign_up.release_token')) {
            #$user->markEmailAsVerified();

            $details = [
                'level' => 'success',
                'greeting' => 'Olá',
                'salution' => 'Salution',
                'initial_lines' => [],
                'middle_lines'  => [
                    'Tudo bem ?  <br/> ',
                    ' <br/> ',
                    'Recebemos a sua solicitacao de cadastro para utilizar '.config('app.name').' no periodo de testes. <br/> ',
                    'Para poder utilizar, é necessario que confirme a sua conta de e-mail clicando no botão abaixo: <br/> '
                ],
                'button_text' => 'Confirmar E-mail',
                'button_color' => 'primary',
                'button_url' => env('APP_URL_QUASAR').'/#/user/activation/'.$user->email.'/'.$user->activation_code,
                'end_lines'  => [
                    'Caso não tenha solicitado, favor desconsiderar este e-mail.'
                ],
                'expires_at' => Carbon::now()->addMinutes(1)
            ];

            #Notification::send($user, new AccountRegisteredNotification($details));
            
            Mail::to($user->email)
                ->send(new AccountActivationMail($user, $details));
            
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ], 201);
    }
}
