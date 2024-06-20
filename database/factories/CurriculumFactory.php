<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculum>
 */
class CurriculumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->word,
            'thumbnail' => $this->faker->image,
            'description' => $this->faker->realText(100),
            'video_url' => $this->faker->unique()->url,
            'always_delivery_flg' => $this->faker->numberBetween(0, 1),
            'grade_id' => $this->faker->numberBetween(1, 12),
            'created_at' => now(),
            'updated_at' => now(),
                ];
    }
}
