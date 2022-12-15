<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(): JsonResponse
    {
        $data = [
            'notifications' => Notification::where('user_id', '=', jwtUser()->id)
            ->where('sender_id', '!=', jwtUser()->id)->with('sender')
            ->orderBy('created_at', 'desc')
            ->get()
        ];

        return response()->json($data);
    }
    public function update(): JsonResponse
    {
        $data = Notification::where('user_id', '=', jwtUser()->id)
        ->where('sender_id', '!=', jwtUser()->id)
        ->update(['seen' => 1]);

        return response()->json($data);
    }
}
