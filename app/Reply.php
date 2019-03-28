<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    //
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    public function favourite () {
        $attributes = ['user_id' => auth()->id()];
        if (! $this->favourites()->where($attributes)->exists()) {
           return $this->favourites()->create($attributes);
        }
    }
}
