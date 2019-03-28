<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** 1 */
    /** @test */
    // public function guests_may_not_create_threads()
    // {
    //     $this->expectException('Illuminate\Auth\AuthenticationException');
    //     $thread = make('App\Thread');
    //     $this->post('/threads', $thread->toArray());
    // }

    /** 1 */
    /** @test */
    // public function a_guest_cannot_see_create_thread_page () {
    //     $this->withExceptionHandling()
    //         ->get('/threads/create')
    //         ->assertRedirect('/login');
    // }

    /** merge 1 && 2 */
    /** @test */
    public function a_guest_cannot_see_create_thread_page () {

        $this->withExceptionHandling();
            $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->POST('/threads')
            ->assertRedirect('/login');
    }



    /** @test */
    public function an_auth_user_can_create_forum_threads()
    {
        //Given we have an auth user
        // $this->actingAs(create('App\User'));
        $this->signIn();
        //when hit the endpoint to create thread
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());
        // dd($response->headers->get('Location'));
        // then we visit thread page
        $this->get($response->headers->get('Location'))
        //should see the new Thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title () {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body () {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel () {

        factory('App\Channel', 2)->create();



        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread ($overrides = []) {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
    
}