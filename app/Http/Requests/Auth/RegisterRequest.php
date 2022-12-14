<?php

namespace App\Http\Requests\Auth;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => ['required', "min:3", "max:20"],
            "email" => ['required', "email", "unique:users,email"],
            "password" => ['required', "min:3", "max:255"],
            "gender" => ['required', "in:male,female,other"],
            "birthday" => ['required', 'date'],
            "phone" => ['required', 'unique:users,phone'],
            "lat" => ['sometimes', 'required'],
            "long" => ['sometimes', 'required'],
            "city" => ['required', "min:3", "max:50"],
            "state" => ['required', "min:3", "max:50"],
            "street" => ['sometimes', 'required', "min:3", "max:100"],
            "suite" => ['sometimes', 'required', "min:3", "max:50"],
            "zip" => ['sometimes', 'required', 'numeric'],
            "role" => ['sometimes', 'in:runner,user'],
            "service_id" => ['required_if:role,runner', 'nullable'],
            "cost_per_hour" => ['required_if:role,runner', 'nullable', 'numeric'],
        ];
    }
}
