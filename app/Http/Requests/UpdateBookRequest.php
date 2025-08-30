<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'title' => ['sometimes', 'required', 'string', 'between:3,20'],
            'description' => ['sometimes', 'nullable', 'string'],
            'isbn' => ['sometimes', 'required', 'string'],
            'author' => ['sometimes', 'required', 'string'],
            'cover_image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png'],
            'quantity' => ['sometimes', 'required', 'numeric'],
            'category_ids' => ['nullable','array'],
            'category_ids.*' => ['integer','exists:categories,id'],
        ];
    }
}
