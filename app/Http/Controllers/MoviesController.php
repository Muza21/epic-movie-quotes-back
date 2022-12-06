<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieStoreRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function store(MovieStoreRequest $request)
    {
        $validation = $request->validated();

        Movie::create([
            'title'        => $validation['movie_name_en'],
            'director'     => $validation['director_name_en'],
            'description'  => $validation['movie_description_en'],
            // 'thumbnail'    => $validation['movie_picture'],
        ]);

        return response()->json(['message' => 'movie stored successfully'], 200);
    }

    // public function edit(Movie $movie): View
    // {
    // 	return view('admin.posts.edit-movie', [
    // 		'movie' => $movie,
    // 	]);
    // }

    // public function update(MovieStoreRequest $request, Movie $movie): RedirectResponse
    // {
    // 	$validation = $request->validated();
    // 	$movie->update([
    // 		'title'        => [
    // 			'en' => $validation['title_en'],
    // 			'ka' => $validation['title_ka'],
    // 		],
    // 	]);

    // 	return redirect(route('movies.index'))->with('success', 'Successfully Updated');
    // }

    // public function destroy(Movie $movie): RedirectResponse
    // {
    // 	$movie->delete();
    // 	return redirect(route('movies.index'))->with('success', 'Successfully Deleted');
    // }
}
