<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Requests\QuoteUpdateRequest;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class QuotesController extends Controller
{
    public function store(QuoteStoreRequest $request): JsonResponse
    {
        $validation = $request->validated();
        $movie = Movie::where('title', '=', $validation['movie_title'])->first();
        Quote::create([
            'quote'       => $validation['quote_en'],
            'movie_id'    => $movie->id,
            'thumbnail'   => $validation['quote_picture']->store('quote_thumbnails'),
        ]);
        $movie->quotes_number = $movie->quotes_number + 1;
        $movie->save();
        return response()->json(['message' => 'quote stored successfully'], 200);
    }

    public function update(QuoteUpdateRequest $request, Quote $quote): JsonResponse
    {
        $validation = $request->validated();

        if (isset($validation['quote_picture'])) {
            File::delete('storage/'.($quote->thumbnail));
        }
        $movie = Movie::where('title', '=', $validation['movie_title'])->first();
        $quote->update([
            'quote'       => $validation['quote_en'],
            'movie_id'    => $movie->id,
            'thumbnail'    => is_string($validation['quote_picture']) ? $quote->thumbnail : $validation['quote_picture']->store('quote_thumbnails'),
        ]);

        return response()->json(['message' => 'quote updated successfully'], 200);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        File::delete('storage/' . $quote->thumbnail);
        $quote->delete();
        $movie = Movie::where('id', '=', $quote->movie_id)->first();
        $movie->quotes_number = $movie->quotes_number - 1;
        $movie->save();

        return response()->json(['message' => 'quote deleted successfully'], 200);
    }

    public function quotes()
    {
        $data = ['quotes'=>Quote::all(),];

        return response()->json($data);
    }

    public function loadQuote(Quote $quote)
    {
        $movie = Movie::where('id', '=', $quote->movie_id)->first();
        $data = [
            'movie' => $movie,
            'quote' => $quote,
        ];
        return response()->json($data);
    }
}
