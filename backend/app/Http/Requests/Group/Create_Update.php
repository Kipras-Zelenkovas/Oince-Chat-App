<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class Create_Update extends FormRequest
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
            'name'      => 'required|max:30|min:2',
            'image'     => 'image',
            'status'    => 'required|string',
            'tags'      => 'required|string'
        ];
    }
}
