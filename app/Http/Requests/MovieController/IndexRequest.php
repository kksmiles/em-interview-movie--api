<?php

namespace App\Http\Requests\MovieController;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'include_trashed' => ['sometimes', 'boolean'],
            'category_ids' => ['sometimes', 'array'],
            'category_ids.*' => ['sometimes', 'integer', 'exists:categories,id'],
            'tag_ids' => ['sometimes', 'array'],
            'tag_ids.*' => ['sometimes', 'integer', 'exists:tags,id'],
            'include_categories' => ['sometimes', 'boolean'],
            'include_tags' => ['sometimes', 'boolean'],
            'include_pictures' => ['sometimes', 'boolean'],
            'strict_filter' => ['sometimes', 'boolean'],
        ];
    }

    public function queryParameters()
    {
        return [
            'include_trashed' => [
                'description' => 'Include trashed users.',
                'example' => true,
            ],
            'category_ids.*' => [
                'description' => 'Filter by category ids.',
                'example' => 1,
            ],
            'tag_ids.*' => [
                'description' => 'Filter by tag ids.',
                'example' => 1,
            ],
            'include_categories' => [
                'description' => 'Include categories.',
                'example' => true,
            ],
            'include_tags' => [
                'description' => 'Include tags.',
                'example' => true,
            ],
            'include_pictures' => [
                'description' => 'Include pictures.',
                'example' => true,
            ],
            'strict_filter' => [
                'description' => 'Whether to strictly filter by category and tag ids.',
                'example' => true,
            ],
        ];
    }
}
