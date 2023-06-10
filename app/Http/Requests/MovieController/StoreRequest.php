<?php

namespace App\Http\Requests\MovieController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'length_in_seconds' => ['required', 'numeric', 'min:0', 'max:86400'],
            'released_at' => ['sometimes', 'date'],
            'available_until' => ['sometimes', 'date'],

            'pictures' => ['sometimes', 'array'],
            'pictures.*' => ['required', 'array'],
            'pictures.*.title' => ['required', 'string', 'max:255'],
            'pictures.*.description' => ['required', 'string', 'max:1000'],
            'pictures.*.order' => ['required', 'numeric', 'min:0', 'max:100'],
            'pictures.*.image' => ['required', 'image', 'max:10240'],

            'category_ids' => ['sometimes', 'array'],
            'category_ids.*' => ['required', 'numeric', 'exists:categories,id'],
            'tag_ids' => ['sometimes', 'array'],
            'tag_ids.*' => ['required', 'numeric', 'exists:tags,id'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'title' => [
                'description' => 'The title of the movie.',
                'example' => 'The Matrix',
            ],
            'description' => [
                'description' => 'The description of the movie.',
                'example' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
            ],
            'length_in_seconds' => [
                'description' => 'The length of the movie in seconds.',
                'example' => 7260,
            ],
            'released_at' => [
                'description' => 'The date when the movie was released. Format: YYYY-MM-DD. Timezone: UTC.',
                'example' => '1999-03-31',
            ],
            'available_until' => [
                'description' => 'The date when the movie will be available until. Format: YYYY-MM-DD. Timezone: UTC.',
                'example' => '2021-12-31',
            ],
            'pictures.*.title' => [
                'description' => 'The title of the picture.',
                'example' => 'The Matrix',
            ],
            'pictures.*.description' => [
                'description' => 'The description of the picture.',
                'example' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
            ],
            'pictures.*.order' => [
                'description' => 'The order of the picture.',
                'example' => 1,
            ],
            'category_ids.*' => [
                'description' => 'The categories of the movie.',
                'example' => 1,
            ],
            'tag_ids.*' => [
                'description' => 'The tags of the movie.',
                'example' => 1,
            ],
        ];
    }
}
