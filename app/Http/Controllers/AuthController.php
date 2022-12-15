<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\VerifyMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::create([
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'password'  => bcrypt($validated['password']),
            'thumbnail' => config('auth.back_end_image_link') . "assets/Default_Profile_Picture.jpg"
        ]);
        if ($user != null) {
            $data = [
                'username' => $user->username,
                'id'       => $user->id,
                'token'    => sha1($user->email),
            ];
        }

        Mail::to($user->email)->send(new VerifyMail($data));
        return response()->json(['message' => 'user created successfully'], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validation = $request->validated();
        $getEmailOrUsername = filter_var($validation['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $authenticated = auth()->attempt(
            [
            $getEmailOrUsername => $validation['username'],
            'password'          => $validation['password']
            ],
            isset($validation['remember'])
        );

        if (!$authenticated) {
            return response()->json('wrong email or password', 401);
        }
        $minutes = isset($validation['remember']) ? 10000 : 30;


        $payload = [
            'exp' => Carbon::now()->addMinute($minutes)->timestamp,
            'uid' => User::where($getEmailOrUsername, '=', $validation['username'])->first()->id,
        ];

        $jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

        $cookie = cookie("access_token", $jwt, $minutes, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');
        return response()->json('success', 200)->withCookie($cookie);
    }

    public function logout(): JsonResponse
    {
        $cookie = cookie("access_token", '', 0, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

        return response()->json('success', 200)->withCookie($cookie);
    }

    public function checkAuthentication(): JsonResponse
    {
        return response()->json(
            [
                'message' => 'authenticated successfully',
                'user'    => jwtUser(),
            ],
            200
        );
    }

    public function currentUserData(): JsonResponse
    {
        $data = [
            'user'  => jwtUser(),
        ];
        return response()->json($data);
    }
}
