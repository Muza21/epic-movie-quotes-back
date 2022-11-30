<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
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
                'username'     => $user->username,
                'id'           => $user->id,
                'token'        => sha1($user->email),
            ];
        }

        Mail::to($user->email)->locale(App::currentLocale())->send(
            new VerifyMail($data)
        );
        return response()->json(['message' => 'user created successfully'], 201, $data);
    }
}
