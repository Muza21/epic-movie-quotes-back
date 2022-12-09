<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'quote_en'                 => 'required',
            'quote_ka'                 => 'required',
            'quote_picture'                => 'required|image',
            // 'movie_id'                 => 'required|exists:movies,id',
        ];
    }
}
