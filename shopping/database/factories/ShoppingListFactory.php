<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShoppingList>
 */
class ShoppingListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'title' => fake()->word(),
            'priority' => 'medium',
            'items' => json_encode([]),
        ];
    }

    public function high(): static
    {
        return $this->state(fn () => ['priority' => 'high']);
    }

    public function withItems(array $items): static
    {
        return $this->state(fn () => ['items' => json_encode($items)]);
    }
}
