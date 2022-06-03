<?php

namespace App\Http\Requests\Api\V1\Company;

use App\Rules\PhoneNumberValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'location' => ['required','string','max:255'],
            'contact_number' => [
                'required',
                new PhoneNumberValidationRule    
            ],
        ];
    }
}
