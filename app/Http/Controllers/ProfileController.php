<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfileController extends Controller
{
    public function show (User $user) {
        return view ('profiles.show', [
            'profileUser' => $user,
            'grouped_activities' => Activity::feed($user)
        ]);
    }
}
