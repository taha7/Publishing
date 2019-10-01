<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($query) {
            return $query->withCount('replies');
        });

        static::deleting(function ($thread) {
            // $thread->replies()->delete(); will not fire event for each one such (deleting activity)

            // $thread->replies->each(function ($reply) {
            //     $reply->delete();
            // });

            $thread->replies->each->delete();
        });
    }


    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Add Reply to the thread
     * @param array $reply
     * @return Reply
     */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);
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

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
