<?php

namespace App\Filters;

use App\User;

class ThreadsFilter extends Filters
{
    protected $filters = ['by', 'popular'];

    /**
     * Filters Thre Query by a given username
     * @param string $username
     * @return mixed
     */
    protected function by($userName)
    {
        $user = User::where('name', $userName)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
