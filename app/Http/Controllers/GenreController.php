<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function genres()
    {
        $data = [
            'genres' => Genre::all(),
            'user' => jwtUser(),
        ];

        return response()->json($data);
    }
}
