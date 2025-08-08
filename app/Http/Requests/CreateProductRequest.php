<?php

namespace App\Http\Requests;

class CreateProductRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'proteins' => 'required|numeric',
            'fats' => 'required|numeric',
            'carbs' => 'required|numeric',
            'ccal' => 'required|numeric',
            'meas_value' => 'required|numeric',
            'chpu' => 'string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
