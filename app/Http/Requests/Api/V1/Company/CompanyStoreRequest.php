<?php

namespace App\Http\Requests\Api\V1\Company;

use App\Rules\CompanyUniqueRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyStoreRequest extends CompanyRequest
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
        $rules = parent::rules();
        return array_merge_recursive(
            $rules,
            [
                'name' => [
                    Rule::unique('companies', 'name')
                ]
            ]
        );
    }
}
