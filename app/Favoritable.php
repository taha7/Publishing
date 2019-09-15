<?php

namespace App;

trait Favoritable
{

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    public function favourite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favourites()->where($attributes)->exists()) {
            return $this->favourites()->create($attributes);
        }
    }

    public function unfavourite()
    {
        $attributes = ['user_id' => auth()->id()];

        return $this->favourites()->where($attributes)->get()->each->delete();
    }

    public function isFavourited()
    {
        // return $this->favourites()->where('user_id', auth()->id())->exists();
        return !!$this->favourites->where('user_id', auth()->id())->count();
    }

    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }

    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}
