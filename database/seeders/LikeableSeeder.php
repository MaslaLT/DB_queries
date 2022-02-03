<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++)
        {
            DB::table('likeables')
                ->insert([
                    'likeable_type' => [Image::class, Room::class][rand(0,1)],
                    'likeable_id' => rand(1,10),
                    'user_id' => rand(1, 10),
                ]);
        }
    }
}
