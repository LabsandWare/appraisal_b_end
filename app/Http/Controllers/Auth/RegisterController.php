<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;


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

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * 
     */
    protected function adduser(Request $request)
    {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {

          return response()->json([
            'status' => 'Error',
            'message' => $validator->messages()
          ]);
        }
         
        $user = User::create([
          'username' => $request->username,
          'email' => $request->email,
          'password' => Hash::make($request->password)
        ]);
        
        if ($user) {
          # code...
          Mail::raw('Account Succesfully Creaated Kindly Login, Using your credentials ', function ($message) use ($user)
          {
            $message->from('we@appraisal.com', 'Appraisal');
  
            $message->to($user->email)->subject('Welcome!');
          });
  
          return 
            response()->json([
              'status' => 'Success',
              'message' => 'Kindly Login'
            ]);
  
        } else {
          return response()->json([
            'status' => 'Error',
            'message' => 'Kindly singnup again'
          ]);
        }

    }

}
