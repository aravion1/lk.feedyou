<?php

namespace App\Http\Requests;


class SaveProductCategoryRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'numeric',
            'title' => 'required|min:1|max:255|string',
            'description' => 'min:10'
        ];
    }
}
