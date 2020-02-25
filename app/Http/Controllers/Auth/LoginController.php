<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function authenticate(Request $request)
    { 

      $request->validate([
        'username' => 'required',
        'password' => 'required'
      ]);

      $user = User::where('username', $request->username)->first();

      if (!Hash::check($request->password, $user->password)) {
        # code...
        return response()->json([
          'status' => 'Fail',
          'message' => 'Wrong username or password!'
        ], 401);
      } 

      $token = $user->createToken('appraisal')->accessToken;

      return $this->respondWithToken($token);

    }

    public function logout()
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
          'status' => 'Success',
          'message' => 'Successfully logged out'
        , 200]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
        ]);
    }
}
