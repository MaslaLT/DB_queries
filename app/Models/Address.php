<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'street',
        'user_id',
        'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([ // With default only works for: belongsTo, hasOne, hasOneThrough, and morphOne
            'country' => 'no address attached yet'
        ]);
//        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
