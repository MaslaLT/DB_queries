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

    public function secondLesson()
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

    public function thirdLesson()
    {
        /**
         * Get room reservations between id 5 and 10
         */
        $roomReservationBeetween = DB::table('room_reservations')
            ->whereBetween('id', [5,10])
            ->get();
        dump('Room reservations between id 5 and 10', $roomReservationBeetween);

        /**
         * Get room reservations NOT between id 5 and 10
         */
        $roomReservationNotBeetween = DB::table('room_reservations')
            ->whereNotBetween('id', [5,10])
            ->get();
        dump('Room reservations NOT between id 5 and 10', $roomReservationNotBeetween);

        /**
         * Get rooms where not id 2, 3, 5, 10,
         */
        $roomsWhereNotIn = DB::table('rooms')
            ->whereNotIn('id', [2, 3, 5, 10])
            ->get();
        dump('rooms where not id 2, 3, 5, 10,', $roomsWhereNotIn);

        /**
         * Get rooms where ids are  2, 3, 5, 10,
         */
        $roomsWhereIn = DB::table('rooms')
            ->whereIn('id', [2, 3, 5, 10])
            ->get();
        dump('rooms where ids are 2, 3, 5, 10,', $roomsWhereIn);

        /**
         * Get all users ids that have reserved room on specific date.
         */
        $usersReservedRoomOnDate = DB::table('users')
            ->whereExists(function($query) {
                $query->select('id')
                    ->from('room_reservations')
                    ->whereRaw('room_reservations.user_id = users.id')
                    ->where('check_in', '=', '2022-01-15')
                    ->limit(10);
            })
            ->get();
        dump('Max 10 records of users id reserved room on specific date', $usersReservedRoomOnDate);

        /**
         * Get users json type meta colum
         */
        $userJsonMeta = DB::table('users')
            ->whereJsonContains('meta->gender', 'male')
            ->where('meta->settings->site_language', 'lt')
            ->get();
        dump('users json meta column', $userJsonMeta);
    }

    public function fourthLesson()
    {
        $comments = DB::table('comments')->get();

        /**
         * Search full text
         * For full text search you need to enable column indexing full text.
         * Very fast sql search
         */
        $searchResult = DB::table('comments')
            ->whereRaw('MATCH(content) AGAINST(? IN BOOLEAN MODE)', [
                'Despair'
            ])
            ->get();

        dump('all comments',$comments ,'Search in comments content', $searchResult);

        /**
         * Search full text with like
         * Simple much slower search.
         */
        $searchLikeResult = DB::table('comments')
            ->where('content', 'like', '%Despair%')
            ->get();

        dump('search with like', $searchLikeResult);

        /**
         * Rooms paginated 5 per page
         * Simple paginate won't check all records count only returns next before buttons for paginate.
         */
        $roomsPaginated = DB::table('rooms')
            ->paginate('5');
        dump('Rooms paginated 5 per page', $roomsPaginated);

        /**
         * Row expressions. Used for laravel unsupported specific sql queries.
         */
        $roomsRowCount = DB::table('rooms')
            ->select(DB::raw('count(rooms.id) as number_of_rooms'))
            ->get();
        dump('Count rooms', $roomsRowCount);

        /**
         * Row expressions. Used for laravel unsupported specific sql queries.
         */
        $userCommentsRowCount = DB::table('comments')
            ->selectRaw('count(user_id) as number_of_comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->groupBy('user_id')
            ->get();
        dump('Count user comments', $userCommentsRowCount);
    }

    public function fifthLesson()
    {
        /**
         * Using orderBy
         */
        $usersOrderedBy = DB::table('users')
            ->orderBy('name', 'desc')
            ->get();
        dump('Users ordered by name desc', $usersOrderedBy);


        /**
         * Using latest and first
         */
        $userLatest = DB::table('users')
            ->latest('id')//default 'updated_at'
            ->first();
        dump('User latest', $userLatest);

        /**
         * Using in random order
         */
        $usersRandomOrder = DB::table('users')
            ->inRandomOrder('id')
            ->get();
        dump('User latest', $usersRandomOrder);

        /**
         * Row select from comments grouping by rating and showing only 5 rating caomments
         */
        $fiveRatedComments = DB::table('comments')
            ->selectRaw('count(id) as number_of_5_rated_comments, rating')
            ->groupBy('rating')
            ->having('rating', '=', 5)
            ->get();
        dump('5 rated comments grouped by rating', $fiveRatedComments);

        /**
         * Skip and take
         */
        $fiveCommentsAfterSkippingFive = DB::table('comments')
            ->skip(5)
            ->take(5)
            ->get();
        dump('5 Comments after 5 skiped', $fiveCommentsAfterSkippingFive);

        /**
         * when conditional clause. If parameter null its ignored if some number then will work.
         */
        //$roomId = null;
        $roomId = 5;

        $roomById = DB::table('room_reservations')
            ->when($roomId, function($query, $roomId) { //if $roomId is null when anonymous function is not running.
                return $query->where('room_id', $roomId);
            })
            ->get();
        dump('Rooms where id equals to x', $roomById);

        /**
         * when conditional clause.
         * If sort is null when order by price if sort not null sort by variable $sortBy value
         * and joined two tables.
         */
        $sortBy = null;

        $roomSort = DB::table('rooms')
            ->when($sortBy, function($query, $sortBy) {
                return $query->orderBy('room_id');
            }, function($query) {
                return $query->orderBy('price');
            })
            ->join('room_reservations', 'rooms.id', '=', 'room_reservations.id')
            ->get();
        dump('Rooms sort', $roomSort);

        /**
         * get all and chunk.
         * Chunk best to use then you have huge amount of data and you out of ram.
         */
        $commentsChunked = DB::table('comments')
            ->orderBy('id')
            ->chunk(10, function($comments){
                foreach ($comments as $comment) {
                    if($comment->id == 11) return false;
                }
            });
        dump('Chunked comments', $commentsChunked);

        /**
         * Get all. Then chunk and update all records.
         * Chunk best to use then you have huge amount of data and you out of ram.
         */
        $commentsChunkedUpdate = DB::table('comments')
            ->orderBy('id')
            ->chunkById(10, function($comments){
                foreach ($comments as $comment) {
                   DB::table('comments')
                       ->where('id', $comment->id)
                       ->update(['rating' => $comment->rating]);
                }
            });
        dump('Chunked comments update all', $commentsChunkedUpdate);
    }

    public function sixthLesson()
    {
       /**
        * joining room_reservations with rooms and users.
        * where room id less or equal for 2.
        */
       $reservationsWithRoomsAndUsers = DB::table('room_reservations')
           ->join('rooms as r', 'room_reservations.room_id', '=', 'r.id')
           ->join('users', 'room_reservations.user_id', '=', 'users.id')
           ->where('room_id', '<=', 2)
           ->get();
       dump('reservations joined with room and user where room id is less or equal 2', $reservationsWithRoomsAndUsers);

        /**
         * Same as above but more readable.
         */
        $reservationsWithRoomsAndUsers = DB::table('room_reservations')
            ->join('rooms', function($join) {
                $join->on('room_reservations.room_id', '=', 'rooms.id')
                ->where('room_id', '<=', 2);
            })
            ->join('users', function($join) {
                $join->on('room_reservations.user_id', '=', 'users.id');
            })
            ->get();
        dump('same as above', $reservationsWithRoomsAndUsers);

        /**
         * Same as above but using join sub queries.
         */
        $rooms = DB::table('rooms')
            ->where('id', '<=', 2);
        $users = DB::table('users');

        $reservationsWithRoomsAndUsers = DB::table('room_reservations')
            ->joinSub($rooms, 'rooms', function ($join) {
                $join->on('room_reservations.room_id', '=', 'rooms.id');
            })
            ->joinSub($users, 'users', function ($join) {
                $join->on('room_reservations.user_id', '=', 'users.id');
            })
            ->get();
        dump('same as above using sub join', $reservationsWithRoomsAndUsers);

        /**
         * Left join returns all rooms
         * at counts all rooms. Even without any reservation...
         */
        $allRoomsJoinedWithReservations = DB::table('rooms')
            ->leftJoin('room_reservations','rooms.id', '=', 'room_reservations.room_id')
            ->selectRaw('size, count(room_reservations.id) as reservations_count')
            ->groupBy('size')
            ->orderByRaw('count(room_reservations.id) DESC')
            ->get();
        dump('Left join reservation with all rooms', $allRoomsJoinedWithReservations);

        /**
         * Left join returns all rooms
         * at counts all rooms. Even without any reservation...
         * Added one more group column
         */
        $allRoomsJoinedWithReservationsBySizeAndPrice = DB::table('rooms')
            ->leftJoin('room_reservations','rooms.id', '=', 'room_reservations.room_id')
            ->selectRaw('size, price, count(room_reservations.id) as reservations_count')
            ->groupBy('size', 'price')
            ->orderByRaw('count(room_reservations.id) DESC')
            ->get();
        dump('Left join reservation with all rooms group by size and price', $allRoomsJoinedWithReservationsBySizeAndPrice);

        /**
         * Left join returns all rooms
         * at counts all rooms. Even without any reservation...
         * Added one more group column and add city table to join
         */
        $allRoomsJoinedWithReservationsBySizeAndPrice = DB::table('rooms')
            ->leftJoin('room_reservations','rooms.id', '=', 'room_reservations.room_id')
            ->leftJoin('cities','room_reservations.city_id', '=', 'cities.id')
            ->selectRaw('size, price, cities.name as city_name, count(room_reservations.id) as reservations_count')
            ->groupBy('size', 'price', 'cities.name')
            ->orderByRaw('count(room_reservations.id) DESC')
            ->get();
        dump('Left join reservation with all rooms group by size and price', $allRoomsJoinedWithReservationsBySizeAndPrice);
    }
}
