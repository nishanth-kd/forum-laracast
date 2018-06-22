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
    public function a_thread_cant_be_deleted_by_unauthorised_users() {
        
        $thread = create('App\Models\Thread');
        $this->delete($thread->path())
            ->assertRedirect('login');
        $this->signIn();
        $this->delete($thread->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_reply_can_be_deleted_by_authorised_users() {
        $reply = create('App\Models\Reply');
        $this->signIn($reply->owner);
        $this->delete('/replies/' . $reply->id)
            ->assertRedirect($reply->thread->path());
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function a_reply_cant_be_deleted_by_unauthorised_users() {
        $reply = create('App\Models\Reply');
        $this->delete('/replies/' . $reply->id)
            ->assertRedirect('login');
        $this->signIn();
        $this->delete('/replies/' . $reply->id)
            ->assertStatus(403);
        $this->assertDatabaseHas('replies', ['id' => $reply->id]);    
    }
}
