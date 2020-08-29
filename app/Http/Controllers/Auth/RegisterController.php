<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        User::create([
            'username' => request('username'),
            'email' => request('email'),
            'name' => request('name'),
            'password' => bcrypt(request('password')),
            'phone' => request('phone'),
        ]);

        return response('You have been successfully registered.');
    }
}
