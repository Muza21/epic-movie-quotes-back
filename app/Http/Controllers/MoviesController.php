<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieStoreRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function store(MovieStoreRequest $request): JsonResponse
    {
        $validation = $request->validated();

        // dd($validation['genre']);

        Movie::create([
            'title'        => $validation['movie_name_en'],
            'director'     => $validation['director_name_en'],
            'genre'        => $validation['genre'],
            'year'         => $validation['year'],
            'budget'       => $validation['budget'],
            'description'  => $validation['movie_description_en'],
            'thumbnail'    => $validation['movie_picture']->store('thumbnail'),
        ]);

        return response()->json(['message' => 'movie stored successfully'], 200);
    }
}
