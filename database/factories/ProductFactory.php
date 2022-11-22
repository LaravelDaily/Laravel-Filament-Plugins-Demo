<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'         => $this->faker->name(),
            'is_visible'   => $this->faker->boolean(),
            'price'        => $this->faker->randomNumber(random_int(3, 5)),
            'published_at' => $this->faker->dateTimeBetween('-2 years'),
        ];
    }
}
