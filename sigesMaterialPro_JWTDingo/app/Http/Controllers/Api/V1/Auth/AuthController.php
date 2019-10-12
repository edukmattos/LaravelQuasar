<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use App\Entities\User;

use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use Helpers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        #$this->middleware('guest')->except('logout');
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->all();

        if (!$token = auth()->attempt($credentials)) {
            
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

        $companies = $user->companies;
        
        return $this->respondWithToken($token, $user, $companies);
    }

    public function getUsers()
    {        
        $users = User::all();
        return $this->response->collection($users, new UserTransformer);
    }
    
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        #return response()->json(auth()->user());
        $user = auth()->user();

        return $this->response->collection($user, new UserTransformer);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user, $companies)
    {
        return response()
            ->json([
                'status' => 'ok',
                'access' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * env('JWT_TTL')
                ],
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role],
                'companies' => [
                    $companies
                ]
            ]);
    }

    #public function logout(Request $request) {
    #    Auth::logout();
    #    session()->flush();
    #    return redirect('/login');
    #}
}
