<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
    ];
}
