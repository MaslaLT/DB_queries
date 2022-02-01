<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeederLessonOne::class);
        $this->call(CommentSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(RoomReservationSeeder::class);
//        $this->call(AddressSeeder::class);
        $this->call(CityRoomSeeder::class);
    }
}
