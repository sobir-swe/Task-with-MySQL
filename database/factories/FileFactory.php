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
            'user_id' => 1,
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'path' => $this->faker->imageUrl(),
            'extension' => $this->faker->randomElement(['png', 'jpg', 'jpeg', 'doc', 'docx', 'pdf', 'xls', 'xlsx']),
            'size' => $this->faker->randomNumber(),
        ];
    }
}
