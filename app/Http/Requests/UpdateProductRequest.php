<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:products,name,' . $this->route('product'),
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock',
            'description' => 'nullable|string|max:1000',
            'categories' => 'required|array|min:1',
            'images' => 'nullable|array',
            'images.*' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }

     /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The product name is required.',
            'name.unique' => 'A product with this name already exists.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'stock_quantity.required' => 'The stock quantity is required.',
            'stock_quantity.integer' => 'The stock quantity must be an integer.',
            'stock_quantity.min' => 'The stock quantity must be at least 0.',
            'stock_status.required' => 'The stock status is required.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description must not exceed 1000 characters.',
            'categories.required' => 'At least one category must be selected.',
            'categories.min' => 'Please select at least one category.',
            'images.*.mimes' => 'Each image must be a jpg, jpeg, png, or gif file.',
            'images.*.max' => 'Each image must be less than 2MB.',
        ];
    }
}
