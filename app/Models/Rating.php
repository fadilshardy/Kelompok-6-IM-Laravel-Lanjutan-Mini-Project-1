<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Movie;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Model;

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

    public function like($user = null, $liked = true)
    {
        $this->likes()->updateOrCreate([
            'user_id' => $user ? $user->id : auth()->id(),
        ], [
            'liked' => $liked,
        ]);
    }

    public function dislike($user)
    {
        return $this->like($user, false);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likes_count()
    {
        $like = DB::table('likes')
            ->where('rating_id', $this->id)
            ->where('liked', '=', true)
            ->count();

        $dislike = DB::table('likes')
            ->where('rating_id', $this->id)
            ->where('liked', '=', false)
            ->count();
            
        return ['likes' => $like, 'dislikes' => $dislike];
    }

}
