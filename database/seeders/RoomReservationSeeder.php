<?php

namespace Database\Seeders;

use App\Models\RoomReservation;
use Illuminate\Database\Seeder;

class RoomReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomReservation::factory()->count(5)->create();
    }
}
