<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numberBetween(1,30),
            'size' => $this->faker->numberBetween(1,5),
            'price' => $this->faker->numberBetween(100,600),
            'description' => $this->faker->realTextBetween(300, 1000, 2),
        ];
    }
}
