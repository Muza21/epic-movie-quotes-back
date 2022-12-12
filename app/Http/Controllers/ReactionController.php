<?php

namespace App\Http\Controllers;

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
            $quote->likes()->create([
                'user_id'  => $validation['user_id'],
                'quote_id' => $validation['quote_id'],
            ]);
        } else {
            Reaction::where('user_id', '=', $validation['user_id'])->first()->delete();
        }
        $likes = Reaction::where('quote_id', '=', $quote->id)->get();
        return response()->json($likes);
    }
}
