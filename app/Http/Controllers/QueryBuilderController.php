<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function firstLesson()
    {
        /**
         * Get all users and all fields
         */
        $allUsers = DB::table('users')->get();
        dump('all users', $allUsers);

        /**
         * Get all users and return only email field
         */
        $allUsersEmail = DB::table('users')->pluck('email');
        dump('all users email field only', $allUsersEmail);

        /**
         * Get user with id 1 first
         */
        $user = DB::table('users')
            ->where('id','=', 1)
            ->first();
        dump('one user with id 1', $user);

        /**
         * Get user with id 1 and return email value
         */
        $userEmail = DB::table('users')
            ->where('id','=', 1)
            ->value('email');
        dump('email value of one user with id 1', $userEmail);

        /**
         * Get user by its id field
         */
        $userById = DB::table('users')->find(1);
        dump('user find 1', $userById);

        /**
         * All comments only content field and changed it name in array to comment_content.
         */
        $comment = DB::table('comments')
            ->select('content as comment_content')
            ->get();
        dump('comment select one column(content) as comment_content', $comment);

        /**
         * Comment only user_id field and only distinct (different) values of user_id field.
         */
        $commentDistinct = DB::table('comments')
            ->select('user_id')
            ->distinct()
            ->get();
        dump('Comment distinct user_id values', $commentDistinct);

        /**
         * Count query results.
         */
        $commentWhereCount = DB::table('comments')
            ->where('id', '<=', '3')
            ->count();
        dump('Count result', $commentWhereCount);

        /**
         * Max user id.
         * Can use MAX MIN
         */
        $commentMaxUserId = DB::table('comments')
            ->where('id', '<=', '3')
            ->max('user_id');
        dump('Max User id', $commentMaxUserId);

        /**
         * Sum user id values.
         * Can use sum avg
         */
        $commentSumUserId = DB::table('comments')
            ->where('id', '<=', '3')
            ->sum('user_id');
        dump('Sum User id', $commentSumUserId);

        /**
         * Do comment exist with user id 1
         */
        $allUsers = DB::table('comments')->where('user_id', '=', 1)->exists();
        dump('Comment exists? with user id 1', $allUsers);

        /**
         * Comment don't exist with user id 1
         */
        $allUsers = DB::table('comments')->where('user_id', '=', 1)->doesntExist();
        dump('Comment don\'t exists? with user id 1', $allUsers);
    }

    public function secondLesson ()
    {
        /**
         * Get rooms with price less than 200
         */
        $roomsLessWhenPrice = DB::table('rooms')
            ->where('price', '<', 200)
            ->get();
        dump('Rooms les than 200', $roomsLessWhenPrice);

        /**
         * Get rooms with price less than 200 and size is 4
         */
        $roomsLessWhenPriceAndSizeOne = DB::table('rooms')
            ->where('price', '<', 200)
            ->where('size', '=', 4)
            ->get();
        $roomsLessWhenPriceAndSizeTwo = DB::table('rooms')
            ->where([
                ['price', '<', 200],
                ['size', 4]
            ])->get();
        dump('Rooms les than 200 and size is 5', $roomsLessWhenPriceAndSizeOne, $roomsLessWhenPriceAndSizeTwo);

        /**
         * Get rooms where size is 3 or price is less than 200
         * So its returns rooms with size 3 and all rooms with price less than 100.
         */
        $roomsWhereSizeOrPrice = DB::table('rooms')
            ->where('size', 3)
            ->orWhere('price', '<' , 100)
            ->get();
        dump('Rooms where size is 3 or where price is less 100', $roomsWhereSizeOrPrice);

        /**
         * Get rooms size 4 or anonymous function with query.
         * Advanced querying.
         */

        $roomsWhereSizeOrAnonymous = DB::table('rooms')
            ->where('size', '=', 4)
            ->orWhere(function($query) {
                $query->where('price', '<', 150)
                ->where('price', '>', 150 );
            })
            ->get();
        dump('Rooms where size is 4 or statement in anonymous function', $roomsWhereSizeOrAnonymous);
    }
}
