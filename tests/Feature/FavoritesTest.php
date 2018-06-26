<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends FeatureTestCase
{
    /** @test */
    public function an_authenticated_user_can_favorite_a_reply()
    {
        $reply = create('App\Models\Reply');
        $this->signIn();
        $this->post("favorite/reply/{$reply->id}");
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_thread()
    {
        $thread = create('App\Models\Thread');
        $this->signIn();
        $this->post("favorite/thread/{$thread->id}");
        $this->assertCount(1, $thread->favorites);
        $this->delete("favorite/thread/{$thread->id}");
        $this->assertCount(0, $thread->fresh()->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {
        $reply = create('App\Models\Reply');
        $this->signIn();
        $this->post("favorite/reply/{$reply->id}");
        $this->assertCount(1, $reply->favorites);
        $this->delete("favorite/reply/{$reply->id}");
        $this->assertCount(0, $reply->fresh()->favorites);
    }

    /** @test */
    public function a_guest_cant_favorite_a_reply()
    {
        $reply = create('App\Models\Reply');
        $response = $this->post("favorite/reply/{$reply->id}");
            $response->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_may_favorite_a_reply_only_once()
    {
        $this->signIn();
        $reply = create('App\Models\Reply');

        $this->post("favorite/reply/{$reply->id}");
        $this->post("favorite/reply/{$reply->id}");
        
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_favorite_a_thread()
    {
        $this->signIn();
        $thread = create('App\Models\Thread');
        $this->post(route('favorite.thread', [$thread->id]));
        $this->assertCount(1, $thread->favorites);
    }

    /** @test */
    public function a_guest_cant_favorite_a_thread()
    {
        $thread = create('App\Models\Thread');
        $response = $this->post(route('favorite.thread', [$thread->id]));
            $response->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_may_favorite_a_thread_only_once()
    {
        $this->signIn();
        $thread = create('App\Models\Thread');
        $this->post(route('favorite.thread', [$thread->id]));
        $this->post(route('favorite.thread', [$thread->id]));
        $this->assertCount(1, $thread->favorites);
    }
    
}
