<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Activity;

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
        $this->signIn();
        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Models\Reply', [
            'thread_id' => $thread->id,
            'user_id' => auth()->id()
        ]);
        $this->assertEquals(2, Activity::count());
        $this->delete($thread->path())
            ->assertRedirect('/threads');
        $this->assertDatabaseMissing('threads', ['id' => $thread->id])
            ->assertDatabaseMissing('replies', ['id' => $reply->id])
            ->assertDatabaseMissing('activities', [
                'subject_id' => $reply->id,
                'subject_type' => get_class($reply)
            ])
            ->assertDatabaseMissing('activities', [
                'subject_id' => $thread->id,
                'subject_type' => get_class($thread)
            ]);
        $this->assertEquals(0, Activity::count());
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
