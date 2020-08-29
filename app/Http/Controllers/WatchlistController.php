<?php

namespace App\Http\Controllers;

use App\Http\Requests\WatchlistRequest;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Watchlist::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WatchlistRequest $request)
    {
        // dd(Auth::user());
        Auth::user()->watchlist()->create([
            'movie_id' => request('movie_id')
        ]);

        return 'Wishlist Restored';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Watchlist::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WatchlistRequest $request, $id)
    {
        $watch = Watchlist::findOrFail($id);

        $watch->update([
            'movie_id' => request('movie')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Watchlist::destroy($id);

        return 'Watchlist Deleted';
    }
}
