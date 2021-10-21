<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:120',
            'description' => 'required|max:4000',
            'price' => 'required',
            'image' => 'file|mimes:png,jpg,jpeg,gif,webp',
            'category_id' => [
                'required',
                Rule::in('id')
            ]
        ];
    }
    
    /**
     * messages
     *
     * @return void
     */
    public function messages()
    {
        return ['category_id.required' => 'The category field is required.'];
    }
}
