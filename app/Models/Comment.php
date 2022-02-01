<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Comment extends Model
{
    use HasFactory;

    /**
     * Global scope. Always will run then call model.
     */
//    protected static function booted()
//    {
//        static::addGlobalScope('rating', function (Builder $builder){
//           $builder->where('rating', '>', 2);
//        });
//    }

    protected $fillable = [
        'user_id',
        'content',
        'rating',
    ];

    public function scopeRating($query, int $value = 4)
    {
        return $query->where('rating', '>', $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userCountry()
    {
        return $this->hasOneThrough(Address::class, User::class, 'id', 'user_id', 'user_id', 'id')
            ->select('country as name');
    }
}
