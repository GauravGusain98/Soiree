<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormValidationRequest extends FormRequest
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
            'email' => explode('@', $this->email)[0] . '@gmail.com',
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
            'name' => 'required',
            'email' => 'required| unique:admins,email_address',
            'password1' => 'required|min:5',
            'password2' => ['required', 'min:5', "same:password1"]
        ];
    }

    public function messages()
    {
        return [
            "password1.required" => 'The Password field is required.',
            'password2.required' => 'Password Confirmation is required.',
            "password2.same" => "Password didn't match.",
            "email.unique" => "Email already exists."
        ];
    }
}
