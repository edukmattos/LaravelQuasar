<?php

namespace App\Api\V1\Controllers\Auth;

use Auth;
use Carbon\Carbon;
#use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\JWTAuth;
use Dingo\Api\Routing\Helpers;
#use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\MessageBag;
use App\Mail\AccountActivationMail;
use App\Http\Controllers\Controller;
#use App\Api\V1\Transformers\CompanyTransformer;
use Illuminate\Support\Facades\Mail;
use App\Api\V1\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Api\V1\Transformers\UserTransformer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginController extends Controller
{
    use Helpers;
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = Auth::guard()->attempt($credentials);

            ##dd(Auth::guard()->attempt($credentials));

            if(!$token) {
                $bag = new MessageBag();
                $bag->add('email', 'Inexistente ou ...');
                $bag->add('password', '... incorreta.');

                return response()->json([
                    'message' => '422 Unprocessable Entity',
                    'errors' => $bag,
                    'status_code' => 422
                ], 422);
            }

            $user = auth()->user();

            if($user->email_verified_at)
            {
                $user->token = $token;
                $user->type = 'bearer';
                $user->expires_in = auth()->factory()->getTTL() * env('JWT_TTL');
            
                #$companies = $user->companies;

                return $this->response->item($user, new UserTransformer);
            }
            else
            {
                $bag = new MessageBag();
                $bag->add('email', 'Conta pendente de confirmação');
                $bag->add('password', 'Verifique seu e-mail e/ou caixa de Spam.');

                $details = [
                    'level' => 'success',
                    'greeting' => 'Olá',
                    'salution' => 'Salution',
                    'initial_lines' => [],
                    'middle_lines'  => [
                        'Tudo bem ?  <br/> ',
                        ' <br/> ',
                        'Verificamos um acesso a sua conta no '.config('app.name').' e, atualmente, ela encontra-se pendente de confirmação. <br/> ',
                        'Portanto, para permitirmos o seu acesso, é importante que confirme a sua conta de e-mail clicando no botão abaixo:'
                    ],
                    'button_text' => 'Confirmar E-mail',
                    'button_color' => 'primary',
                    'button_url' => env('APP_URL_QUASAR').'/#/user/activation/'.$user->email.'/'.$user->activation_code,
                    'end_lines' => [],
                    'expires_at' => Carbon::now()->addMinutes(1)
                ];

                Mail::to($user->email)
                ->send(new AccountActivationMail($user, $details));
                
                return response()->json([
                    'message' => '422 Unprocessable Entity',
                    'errors' => $bag,
                    'status_code' => 422
                ], 422);
            }           
        } catch (JWTException $e) {
            throw new HttpException(500);
        }
    }
}