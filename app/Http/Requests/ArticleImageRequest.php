<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\BaseRequest;

class ArticleImageRequest extends BaseRequest
{
    public function rules(): array
    {
        $method = strtolower(request()->method());

        $rules = match ($method) {
            'post', 'put' => [
                'featured_image' => 'nullable|mimes:jpeg,jpg,png|max:1024',
            ],
            default => [],
        };

        return $rules;
    }

    public function messages()
    {
        return [
            'max' => 'The :attribute may not be greater than :max characters.',
            'mimes' => 'The :attribute must be a file of type: :values.',
        ];
    }
}
