<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'enroll_id' => Str::random(12),
            'contact' => "2242342",
            'designation' => "Fullstack Designation"
        ];
    }
}
