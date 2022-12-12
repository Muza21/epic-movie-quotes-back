<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovielistSearchRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchMovieList(MovielistSearchRequest $request): JsonResponse
    {
        $validation = $request->validated();

        $movie = Movie::latest()
        ->where('title', 'like', '%' . $validation['text'] . '%')->get();
        // ->orwhere('name->ka', 'like', '%' . request('search') . '%')
        return response()->json($movie);
    }
}
