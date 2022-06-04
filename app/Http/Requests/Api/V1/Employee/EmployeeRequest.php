<?php

namespace App\Http\Requests\Api\V1\Employee;

use App\Rules\PhoneNumberValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            'company_id' => [
                'required',
                Rule::exists('companies', 'id')
            ],
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'enroll_id'=> [
                'required',
                'string',
                'max:255'
            ],
            'email' => ['required','email','max:255'],
            'contact' => [
                'required',
                new PhoneNumberValidationRule(),
            ],
            'designation' => ['required','string', 'max:255'],
            'departments' => [
                'array'
            ],
            'departments.*' => ($this->departments && is_array($this->departments))
                ? [
                    'required',
                    Rule::exists('departments', 'id')->where('company_id', $this->company_id)
                ] : []
        ];
    }
}
