<?php

namespace App\Http\Requests\Auth;

use App\Rules\EmailRule;
use App\Rules\PhoneNumberRule;
use App\Rules\ValidRecapcha;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|unique:users',
            'email' => ['required', 'unique:users', new EmailRule()],
            'phone' => [
                'required', 'min:10', "max:20", new PhoneNumberRule()
            ],
            'password' => ['required', 'confirmed', 'min:6'],
            'password_confirmation' => 'required|max:255',
            'g-recaptcha-response' => ['required', new ValidRecapcha()]
        ];
    }
}
