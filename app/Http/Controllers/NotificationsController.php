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
            ->get(),
            'unreadNotifications' => Notification::where('user_id', '=', jwtUser()->id)
            ->where('sender_id', '!=', jwtUser()->id)->where('seen', '=', 0)
            ->orderBy('created_at', 'desc')
            ->get()
        ];


        return response()->json($data);
    }
    public function update(): JsonResponse
    {
        Notification::where('user_id', '=', jwtUser()->id)
        ->where('sender_id', '!=', jwtUser()->id)
        ->update(['seen' => 1]);

        $data = [
            'notifications' => Notification::where('user_id', '=', jwtUser()->id)
            ->where('sender_id', '!=', jwtUser()->id)->with('sender')
            ->orderBy('created_at', 'desc')
            ->get(),
            'unreadNotifications' => [],
        ];
        return response()->json($data);
    }
}
