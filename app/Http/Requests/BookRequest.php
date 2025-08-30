<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required','string'],
            'isbn' => ['required', 'string'],
            'author' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,png'],
            'quantity' => ['required', 'numeric'],
            'category_ids' => ['nullable','array'],
            'category_ids.*' => ['integer','exists:categories,id'],
        ];


        return $rules;
    }
}
