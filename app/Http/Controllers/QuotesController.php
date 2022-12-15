<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Requests\QuoteUpdateRequest;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class QuotesController extends Controller
{
    public function index()
    {
        $data = ['quotes' => Quote::all()->load('user', 'comments.user', 'likes')];
        return response()->json($data);
    }

    public function show(Quote $quote)
    {
        $movie = Movie::where('id', '=', $quote->movie_id)->first();
        $collectUser = User::where('id', '=', $quote->user_id)->first();
        $user = [
            'id'        => $collectUser->id,
            'username'  => $collectUser->username,
            'thumbnail' => $collectUser->thumbnail,
        ];
        $data = [
            'movie' => $movie,
            'quote' => $quote->load('comments.user', 'likes'),
            'user'  => $user,
            'currentUser' => jwtUser(),
        ];
        return response()->json($data);
    }

    public function store(QuoteStoreRequest $request): JsonResponse
    {
        $validation = $request->validated();
        $movie = Movie::where('id', '=', $validation['movie_id'])->first();
        $quote = Quote::create([
            'quote'        => [
                'en' => $validation['quote_en'],
                'ka' => $validation['quote_ka'],
            ],
            'movie_id'    => $validation['movie_id'],
            'thumbnail'   => $validation['quote_picture']->store('quote_thumbnails'),
            'user_id'     => $validation['user_id']
        ]);
        $movie->quotes_number = $movie->quotes_number + 1;
        $movie->save();
        return response()->json($quote->load('comments.user', 'likes', 'user'));
    }

    public function update(QuoteUpdateRequest $request, Quote $quote): JsonResponse
    {
        $validation = $request->validated();

        if (!is_string($validation['quote_picture'])) {
            File::delete('storage/'.($quote->thumbnail));
        }
        $movie = Movie::where('id', '=', $validation['movie_id'])->first();
        $quote->update([
            'quote'        => [
                'en' => $validation['quote_en'],
                'ka' => $validation['quote_ka'],
            ],
            'movie_id'     => $validation['movie_id'],
            'thumbnail'    => is_string($validation['quote_picture']) ? $quote->thumbnail : $validation['quote_picture']->store('quote_thumbnails'),
            'user_id'      => $validation['user_id']
        ]);

        return response()->json($quote);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        File::delete('storage/' . $quote->thumbnail);
        $deletedQuote = $quote;
        $quote->delete();
        $movie = Movie::where('id', '=', $quote->movie_id)->first();
        $movie->quotes_number = $movie->quotes_number - 1;
        $movie->save();

        return response()->json($deletedQuote);
    }
}
