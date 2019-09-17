<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployeRequest extends FormRequest
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
            'email' => 'required|email|unique:cooks',
            'name' => 'required',
            'password' => 'required',
            'address' => "required",
            'phone' => "required",
        ];
    }
}
