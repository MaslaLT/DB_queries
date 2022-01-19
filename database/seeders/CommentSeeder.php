<?php

namespace Database\Seeders;

use App\Models\Comments;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * This seeder won't bee launched. It's just an example.
         */
        Comments::factory()->count(10)->create();
    }
}
