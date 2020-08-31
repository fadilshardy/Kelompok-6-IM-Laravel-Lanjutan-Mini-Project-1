<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User')->middleware('auth.role:user')->group(function () {
    Route::get('user', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
});

Route::namespace('Movie')->middleware('auth.role:admin')->group(function () {
    Route::post('movie/store', 'MovieController@store');
    Route::patch('movie/update/{rating}', 'MovieController@update');
    Route::delete('movie/delete/{id}', 'MovieController@destroy');
});

Route::namespace('watchlist')->middleware('auth.role:user')->group(function () {
    Route::post('watchlist/{id}', 'WatchlistController@store');
    Route::delete('watchlist/delete/{id}', 'WatchlistController@destroy');
});

Route::namespace('Rating')->middleware('auth.role:user')->group(function () {
    Route::post('rating', 'RatingController@store');
    Route::delete('rating/delete/{id}', 'RatingController@destroy');
    Route::patch('rating/update/{id}', 'RatingController@update');
});

Route::middleware('auth.role:admin')->group(function () {
    Route::patch('update-user/{id}', 'UserController@update');
    Route::delete('delete-user/{id}', 'UserController@destroy');
});

Route::post('logout', 'Auth\LogoutController')->middleware('auth.role:user');

// Public Route
Route::get('rating/{rating}', 'Rating\RatingController@show');
Route::get('watchlist/{id}', 'Watchlist\WatchlistController@show');

Route::post('register', 'Auth\RegisterController');
Route::post('login', 'Auth\LoginController');

Route::namespace('Movie')->group(function () {
    Route::get('movie', 'MovieController@index');
    Route::get('movie/{movie}', 'MovieController@show');
});
