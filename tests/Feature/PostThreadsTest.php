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
    public function an_authenticated_user_can_post_a_thread()
    {
        $this->signIn();
        $this->postThread();
    }

    /** @test */
    public function an_guest_cant_post_a_thread()
    {
        $this->withoutExceptionHandling()
            ->expectException('Illuminate\Auth\AuthenticationException');
        $this->postThread();
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

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->signIn();
        $thread = make('App\Models\Thread', ['title' => null]);
        $this->call('POST', '/threads/', $thread->toArray())
            ->assertSessionHasErrors('title');
    }

    public function postThread() {
        $thread = make('App\Models\Thread');
        $response = $this->post('/threads/', $thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
