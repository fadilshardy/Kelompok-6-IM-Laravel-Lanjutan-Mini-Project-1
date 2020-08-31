<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];

    public function routeGetKeyName()
    {
        return 'id';
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_movie', 'movie_id', 'category_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function avg_rating()
    {
        return $this->ratings();
    }
}
