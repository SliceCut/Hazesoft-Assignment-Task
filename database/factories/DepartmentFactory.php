<?php

namespace Database\Factories;

use App\Domain\Repositories\Company\CompanyRepositoryInterface;
use App\Domain\Repositories\Department\DepartmentRepositoryInterface;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => Company::firstOrFail()->id,
            'name' => $this->faker->name()
        ];
    }
}
