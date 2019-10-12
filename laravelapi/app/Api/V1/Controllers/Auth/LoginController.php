<?php

namespace App\Api\V1\Controllers\Auth;

use Auth;
use Tymon\JWTAuth\JWTAuth;
#use Dingo\Api\Routing\Helpers;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
#use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Api\V1\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Api\V1\Transformers\UserTransformer;
#use App\Api\V1\Transformers\CompanyTransformer;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Dingo\Api\Routing\Helpers;

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

            $user->token = $token;
            $user->type = 'bearer';
            $user->expires_in = auth()->factory()->getTTL() * env('JWT_TTL');
            
            #dd($user);
            
            #$companies = $user->companies;

            return $this->response->item($user, new UserTransformer);
           
            
        } catch (JWTException $e) {
            throw new HttpException(500);
        }
    }
}