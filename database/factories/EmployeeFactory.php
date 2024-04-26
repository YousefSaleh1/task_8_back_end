<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'first_name'    => $this->faker->firstName,
            'last_name'     => $this->faker->lastName,
            'email'         => $this->faker->unique()->safeEmail,
            'position'      => $this->faker->jobTitle
        ];
    }
}
