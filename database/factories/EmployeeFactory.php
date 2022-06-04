<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
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
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'enroll_id' => rand(1, 1000),
            'contact' => $this->faker->phoneNumber(),
            'designation' => "Fullstack Designation"
        ];
    }
}
