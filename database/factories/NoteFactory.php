<?php

namespace Database\Factories;

use App\Application\Note\Enum\NoteStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(1),
            'description' => fake()->paragraph(),
            'status'      => fake()->randomElement(NoteStatusEnum::getValues()),
        ];
    }
}
