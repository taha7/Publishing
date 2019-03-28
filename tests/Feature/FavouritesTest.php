<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavouritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_cannot_favourite_anything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favourites')
            ->assertRedirect('/login');
    }
    /** @test */
    public function auth_can_favourite_any_reply()
    {
        $this->signIn();
        
        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favourites');

        $this->assertCount(1, $reply->favourites);
    }

    /** @test */
    public function an_auth_may_only_favourite_a_reply_once () {
        $this->signIn();
        
        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/favourites');
            $this->post('replies/' . $reply->id . '/favourites');            
        } catch (\Exception $e) {
            $this->fail('You are make a favourite twice');
        }

        $this->assertCount(1, $reply->favourites);
        
    }
}
