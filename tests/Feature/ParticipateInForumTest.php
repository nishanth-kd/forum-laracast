<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        $this->user = factory('App\User')->create();
        $this->thread = factory('App\Models\Thread')->create();
        $this->reply = factory('App\Models\Reply')->make();
    }

    /** @test */
    public function an_authenticated_user_can_reply_on_thread()
    {
        $this->be($this->user);
        $this->a_user_posts_a_reply();
    }

    /** @test */
    public function an_unauthenticated_user_cant_reply_on_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->a_user_posts_a_reply();
    }

    public function a_user_posts_a_reply() {
        $this->post($this->thread->path() . '/replies', $this->reply->toArray());
        $this->get($this->thread->path())
            ->assertSee($this->reply->body);
    }
}
