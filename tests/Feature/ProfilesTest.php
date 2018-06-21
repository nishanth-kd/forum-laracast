<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends FeatureTestCase
{
    /** @test */
    public function a_user_has_a_profile() {
        $user = create('App\User');
        $this->get($user->profile())
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_threads_posted_by_user_in_the_feed() {
        $this->signIn();
        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $this->get($thread->owner->profile())
            ->assertSee($thread->title);
    }

}
