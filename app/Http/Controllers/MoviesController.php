<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class MoviesController extends Controller
{
    public function index()
    {
        $data = [
            'movies' => Movie::all(),
            'user'   => jwtUser(),
        ];

        return response()->json($data);
    }

    public function show(Movie $movie)
    {
        $quotes = Quote::where('movie_id', '=', $movie->id)->get();

        $data = [
            'movie' => $movie,
            'quotes' => $quotes->load('comments', 'likes'),
            'user' => jwtUser(),
        ];
        return response()->json($data);
    }

    public function store(MovieStoreRequest $request): JsonResponse
    {
        $validation = $request->validated();

        $movie = Movie::create([
            'title'        => [
                'en' => $validation['movie_name_en'],
                'ka' => $validation['movie_name_ka'],
            ],
            'director'        => [
                'en' => $validation['director_name_en'],
                'ka' => $validation['director_name_ka'],
            ],
            'description'        => [
                'en' => $validation['movie_description_en'],
                'ka' => $validation['movie_description_ka'],
            ],
            'genre'        => $validation['genre'],
            'year'         => $validation['year'],
            'budget'       => $validation['budget'],
            'thumbnail'    => $validation['movie_picture']->store('movie_thumbnails'),
        ]);

        return response()->json($movie);
    }

    public function update(MovieUpdateRequest $request, Movie $movie): JsonResponse
    {
        $validation = $request->validated();

        if (!is_string($validation['movie_picture'])) {
            File::delete('storage/'.($movie->thumbnail));
        }
        $movie->update([
            'title'        => [
                'en' => $validation['movie_name_en'],
                'ka' => $validation['movie_name_ka'],
            ],
            'director'        => [
                'en' => $validation['director_name_en'],
                'ka' => $validation['director_name_ka'],
            ],
            'description'        => [
                'en' => $validation['movie_description_en'],
                'ka' => $validation['movie_description_ka'],
            ],
            'genre'        => $validation['genre'],
            'year'         => $validation['year'],
            'budget'       => $validation['budget'],
            'thumbnail'    => is_string($validation['movie_picture']) ? $movie->thumbnail : $validation['movie_picture']->store('movie_thumbnails'),
        ]);

        return response()->json($movie);
    }

    public function destroy(Movie $movie): JsonResponse
    {
        File::delete('storage/' . $movie->thumbnail);
        $movie->delete();

        return response()->json(['message' => 'movie deleted successfully'], 200);
    }
}
