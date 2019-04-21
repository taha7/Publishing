<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;

    protected $guarded = [];
    protected $with = ['owner', 'favourites'];
    
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
