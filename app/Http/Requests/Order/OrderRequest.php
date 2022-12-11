<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "description" => ['required', "min:10", "max:255"],
            "voice" => ['nullable'],
            "date" => ['required', 'date_format:Y-m-d'],
            "time" => ['required', 'date_format:H:i'],
            "urgent" => ['required', 'in:0,1'],
            "complex" => ['required', 'in:0,1'],
            "care_for" => ['required', 'in:experience,cost'],
            "user_id" => ['required', 'exists:users,id'],
            "runner_id" => ['required', 'exists:users,id'],
            "address_id" => ['required', 'exists:addresses,id']
        ];
    }
}
