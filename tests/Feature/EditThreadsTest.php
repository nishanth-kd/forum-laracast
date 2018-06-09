<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EditThreadsTest extends FeatureTestCase
{
    /** @test */
    public function an_authenticated_thread_owner_can_edit_a_thread() {
        $user = create('App\User');
        $this->signIn($user);
        $thread = create('App\Models\Thread', ['user_id' => $user->id]);
        $this->get($thread->path())
            ->assertSee('Edit Thread');
    }

    /** @test */
    public function a_guest_cant_edit_a_thread() {
        $this->withoutExceptionHandling();
        $user = create('App\User');
        $thread = create('App\Models\Thread', ['user_id' => $user->id]);
        $this->get($thread->path())
            ->assertDontSee('Edit Thread');
    }

    /** @test */
    public function an_authenticated_user_but_not_owner_cant_edit_a_thread() {
        $this->withoutExceptionHandling();
        $this->signIn();
        
        $user = create('App\User');
        $thread = create('App\Models\Thread', ['user_id' => $user->id]);
        $this->get($thread->path())
            ->assertDontSee('Edit Thread');
    }

}
