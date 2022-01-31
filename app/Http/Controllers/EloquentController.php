<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Room;
use App\Models\RoomReservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EloquentController extends Controller
{
    public function firstLesson()
    {
        /**
         * Eloquent first query get all.
         */
        $allRooms = Room::all();
        dump('All rooms', $allRooms);

        /**
         * Get rooms where size is 1
         */
        $roomsWithSize = Room::where('size', 1)
            ->get();
        dump('Rooms with size 3', $roomsWithSize);

        /**
         * Get rooms where price is less than 250
         */
        $roomsWithPriceLess = Room::where('price', '<', 250)
            ->get();
        dump('Rooms with price less than 250', $roomsWithPriceLess);

        /**
         * Get all rooms select price and id
         */
        $roomsSelectIdAndPrice = Room::select('id', 'price')
            ->get();
        dump('Rooms select price and id', $roomsSelectIdAndPrice);

        /**
         * Get users comment with the lowest rating.
         */
        $usesCommentLowestRating = User::select('name', 'email')
            ->addSelect(['worst_rating' => Comment::select('rating')
                ->whereColumn('user_id', 'users.id')
                ->orderBy('rating', 'asc')
                ->limit(1)
            ])
            ->get()->toArray();
        dump('Users comment with the lowest rating', $usesCommentLowestRating);

        /**
         * Get users comment with the highest rating.
         */
        $usesCommentLowestRating = User::select('name', 'email')
            ->addSelect(['best_rating' => Comment::select('rating')
                ->whereColumn('user_id', 'users.id')
                ->orderBy('rating', 'desc')
                ->limit(1)
            ])
            ->get()->toArray();
        dump('Users comment with the highest rating', $usesCommentLowestRating);

        /**
         * Order users by check_in date
         */
        $usersOrderByCheckIn = User::orderByDesc(
            RoomReservation::select('check_in')
                ->whereColumn('user_id', 'users.id')
                ->orderBy('check_in', 'desc')
                ->limit(1)
            )
            ->select('id','name', 'email')
            ->get();
        dump('Users ordered by checkin date', $usersOrderByCheckIn);

        /**
         * Chunk reservations
         */
        $chunkReservations = RoomReservation::chunk(2, function ($reservations) {
           foreach ($reservations as $reservation)
           {
               echo $reservation->id;
           }
        });
        dump('chunking reservations', $chunkReservations);

        /**
         * Cursor method.
         * Uses more memory but works faster then chunk.
         */
        foreach (Room::cursor() as $room) {
            echo $room->id;
        }

        /**
         * Find method
         */
        $roomById = Room::find(1);
        dump('Room by id 1', $roomById);

        /**
         * Find method
         */
        $roomWithId = Room::find([1,2,3]);
        dump('Room with id 1 2 3', $roomWithId);

        /**
         * Where method
         */
        $userWhereEmailLike = User::where('email', 'like', '%@%')
            ->first();
        dump('User where email like', $userWhereEmailLike);
    }
}
