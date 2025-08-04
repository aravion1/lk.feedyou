<?php

namespace App\Http\Requests;

class CreateProductRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

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
            'img_list' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
