<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
            'comment' => 'required|string',
            'rating' => 'nullable|integer|between:1,5',
        ];
    }

        /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'rating.integer' => 'The rating must be a valid number.',
            'rating.between' => 'The rating must be between 1 and 5 stars.',
            'comment.required' => 'Please add a comment for the product.',
            'comment.string' => 'The comment must be a valid string.',
        ];
    }

}
