<?php

namespace App\Http\Requests\Api\V1\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends CompanyRequest
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
        return array_merge_recursive(
            parent::rules(),
            [
                'name' => [Rule::unique('companies','name')->ignore($this->company->id)]
            ]
        );
    }
}
