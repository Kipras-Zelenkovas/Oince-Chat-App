<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'string|min:4|max:30',
            'bio'       => 'string|min:10|max:200',
            'image'     => 'image',
            'age'       => 'min:1|max:2',
            'gender'    => 'string|min:3|max:20',
            'country'   => 'string|min:3|max:25'
        ];
    }
}
