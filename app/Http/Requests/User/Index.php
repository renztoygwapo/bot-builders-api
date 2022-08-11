<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Index extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'nullable|integer|min:1',
            'limit' => 'required_with:page|integer|min:5',
            'search' => 'nullable|string',
            's_fields' => 'required_with:search|string',
            'sort_by' => 'nullable|string',
            'sort_desc' => 'required_with:sort_by|boolean',
        ];
    }
}
