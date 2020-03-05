<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class AuthCtrl extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function authenticate(Request $request)
    { 

      $this->validate($request, [
        'username' => 'required',
        'password' => 'required'
      ]);

      $user = User::where('username', $request->input('username'))->first();

      if (Hash::check($request->input('password'), $user->password)) {
        # code...
        $apikey = base64_encode(Str::random(40));
        User::where('username', $request->input('username'))->update(['api_key' => "$apikey"]);

        return response()->json([
          'status' => 'Success',
          'apikey' => $apikey
        ]);
      } else {
        return response()->json([
          'status' => 'fail'
        ], 401);
      }

    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function adduser(Request $request)
    {      
      $this->validate($request, [
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
      ]);

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