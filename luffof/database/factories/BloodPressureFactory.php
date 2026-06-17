<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BloodPressure>
 */
class BloodPressureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::inRandomOrder()->first()?->id ?? User::factory()->create()->id;
            },
            'systolic' => $this->faker->numberBetween(100, 160),
            'diastolic' => $this->faker->numberBetween(60, 100),
            'notes' => null,
        ];
    }

    /**
     * Indicate that the blood pressure is normal.
     */
    public function normal(): static
    {
        return $this->state(fn (array $attributes) => [
            'systolic' => $this->faker->numberBetween(90, 120),
            'diastolic' => $this->faker->numberBetween(60, 80),
        ]);
    }

    /**
     * Indicate that the blood pressure is high.
     */
    public function high(): static
    {
        return $this->state(fn (array $attributes) => [
            'systolic' => $this->faker->numberBetween(130, 180),
            'diastolic' => $this->faker->numberBetween(80, 110),
            'notes' => 'High blood pressure detected',
        ]);
    }

    /**
     * Indicate that the blood pressure is low.
     */
    public function low(): static
    {
        return $this->state(fn (array $attributes) => [
            'systolic' => $this->faker->numberBetween(90, 105),
            'diastolic' => $this->faker->numberBetween(50, 65),
        ]);
    }
}
