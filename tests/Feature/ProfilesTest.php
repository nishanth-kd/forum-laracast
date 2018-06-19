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
    public function profiles_display_all_threads_created_by_user() {
        $this->withoutExceptionHandling();
        $thread = create('App\Models\Thread');
        $this->get($thread->owner->profile())
            ->assertSee($thread->title);
    }

}
