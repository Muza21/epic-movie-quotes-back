<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

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
