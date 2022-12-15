<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovielistSearchRequest;
use App\Http\Requests\NewsfeedSearchRequest;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    public function searchMovieList(MovielistSearchRequest $request): JsonResponse
    {
        $validation = $request->validated();

        $movie = Movie::latest()
        ->where('title->en', 'like', '%' . $validation['text'] . '%')
        ->orwhere('title->ka', 'like', '%' . $validation['text'] . '%')->get();


        return response()->json($movie);
    }

    public function searchNewsfeed(NewsfeedSearchRequest $request): JsonResponse
    {
        $validation = $request->validated();
        if (Str::startsWith($validation['text'], '@')) {
            $movie = Movie::latest()
            ->where('title->en', 'like', '%' . Str::after($validation['text'], '@') . '%')
            ->orwhere('title->ka', 'like', '%' . Str::after($validation['text'], '@') . '%')->get();
            $movie->load('quotes.user', 'quotes.comments.user', 'quotes.likes');
            $quote = $movie->pluck('quotes');
            $quotes = Arr::collapse($quote);
            return response()->json($quotes);
        } elseif (Str::startsWith($validation['text'], '#')) {
            $quotes = Quote::latest()
            ->where('quote->en', 'like', '%' . Str::after($validation['text'], '#') . '%')
            ->orwhere('quote->ka', 'like', '%' . $validation['text'] . '%')->get();
            return response()->json($quotes->load('user', 'comments.user', 'likes'));
        } else {
            $quotes = Quote::latest()
            ->where('quote->en', 'like', '%' . $validation['text'] . '%')
            ->orwhere('quote->ka', 'like', '%' . $validation['text'] . '%')->get();
            return response()->json($quotes->load('user', 'comments.user', 'likes'));
        }
    }
}
