<?php

namespace App\Api\V1\Controllers\Auth;

use App\Api\V1\Entities\User;
use App\Http\Controllers\Controller;
use App\Api\V1\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ActivationController extends Controller
{
    use Helpers;
    
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {        
    }

    public function verify($email, $activation_code, JWTAuth $JWTAuth)
    {
        $user = User::where('email', $email)
            ->where('activation_code', $activation_code)
            #->whereNull('email_verified_at')
            ->first();
        
        if($user){
            $user->where('id', $user->id)->update(['email_verified_at' => now()]);

            $token = $JWTAuth->fromUser($user);

            $user->token = $token;
            $user->type = 'bearer';
            $user->expires_in = auth()->factory()->getTTL() * env('JWT_TTL');

            return $this->response->item($user, new UserTransformer);
        }
    }
}
