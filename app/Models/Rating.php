<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Movie;

class Rating extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function scopeGetAvgRating($query)
    {
        return $query->select('movie_id', \DB::raw('sum(rate)/count(user_id) AS avg_rating'))->pluck('avg_rating');
    }
}
