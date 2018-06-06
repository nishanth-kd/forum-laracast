<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class PostThreadsTest extends FeatureTestCase
{

    public function setUp() {
        parent::setUp();
        $this->thread = make('App\Models\Thread');
    }

    /** @test */
    public function an_authenticated_user_can_reply_on_thread()
    {
        $this->signIn();
        $this->postThread();
    }

    /** @test */
    public function an_guest_cant_reply_on_thread()
    {
        $this->withoutExceptionHandling()
            ->expectException('Illuminate\Auth\AuthenticationException')
            ->postThread();
    }

    /** @test */
    public function a_guest_cant_see_create_thread()
    {
        $this->get('/threads/create')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_auth_user_can_see_create_thread()
    {
        $this->signIn();
        $this->get('/threads/create')
            ->assertStatus(200);
    }

    public function postThread() {
        $thread = make('App\Models\Thread');
        $this->post('/threads/', $thread->toArray());
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
