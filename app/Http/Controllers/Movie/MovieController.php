<?php

namespace App\Http\Controllers\Movie;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieCollection;
use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Resources\MovieResource;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movie = Movie::with(['ratings', 'avg_rating' => function ($q) {
            $q->getAvgRating()->get();
        }])->get();

        // $movie = Movie::all();

        return new MovieCollection($movie);
    }

    public function movieForm()
    {
        return [
            'title' => request('title'),
            'img_url' => request('img_url'),
            'synopsis' => request('synopsis'),
            'release_date' => request('release_date'),
            'watchtime' => request('watchtime'),
            'category' => request('category'),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {

        $category_array = explode(',', $request['category']);

        $category_ids = [];

        foreach ($category_array as $category_name) {
            $category = Category::where('name', $category_name)->first();

            if ($category) {
                $category_ids[] = $category->id;
            } else {
                $new_category = Category::create(['name' => $category_name]);
                $category_ids[] = $new_category->id;
            }
        }

        $movie = Movie::create($this->movieForm());

        $movie->categories()->sync($category_ids);

        return 'Movie Created';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $film = $movie->where('id', $movie->id)->with(['ratings', 'avg_rating' => function ($q) use ($movie) {
            $q->where('movie_id', $movie->id)->getAvgRating()->get();
        }])->first();;

        return new MovieResource($film);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MovieRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $category_array = explode(',', $request['category']);

        $category_ids = [];

        foreach ($category_array as $category_name) {
            $category = Category::where('name', $category_name)->first();

            if ($category) {
                $category_ids[] = $category->id;
            } else {
                $new_category = Category::create(['name' => $category_name]);
                $category_ids[] = $new_category->id;
            }
        }

        $movie->categories()->sync($category_ids);
        $movie->update($this->movieForm());

        return response()->json('Movie has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Movie::destroy($id);

        return 'Movie Deleted';
    }
}
