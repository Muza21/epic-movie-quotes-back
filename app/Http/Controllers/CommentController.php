<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCommentRequest;
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
        return response()->json($comment->load('user'));
    }
}
