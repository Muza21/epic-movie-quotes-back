<?php

namespace App\Http\Controllers;

use App\Events\LikeEvent;
use App\Http\Requests\ReactionRequest;
use App\Models\Quote;
use App\Models\Reaction;
use Illuminate\Http\JsonResponse;

class ReactionController extends Controller
{
    public function like(ReactionRequest $request, Quote $quote): JsonResponse
    {
        $validation = $request->validated();

        if (!$quote->isAuthUserLikedQuote()) {
            $like = $quote->likes()->create([
                'user_id'  => $validation['user_id'],
                'quote_id' => $validation['quote_id'],
            ]);
        } else {
            Reaction::where('user_id', '=', $validation['user_id'])->first()->delete();
        }
        // if (jwtUser()->id != $validation['user_id']) {
        //     $notification = Notification::create([
        //         'type'      => 'like',
        //         'user_id'   => $validation['user_id'],
        //         'sender_id' => jwtUser()->id,
        //     ]);
        //     event(new UserNotification($notification));
        // }
        $likes = Reaction::where('quote_id', '=', $quote->id)->get();
        event(new LikeEvent($likes));

        return response()->json($likes);
    }
}
