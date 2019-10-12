<?php

namespace App\Api\V1\Controllers;

#use Symfony\Component\HttpKernel\Exception\HttpException;
use Auth;
use Tymon\JWTAuth\JWTAuth;
#use App\Api\V1\Requests\Auth\LoginRequest;
#use Tymon\JWTAuth\Exceptions\JWTException;
#use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Dingo\Api\Routing\Helpers;

use App\Http\Controllers\Controller;
use App\Api\V1\Transformers\UserTransformer;
use App\Api\V1\Transformers\CompanyTransformer;

class UserController extends Controller
{
    use Helpers;
    
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        #return response()->json(Auth::guard()->user());

        $user = Auth::guard()->user();

        #if (request()->wantsJson()) {
            return $this->response->item($user, new UserTransformer);
        #}
    }

    public function myCompanies()
    {
        $user = Auth::guard()->user();
        
        $companies = $user->companies;

        #dd($companies);

        return $this->response->collection($companies, new CompanyTransformer);
    }

}
