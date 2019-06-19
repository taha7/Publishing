<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Activity;
use Carbon\Carbon;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;
   
    /** @test */
    public function it_records_activity_when_thread_is_created () {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_reply_is_created () {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }
    
    /** @test */
    public function it_fetches_a_feed_for_a_specific_user () {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $threadFromWeek = create('App\Thread', [
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()->subWeek()
        ]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            $thread->created_at->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            $threadFromWeek->created_at->format('Y-m-d')
        ));
    }
}
