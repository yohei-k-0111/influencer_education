<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Curriculum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryTime>
 */
class DeliveryTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'curriculums_id' => Curriculum::factory(),
            'delivery_from' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+5day'),
            'delivery_to' => $this->faker->dateTimeBetween($startDate = '+6day', $endDate = '+10day'),
            'updated_at' => now(),
            'created_at' => now(),
                ];
    }
}
