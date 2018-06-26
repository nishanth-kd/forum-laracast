<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;
use App\Models\Reply;

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

    /** @test */
    public function authorized_user_can_update_replies() {
        $this->signIn();
        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);
        $updatedReply = 'Updated Reply';
        $this->patch('/replies/' . $reply->id, [
            'body' => $updatedReply
        ]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    /** @test */
    public function unthorized_user_cant_update_replies() {

        $reply = create('App\Models\Reply');
        $updatedReply = 'Updated Reply';
        $this->patch('/replies/' . $reply->id, [
            'body' => $updatedReply
        ])->assertRedirect('login');
        $this->signIn();
        $this->patch('/replies/' . $reply->id, [
            'body' => $updatedReply
        ])->assertStatus(403);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

}
