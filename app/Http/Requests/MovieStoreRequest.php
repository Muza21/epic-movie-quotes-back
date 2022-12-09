<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'movie_name_en' => 'required|alpha',
            'movie_name_ka' => 'required',
            'director_name_en' =>'required|alpha',
            'director_name_ka' =>'required',
            'genre' => 'required',
            'year' =>'required|integer',
            'budget' =>'required|integer',
            'movie_description_en' => 'required',
            'movie_description_ka' => 'required',
            'movie_picture' => 'required|image',
        ];
    }
}
