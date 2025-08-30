<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $fields = $request->validated();

        $fields['password'] = Hash::make($fields['password']);

        $fields['role'] = $fields['role'] ?? 'user'; 

        $user = User::create($fields);
 
        return response()->json([
            'message' => 'user created successfully',
            'user' => UserResource::make($user),
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
        ], 201);
    }
}
