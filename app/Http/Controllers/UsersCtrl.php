<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Users;

class UsersCtrl extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    //
    public function authenticate(Request $request)
    {
      $this->validate($request, [
        'email' => 'required',
        'password' => 'required'
      ]);

      $user = Users::where('email', $request->input('email'))->first();

      if (Hash::check($request->input('password'), $user->password)) {
        # code...
        $apikey = base64_encode(str_random(40));
        Users::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);
        return response()->json([
          'status' => 'Success',
          'apikey' => $api
        ]);
      } else {
        return response()->json([
          'status' => 'fail'
        ], 401);
      }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(Request $request)
    {      
      $this->validate($request, [
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
      ]);

        return User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => Hash::make($data['password'])
        ]);
    }

}