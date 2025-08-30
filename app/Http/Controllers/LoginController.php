<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request){

        $credentials = $request->validated();

        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'credentials invalidated'],401);
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ]);
        
    }
}
