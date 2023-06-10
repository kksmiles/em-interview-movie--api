<?php

namespace App\Http\Requests\MoviePictureController;

use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'path' => ['required', 'string'],
        ];
    }

    public function queryParameters()
    {
        return [
            'path' => [
                'description' => 'The path of the movie picture.',
                'example' => 'movies/1/1.jpg',
            ],
        ];
    }
}
