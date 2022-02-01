<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            DB::table('city_room')
                ->insert([
                    'room_id' => rand(1, 5),
                    'city_id' => rand(1, 4),
                    'created_at' => Carbon::now(),
                ]);
        }
    }
}
