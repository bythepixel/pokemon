<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $token = JWTAuth::attempt([
            'email' => $request->get('email'), 'password' => $request->get('password')
        ]);

        return response()->json(compact('token'));
    }
}
