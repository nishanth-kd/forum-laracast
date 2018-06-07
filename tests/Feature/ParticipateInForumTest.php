<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class ParticipateInForumTest extends FeatureTestCase
{
    
    public function setUp() {
        parent::setUp();
        $this->thread = create('App\Models\Thread');
        $this->reply = make('App\Models\Reply');
    }

    public function postReply() {
        $this->post($this->thread->path() . '/replies', $this->reply->toArray());
        $this->get($this->thread->path())
            ->assertSee($this->reply->body);
    }

    /** @test */
    public function an_authenticated_user_can_reply_on_thread()
    {
        $this->signIn()
            ->postReply();
    }

    /** @test */
    public function an_unauthenticated_user_cant_reply_on_thread()
    {
        $this->withoutExceptionHandling()
            ->expectException('Illuminate\Auth\AuthenticationException');
        $this->postReply();
    }

}
