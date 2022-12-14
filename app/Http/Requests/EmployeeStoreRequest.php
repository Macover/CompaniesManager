<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'company_id' => 'required',
            'email' => 'required|unique:employees,email',
            'phone' => 'required|max:11'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!is_numeric($this->company_id)) {
                $validator->errors()->add('field', 'Company invalid!');
            }
        });
    }
}
