<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];
    protected $with = ['creator', 'channel'];

    protected static function boot () {
        parent::boot();

        static::addGlobalScope('replyCount', function ($query) {
            return $query->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });
    }
    
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
    
    /**
     * ========= Relationships ========== *
     */

    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function replies()
    {
        // return $this->hasMany(Reply::class)->withCount('favourites')->with('owner');
        return $this->hasMany(Reply::class);
    }

    public function channel () {
        return $this->belongsTo('App\Channel');
    }

    public function scopeFilter($query, $filters) {
        return $filters->apply($query);
    } 
}