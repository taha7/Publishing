<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Favourite;

class FavouriteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Reply $reply)
    {
        
        // Favourite::create([
        //     'user_id' => auth()->id(),
        //     'favourited_id' => $reply->id,
        //     'favourited_type' => get_class($reply)
        // ]);
        
        $reply->favourite();

        return back();

    }
}
