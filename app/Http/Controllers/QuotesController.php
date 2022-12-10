<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    public function store(QuoteStoreRequest $request): JsonResponse
    {
        $validation = $request->validated();

        Quote::create([
            'quote'       => $validation['quote_en'],
            'movie_id'    => Movie::where('title', '=', $validation['movie_title'])->first()->id,
            'thumbnail'   => $validation['quote_picture']->store('thumbnails'),
        ]);

        return response()->json(['message' => 'quote stored successfully'], 200);
    }

    public function quotes()
    {
        $data = ['quotes'=>Quote::all(),];

        return response()->json($data);
    }

    // public function update(QuoteUpdateRequest $request, Quote $quote): JsonResponse
    // {
    //     $validation = $request->validated();

    //     if (!isset($validation['thumbnail'])) {
    //         $validation['thumbnail'] = $quote->thumbnail;
    //     } else {
    //         File::delete('storage/' . $quote->thumbnail);
    //         $validation['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
    //     }
    //     $quote->update([
    //         'quote'        => [
    //             'en' => $validation['quote_en'],
    //             'ka' => $validation['quote_ka'],
    //         ],
    //         'movie_id'    => $validation['movie_id'],
    //         'thumbnail'   => $validation['thumbnail'],
    //     ]);

    //     return response()->json(['message' => 'quote updated successfully'], 200);
    // }

    // public function destroy(Quote $quote): JsonResponse
    // {
    //     $quote->delete();
    //     return response()->json(['message' => 'quote deleted successfully'], 200);
    // }
}
