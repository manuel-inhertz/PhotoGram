<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowsController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        //Authorize user to only follow other users
    	if (auth()->user()->id == $user->id) {
            return response('Unauthorized.', 401);
        }
        return auth()->user()->following()->toggle($user->profile);
    }
}
