<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::post('register', 'RegisterController');
    Route::post('login', 'LoginController');
    Route::post('logout', 'LogoutController');
});

Route::namespace('User')->group(function () {
    Route::get('user', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
    Route::patch('update-user/{id}', 'UserController@update');
    Route::delete('delete-user/{id}', 'UserController@destroy');
});

Route::post('movie/store', 'MovieController@store');
Route::get('movie', 'MovieController@index');
Route::get('movie/{id}', 'MovieController@show');
Route::patch('movie/update/{id}', 'MovieController@update');
Route::delete('movie/delete/{id}', 'MovieController@destroy');


Route::post('watchlist', 'WatchlistController@store');
Route::get('watchlist', 'WatchlistController@index');
Route::get('watchlist/{id}', 'WatchlistController@show');
Route::delete('watchlist/delete/{id}', 'WatchlistController@destroy');
Route::patch('watchlist/update/{id}', 'WatchlistController@update');

Route::namespace('Rating')->group(function () {
    Route::post('rating', 'RatingController@store');
    Route::get('rating', 'RatingController@show');
    Route::delete('rating/delete/{id}', 'RatingController@destroy');
    Route::patch('rating/update/{id}', 'RatingController@update');
});
// Contoh penggunaaan middleware
// Route::middleware('auth.role:admin')->group(function() {

// });
