<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'UserId' => User::all()->random()->id,
            'Name' => $this->faker->word(),
            'Description' => $this->faker->sentence(),
            'Path' => $this->faker->imageUrl(),
            'Extension' => $this->faker->randomElement(['png', 'jpg', 'jpeg', 'doc', 'docx', 'pdf', 'xls', 'xlsx']),
            'Size' => $this->faker->randomNumber(),
        ];
    }
}
