<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

//    protected $table = 'my_rooms';
//    protected $primaryKey = 'room_id';
//    public $timestamps = 'false';
//    protected $connection = 'sqlite';

    protected $fillable = [
        'number',
        'size',
        'price',
        'description',
    ];

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likeable');
    }
}
