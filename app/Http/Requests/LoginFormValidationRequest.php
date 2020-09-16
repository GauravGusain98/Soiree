<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormValidationRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'loginEmail' => explode('@', $this->loginEmail)[0] . '@gmail.com',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'loginEmail' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            "loginEmail.required" => "The Email is required."
        ];
    }
}
