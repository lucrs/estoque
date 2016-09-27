<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AuthRequest;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;


class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        // grab credentials from the request
        $credentials = $request->only('username', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return $this->getUser($token);

    }
    public function getUser($token)
    {
        $user = Auth::user();

        return compact ('token','user');
    }
}
