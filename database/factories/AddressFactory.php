<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastUserId = User::all('id')->last()->id;

        return [
            'number' => $this->faker->numberBetween(1, 200),
            'country' => $this->faker->country,
            'street' => $this->faker->streetName,
        ];
    }
}
