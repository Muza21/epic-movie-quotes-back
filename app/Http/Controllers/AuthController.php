<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        if ($user != null) {
            $data = [
                'id'           => $user->id,
                'token'        => sha1($user->email),
            ];
        }
        return response()->json(['message' => 'user created successfully'], 201, $data);
    }
}
