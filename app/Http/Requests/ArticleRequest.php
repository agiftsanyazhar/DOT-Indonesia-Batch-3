<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\BaseRequest;

class ArticleRequest extends BaseRequest
{
    public function rules(): array
    {
        $method = strtolower(request()->method());

        $rules = match ($method) {
            'post', 'patch' => [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'featured_image' => 'nullable|mimes:jpeg,jpg,png|max:1024',
            ],
            default => [],
        };

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'mimes' => 'The :attribute must be a file of type: :values.',
        ];
    }
}
