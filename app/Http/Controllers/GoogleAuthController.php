<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback()
    {
    }
}
