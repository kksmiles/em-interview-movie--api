<?php

namespace App\Http\Requests\CategoryController;

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
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'The name of the category.',
                'example' => 'My Category',
            ],
        ];
    }
}
