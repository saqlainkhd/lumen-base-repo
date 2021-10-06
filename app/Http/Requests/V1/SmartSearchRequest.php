<?php

namespace App\Http\Requests\V1;

use Pearl\RequestValidate\RequestAbstract;

use App\Http\Models\Customer;

use Illuminate\Validation\Rule;

class SmartSearchRequest extends RequestAbstract
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
            'field' => 'required|string|'. Rule::in(array_values(Customer::SEARCHABLE)),
            'value' => 'required|string',
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
