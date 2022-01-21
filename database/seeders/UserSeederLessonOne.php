<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeederLessonOne extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(15)
            ->create();

//        $connection = 'sqlite';
//
//        User::factory()
//            ->connection($connection)
//            ->count(5)
//            ->create();
    }
}
