<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(15);
        return response()->json([
            'message' => 'users loaded',
            'users' => UserResource::collection($users)
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'message' => 'user fetched successfully',
            'user' => UserResource::make($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->validated());

        return response()->json([
            'message' => 'user updated successfully',
            'user' => UserResource::make($user)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'message' => 'user deleted successfully',
        ],200);
    }
}
