<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Room;
use App\Models\RoomReservation;
use App\Models\User;

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

        /**
         * Where method or do something
         */
        $userWhereEmailLikeOrNew = User::where('email', 'like', '%@%')
            ->firstOr(function () {
                User::where('id', '=', 1)->update(['name' => 'Updated']);
            });
        dump('User where email like', $userWhereEmailLikeOrNew);

        /**
         * Find or fail return 404
         */
//        $findOrFailUser = User::findOrFail(100);

        /**
         * Aggregate count, max , min, avg, sum, count
         */
        $maxRating = Comment::max('rating');
        $minRating = Comment::min('rating');
        $avgRating = Comment::avg('rating');
        $sumRating = Comment::sum('rating');
        $countRating = Comment::count('rating');
        dump('Max min avg sum comment rating', $maxRating, $minRating, $avgRating, $sumRating, $countRating);

        /**
         * Added scope method to comments model
         */
        $commentScope = Comment::rating(4)->get();
        dump('Scope from model', $commentScope);
    }

    public function secondLesson()
    {
        $commentsToArray = Comment::all()->toArray();
        dump('comments to array', $commentsToArray);

        $commentsCount = Comment::all()->count();
        dump('comments to count', $commentsCount);

        $commentsToJson = Comment::all()->toJson();
        dump('comments to json', $commentsToJson);

        /**
         * Get all comments and reject that you don't need.
         */
        $allComments = Comment::all();
        $afterReject = $allComments->reject(function ($allComment) {
            return $allComment->rating < 4;
        });
        dump('All comments after rejecting < 4', $afterReject);

        /**
         * Map method.
         */
        $allComments = Comment::all();
        $afterMap = $allComments->map(function ($allComment) {
            return $allComment->rating;
        });
        dump('All comments after map', $afterMap);

        /**
         * Diff method
         */
        $diffComments = $allComments->diff($afterReject);
        dump('diff comments', $diffComments);
    }

    public function thirdLesson()
    {
        /**
         * Adding new comment to DB
         */
        $comment = new Comment();
        $comment->user_id = 1;
        $comment->rating = 5;
        $comment->content = 'Comment content';
        $result = $comment->save();
        dump('New comment added', $result);

        /**
         * delete comment
         */
        $lastComment = Comment::all()->last();
        $deleted = Comment::destroy($lastComment->id);
        dump('Delete last comment', $deleted);

        /**
         * delete comment
         */
        $lastComment = Comment::all()->last();
        dump('Delete last comment', $lastComment->delete());

        /**
         * Adding new comment to DB
         */
        $newComment = Comment::create([
            'user_id' => 2,
            'rating' => 4,
            'content' => 'Just content'
        ]);
        dump('New Comment created', $newComment);

        /**
         * delete last comment
         */
        $lastComment = Comment::all()->last();
        Comment::destroy($lastComment->id);
    }

    public function fourthLesson()
    {
        dump('4');
    }
}
