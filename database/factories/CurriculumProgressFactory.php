<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CurriculumProgress>
 */
class CurriculumProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'curriculums_id' => fake()->numberBetween($min=73,$max=108),
            'users_id' => fake()->numberBetween($min=1,$max=5),
            'clear_flg' => fake()->numberBetween($min=0,$max=1),
        ];
    }
}
