<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(ForgotPasswordRequest $request): JsonResponse
    {
        $validation = $request->validated();
        $data = [
            'email'=> $validation['email'],
            'token'=> Str::random(60),
        ];
        Mail::to($data['email'])->send(new ResetPassword($data));
        return response()->json(['message' => 'success'], 200);
    }

    public function update(ResetPasswordRequest $request): JsonResponse
    {
        $validation = $request->validated();
        User::where('email', $validation['email'])->update([
            'password' => bcrypt($validation['password']),
        ]);
        return response()->json(['message' => 'success'], 200);
    }
}
