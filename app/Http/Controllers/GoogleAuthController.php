<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $searchUser = User::where('email', $googleUser->email)->get()->first();

            if ($searchUser) {
                $payload = [
                    'exp' => Carbon::now()->addMinute(30)->timestamp,
                    'uid' => $searchUser->id,
                ];

                $jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

                $cookie = cookie("access_token", $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');
                return response()->json('success', 200)->withCookie($cookie);
            } else {
                $user = User::create([
                    'username'  => $googleUser->name,
                    'email'     => $googleUser->email,
                    'password'  => encrypt('12345678'),
                    'thumbnail' => $googleUser->avatar,
                ]);
                $payload = [
                    'exp' => Carbon::now()->addMinute(30)->timestamp,
                    'uid' => $user->id,
                ];

                $jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');
                $cookie = cookie("access_token", $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');
                return response()->json('success', 200)->withCookie($cookie);
            }
        } catch(Exception $err) {
            dd($err->getMessage());
        }
    }
}
