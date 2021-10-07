<?php

namespace App\Http\Requests\V1;

use Pearl\RequestValidate\RequestAbstract;

use App\Http\Models\User;

use Illuminate\Validation\Rule;

class MemberRequest extends RequestAbstract
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
            'phone' =>  ($this->isMethod('put')) ? 'nullable|numeric|max:999999999999999999999999|unique:users,phone,'. $this->id : 'nullable|numeric|max:999999999999999999999999|unique:users,phone',
            'email' => ($this->isMethod('put')) ? 'required|email:rfc,dns|unique:users,email,' . $this->id : 'required|email:rfc,dns|unique:users,email',
            'password' => ($this->isMethod('post')) ? 'required|confirmed|min:6||max:100|string' : '',
            'status' => 'required|string|'. Rule::in(array_keys(User::STATUS)),
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
