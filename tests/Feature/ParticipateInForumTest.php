<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauth_cannot_add_reply()
    {
        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->withExceptionHandling()
            ->post($thread->path() . '/replies', $reply->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_auth_user_can_participate_in_forum_threads()
    {
        //Given we have an auth user
        $this->be($user = factory('App\User')->create());
        //And an existing threads
        $thread = factory('App\Thread')->create();
        //when the user adds a reply to thread
        $reply = factory('App\Reply')->make();
        $this->post($thread->path() . '/replies', $reply->toArray()); 
        // then expect to see the reply in the page 
        $this->get($thread->path())->assertSee($reply->body);
    }

    /** test */
    public function a_reply_requires_a_body () {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');
        
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}