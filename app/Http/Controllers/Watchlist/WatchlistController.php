<?php
namespace App\Http\Controllers\Watchlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\WatchlistRequest;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WatchlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WatchlistRequest $request, $id)
    {
        Auth::user()->watchlist()->create([
            'movie_id' => $id,
        ]);

        return Movie::find($id)->title . ' movie is inserted to wishlist';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return Watchlist::where('user_id', Auth::user()->id)->get();

        // $watch = Watchlist::findOrFail($id);
        // if (Gate::authorize('watchlist', $watch)) {
        //     return $watch;
        // }
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

        if (Gate::authorize('watchlist', $watch)) {
            $watch->update([
                'movie_id' => request('movie'),
            ]);

            return 'Watchlist Updated';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $watch = Watchlist::findOrFail($id);
        if (Gate::authorize('watchlist', $watch)) {
            $watch->delete($id);
            return 'Watchlist Deleted';
        }
    }
}
