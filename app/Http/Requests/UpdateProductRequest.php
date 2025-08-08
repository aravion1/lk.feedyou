<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'proteins' => 'numeric',
            'fats' => 'numeric',
            'carbs' => 'numeric',
            'ccal' => 'numeric',
            'meas_value' => 'numeric',
            'chpu' => 'string',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
