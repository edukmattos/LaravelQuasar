<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Foundation\Auth\RegistersUsers;

use Dingo\Api\Routing\Helpers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use Helpers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $credentials
     * @return \App\Entities\Userties\User
     */
    protected function register(RegisterRequest $request)
    {
        $credentials = $request->all();

        $credentials['password'] = Hash::make($credentials['password']);

        try {

            $user = User::create($credentials);

            $companies = $user->companies;
    
            $credentials['password'] = $credentials['password_confirmation'];
            
            if (auth()->validate($credentials)) {
                // credentials are valid
                $token = auth()->login($user);
                
                return $this->respondWithToken($token, $user, $companies);
            }
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            #return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }

    }

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
}
