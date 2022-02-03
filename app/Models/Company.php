<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function reservations()
    {
        return $this->hasManyThrough(RoomReservation::class, User::class); // 'company_id', 'user_id', 'id', 'id'
    }
}
