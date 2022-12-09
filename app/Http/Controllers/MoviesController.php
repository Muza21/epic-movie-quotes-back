<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MoviesController extends Controller
{
    public function store(MovieStoreRequest $request): JsonResponse
    {
        $validation = $request->validated();

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

    public function update(MovieUpdateRequest $request, Movie $movie): JsonResponse
    {
        $validation = $request->validated();

        if (isset($validation['thumbnail'])) {
            File::delete('storage/' . $movie->thumbnail);
            $validation['thumbnail'] = $validation['thumbnail']->store('thumbnails');
        }
        $movie->update([
            'title'        => $validation['movie_name_en'],
            'director'     => $validation['director_name_en'],
            'genre'        => $validation['genre'],
            'year'         => $validation['year'],
            'budget'       => $validation['budget'],
            'description'  => $validation['movie_description_en'],
            'thumbnail'    => is_string($validation['movie_picture']) ? $movie->thumbnail : $validation['movie_picture']->store('thumbnail'),
        ]);

        return response()->json(['message' => 'movie updated successfully'], 200);
    }

    public function destroy(Movie $movie): JsonResponse
    {
        File::delete('storage/' . $movie->thumbnail);
        $movie->delete();

        return response()->json(['message' => 'movie deleted successfully'], 200);
    }

    public function movies()
    {
        $data = ['movies'=>Movie::all(),];

        return response()->json($data);
    }

    public function loadMovie(Movie $movie)
    {
        return response()->json($movie);
    }
}
