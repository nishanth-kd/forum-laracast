<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteThreadsTest extends FeatureTestCase
{
    
    /** @test */
    public function a_thread_can_be_deleted_by_authorised_users() {
        $thread = create('App\Models\Thread');
        $this->signIn($thread->owner);
        $this->delete($thread->path())
            ->assertRedirect('/threads');
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
    }

    /** @test */
    public function deleting_a_thread_deletes_its_replies() {
        $thread = create('App\Models\Thread');
        $reply = create('App\Models\Reply', ['thread_id' => $thread->id]);
        $this->signIn($thread->owner);
        $this->delete($thread->path())
            ->assertRedirect('/threads');
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function a_thread_cant_be_deleted_by_guest() {
        $thread = create('App\Models\Thread');
        $this->delete($thread->path())
            ->assertRedirect('login');
    }

    /** @test */
    public function a_thread_cant_be_deleted_by_unauthorised_users() {
        $this->signIn();
        $thread = create('App\Models\Thread');
        $this->delete($thread->path())
            ->assertStatus(403);
    }
}
