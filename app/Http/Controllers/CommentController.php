<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Events\UserNotification;
use App\Http\Requests\PostCommentRequest;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function post(PostCommentRequest $request, Quote $quote): JsonResponse
    {
        $validation = $request->validated();
        $comment = $quote->comments()->create([
            'user_id'  => $validation['user_id'],
            'body'     => $validation['body'],
            'quote_id' => $validation['quote_id'],
        ]);
        event(new CommentEvent($comment));
        if (jwtUser()->id != $request->reciver_id) {
            $notification = Notification::create([
                'type'      => 'comment',
                'user_id'   => $request->reciver_id,
                'sender_id' => jwtUser()->id,
            ]);
            event(new UserNotification($notification->load('sender')));
        }
        return response()->json($comment->load('user'));
    }
}
