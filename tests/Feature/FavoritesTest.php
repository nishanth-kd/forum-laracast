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
        $this->post('replies/' . $reply->id .'/favorites');
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function a_guest_cant_favorite_a_reply()
    {
        $reply = create('App\Models\Reply');
        $response = $this->post('replies/' . $reply->id . '/favorites');
            $response->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_may_favorite_a_reply_only_once()
    {
        $this->signIn();
        $reply = create('App\Models\Reply');

        $this->post('replies/' . $reply->id .'/favorites');
        $this->post('replies/' . $reply->id .'/favorites');
        
        $this->assertCount(1, $reply->favorites);
    }
    
}
