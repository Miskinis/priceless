<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Whitecube\LaravelPrices\Models\Price;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }
}
