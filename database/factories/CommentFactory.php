<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastUser = User::all('id')->last();

        return [
            'user_id' => $this->faker->numberBetween(1, $lastUser->id),
            'content' => $this->faker->realTextBetween(160,500),
        ];
    }
}
