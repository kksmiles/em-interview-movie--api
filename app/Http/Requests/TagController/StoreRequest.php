<?php

namespace App\Http\Requests\TagController;

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
            'name' => ['required', 'string', 'max:255', 'unique:tags,name'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'The name of the tag.',
                'example' => 'My Tag',
            ],
        ];
    }
}
