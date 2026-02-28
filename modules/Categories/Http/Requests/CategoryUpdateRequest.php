<?php

namespace Modules\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules(): array
     {
         return [
             'name' => [
                 'required',
                 'string',
                 'max:150',
                 Rule::unique('categories', 'name')
                     ->ignore($this->route('category')->id),
             ],
             'slug' => ['nullable', 'string'],
             'description' => ['nullable', 'string'],
             'is_active' => ['nullable', 'boolean'],
             'is_featured' => ['nullable', 'boolean'],
         ];
     }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 150 characters.',
            'name.unique' => 'The category name already exists.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 150 characters.',
        ];
    }
}
