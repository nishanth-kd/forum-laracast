<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;
class ThreadsTest extends FeatureTestCase
{

    public function setUp() {
        parent::setUp();
        $this->thread = create('App\Models\Thread');
        $this->reply = create('App\Models\Reply', ['thread_id' => $this->thread->id]);
    }
    
    /** @test */
    public function a_thread_has_owner()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /** @test */
    public function a_reply_has_owner()
    {
        $this->assertInstanceOf('App\User', $this->reply->owner);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $user = create('App\User');
        $this->thread->addReply([
            'body' => 'Test',
            'user_id' => $user->id,
        ]);
        $this->assertCount(2, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_channel() {
        $this->assertInstanceOf('App\Models\Channel', $this->thread->channel);
    }

    /** @test */
    public function a_thread_path_should_include_channel() {
        $this->assertEquals($this->thread->path(), '/threads/' . $this->thread->channel->slug . '/' . $this->thread->id);
    }
    
}
