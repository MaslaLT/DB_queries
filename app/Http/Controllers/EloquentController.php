<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Image;
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
        /**
         * get user and dump address with number.
         */
        $userOne = User::find(1);
        dump('Users adress and number', $userOne->address->street, $userOne->address->number);

        /**
         * get address and print users name.
         */
        $addresOne = Address::find(1);
        dump('Print user from adress', $addresOne->user->name);

        /**
         * get users comments
         */
        $allUsersComments = $userOne->comments;
        dump('All users comments', $allUsersComments);

        /**
         * Get user from comment
         */
        $commentOne = Comment::find(1);
        dump('user from comment', $commentOne->user);
    }

    public function fifthLesson()
    {
        /**
         * Get all rooms of city
         */
        $city = City::find(3);
        $cityRooms = $city->rooms;
        dump('All rooms of city 3', $cityRooms);
        dump('Pivot created_at', $cityRooms[1]->pivot->created_at);

        /**
         * Get cities of room
         */
        $room = Room::find(3);
        $roomCities = $room->cities;
        dump('All cities of rooms 3', $roomCities);

        /**
         * get Users country from address through comment
         */
        $comment = Comment::find(1);
        $usersCountry = $comment->userCountry;
        dump('Users country from comment', $usersCountry->name);

        /**
         * get reservation from company through user
         */
        $company = Company::find(5);
        $reservationsFromCompany = $company->reservations;
        dump('Reservations from company thrugh user', $reservationsFromCompany);
    }

    public function sixthLesson()
    {
        /**
         * get users image polymorphic
         */
        $user = User::find(10);
        $usersImage = $user->image;
        dump('users image polimorfic', $usersImage);

        /**
         * get user from image
         */
        $image = Image::find(1);
        $imageable = $image->imageable;
        dump('Image from user', $imageable);

        /**
         * get many user images
         */
        $usersImages = $user->images;
        dump('many user images', $usersImages);

        /**
         * Users liked images
         */
        $userLikedImages = $user->likedImages;
        dump('Users liked images', $userLikedImages);

        /**
         * Users liked rooms
         */
        $userLikedRooms = $user->likedRooms;
        dump('Users liked rooms', $userLikedRooms);

        /**
         * All room likes.
         */
        $room = Room::find(9);
        $roomLikes = $room->likes;
        dump('All room likes', $roomLikes);
    }

    public function seventhLesson()
    {
        $user = User::find(1);
        $userComments = $user->comments()
        ->where('rating', '>', 3)
        ->get();

        dump('All user comments where rating is > 3', $userComments);

        $userComments = $user->comments()
            ->where(function($query) {
                return $query->where('rating', '>', 3)
                    ->orWhere('rating', '<', 2);
            })
            ->get();
        dump('Comments with or where', $userComments);

        $userHasAddress = Comment::has('user.address')->get();
        dump('User has address', $userHasAddress);

        /**
         * Get all users what have comments
         * can specify count of comments.
         */
        $allUsersThatHasComments = User::has('comments')->get();
        dump('all user with has comments', $allUsersThatHasComments);

        /**
         * Get all users where has comments and comment rating is > 4 and has more when 1 comments
         * can specify count of comments.
         */
        $allUsersThatHasComments = User::whereHas('comments', function($query) {
                                        $query->where('rating', '>', 4);
        }, '>', 1)->get();
        dump('Get all users where has comments and comment rating is > 4', $allUsersThatHasComments);

        /**
         * Get all users with comments counted (relationship)
         */
        $userWithCommentsCounted = User::withCount('comments', 'address', 'roomReservations')->get();
        dump('All users with comment count', $userWithCommentsCounted);

        /**
         * Get all users with negative comments
         */
        $userWithNegativeComments = User::withCount([
            'comments',
            'comments as negative_comments' => function($query) {
                $query->where('rating', '<=', 2);
            }
        ])->get();
        dump('User with comments and with negative comments', $userWithNegativeComments);

        /**
         * Get all images where has USER and CITY imageables
         */
        $imagesWhereHas = Image::whereHasMorph( 'imageable',[
            User::class,
            City::class,
        ])->get();
        dump('Imageables', $imagesWhereHas);

        /**
         * Get all images where has USER and CITY imageables
         * and where user company id is more then 2
         */
        $imageUsersAndRoomsWhere = Image::whereHasMorph( 'imageable',
            [User::class, City::class,], function($query, $type) {
                if($type === User::class) {
                    $query->where('company_id', '>', 3);
                }
            }
        )->get();
        dump('Imageables', $imageUsersAndRoomsWhere);

        /**
         * Get users and city from image imageables
         */
        $usersAndCityFromImage = Image::with('imageable')->find(3);
        dump('Images with imageables', $usersAndCityFromImage);

        /**
         * Get users and city from image imageables and count
         */
        $usersAndCityFromImageCount = Image::find(4)->loadMorphCount('imageable', [
            User::class => ['comments as User_comments'],
            City::class => ['images as city_images'],
        ]);
        dump('Images with imageables count', $usersAndCityFromImageCount);
    }
}
