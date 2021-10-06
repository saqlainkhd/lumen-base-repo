<?php

namespace App\Http\Requests\V1;

use Pearl\RequestValidate\RequestAbstract;

class CreateCustomerRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|alpha|max:100',
            'last_name' => 'required|alpha|max:100',
            'city' => 'string|required',
            'country' => 'string|required',
            'phone' => 'required|numeric|max:999999999999999999999999|unique:users,phone',
            'email' => 'required|email:rfc,dns|max:50|email|unique:users,email',
            'password' => 'required|confirmed|min:6||max:100|string'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
