<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function ratingForm()
    {
        return [
            'movie_id' => request('movie_id'),
            'rate' => request('rate'),
            'comment' => request('comment'),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingRequest $request)
    {
        $exist = Rating::where('user_id', Auth::user()->id)->where('movie_id', request('movie_id'))->first();

        if ($exist) {
            return 'You Already Rated this Movie';
        }

        Auth::user()->rate()->create($this->ratingForm());

        return 'Rating Created';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        $rating->likes_count = $rating->likes_count();
        return $rating;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RatingRequest $request, $id)
    {
        $rating = Rating::findOrFail($id);

        if (Gate::allows('watchlist', $rating)) {
            $rating->update($this->ratingForm());

            return 'Rating Movie Updated';
        }

        return 'Youre Not Authorized';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rate = Rating::findOrFail($id);
        $rate->delete();

        return 'Rating Deleted';
    }
}
