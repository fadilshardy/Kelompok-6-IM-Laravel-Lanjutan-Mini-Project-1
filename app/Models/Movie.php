<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'category_movie', 'movie_id', 'category_id');
    }

}
