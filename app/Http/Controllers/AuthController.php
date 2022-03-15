<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $data = $request->validated();

        if (auth()->attempt($data)) {
            $user = auth()->user();
            $token =  $user->createToken('auth-token')->plainTextToken;

            $data = [
                'token' => $token
            ];

            return $this->successResponse($data, 'User logged-in!');
        }

        return $this->errorResponse(401, 'Unauthorised');
    }

    public function register(AuthRegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::query()->create($data);

        return $this->successResponse($user, 'User successfully registered!');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse(null, 'The token has been deleted');
    }
}
