<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        $this->thread = factory('App\Models\Thread')->create();
        $this->reply = factory('App\Models\Reply')->create(['thread_id' => $this->thread->id]);
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $response = $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_replies()
    {
        $response = $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->reply->body)
            ->assertSee($this->reply->owner->name);
    }

    /** @test */
    public function a_thread_has_owner()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /** @test */
    public function a_reply_has_owner()
    {
        $this->assertInstanceOf('App\User', $this->reply->owner);
    }

     /** @test */
     public function a_thread_can_add_a_reply()
     {
        $user = factory('App\User')->create();
        $this->thread->addReply([
            'body' => 'Test',
            'user_id' => $user->id,
        ]);

        $this->assertCount(2, $this->thread->replies);
     }
}
