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
    public function anyone_can_view_replies()
    {
        $response = $this->get($this->thread->path())
            ->assertSee($this->reply->body)
            ->assertSee($this->reply->owner->name);
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

}
