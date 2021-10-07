<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse
    {
        return response()->json(User::create($request->all()));
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        if(!auth()->attempt($credentials)){
            return response()
                ->setStatusCode(404)
                ->json([
                    'message' => 'The given data is invalid',
                    'errors' => [
                        'email' => 'wrong email',
                        'password' => 'wrong password'
                    ]
                ]);
        }

        $user = User::query()->where('email', $request->email)->first();
        return response()->json(['message' => $user->createToken('auth-token')->plainTextToken]);
    }
}
