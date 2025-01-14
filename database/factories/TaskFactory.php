<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'CompanyId' => Company::all()->random()->id,
            'AccountId' => Account::all()->random()->id,
            'Name' => $this->faker->word(),
            'IsDone' => $this->faker->boolean(),
            'Deadline' => $this->faker->date(),
        ];
    }
}
