<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class VerifyEmailController extends Controller
{
    public function verifyEmail(Request $request): JsonResponse
    {
        $user = User::find($request->id);

        if ($request->token === sha1($user->email)) {
            if (!$user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
        }

        return response()->json(['message' => 'user verified successfully'], 200);
    }
}
