<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Activity;
use Illuminate\Support\Carbon;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_thread_is_created() {
        $this->signIn();
        $thread = create('App\Models\Thread');
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_reply_is_created() {
        $this->signIn();
        $reply = create('App\Models\Reply');
        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function it_records_activity_when_reply_is_favorited() {
        $reply = create('App\Models\Reply');
        $this->signIn();
        $this->get(route('favorite.reply', [$reply->id]));
        $this->assertEquals(1, Activity::count());
        $this->assertEquals(Activity::first()->subject->favorited->id, $reply->id);
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user() {
        $this->signIn();
        create('App\Models\Thread', ['user_id' => auth()->id()], 2);
        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
