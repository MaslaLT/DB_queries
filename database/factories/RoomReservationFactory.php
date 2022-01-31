<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $maxRoomId = Room::all('id')->last();
        $maxUserId = User::all('id')->last();
        $maxCityId = City::all('id')->last();

        return [
            'user_id' => $this->faker->numberBetween(1, (int) $maxUserId->id),
            'room_id' => $this->faker->numberBetween(1, (int) $maxRoomId->id),
            'city_id' => $this->faker->numberBetween(1, (int) $maxCityId->id),
            'check_in' => $this->faker->dateTimeBetween('-10 days', '-1 day'),
            'check_out' => $this->faker->dateTimeBetween('now', '+5 day'),
        ];
    }
}
