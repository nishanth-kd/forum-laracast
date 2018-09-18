<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class ReadThreadsTest extends FeatureTestCase
{
    public function setUp() {
        parent::setUp();
        $this->thread = create('App\Models\Thread');
        $this->reply = create('App\Models\Reply', ['thread_id' => $this->thread->id]);
    }

    /** @test */
    public function a_user_can_filter_threads_based_on_channel() {
        $this->withoutExceptionHandling();
        $channel = create('App\Models\Channel');
        $threadInChannel = create('App\Models\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Models\Thread');
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
        
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads/')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_username() {
        $this->withoutExceptionHandling();
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Models\Thread');

        $this->get('/threads?by=' . auth()->user()->name)
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity() {
        $threadWith0Replies = create('App\Models\Thread');
        $threadWith3Replies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWith3Replies->id], 3);
        $threadWith2Replies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWith2Replies->id], 2);
        $response = $this->getJson('threads?popularity=1')->json();
        $this->assertEquals([3, 2, 1, 0], array_column($response, 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_unanswered() {
        $threadWith0Replies = create('App\Models\Thread');
        $threadWith3Replies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWith3Replies->id], 3);
        $threadWith2Replies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWith2Replies->id], 2);
        $response = $this->getJson('threads?unanswered=1')->json();
        //dd(array_column($response, 'replies_count'));
        $this->assertCount(1, $response);
    }

}
