<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Thread extends Model
{
    use Favoritable;

    protected $fillable = ['user_id', 'channel_id', 'body', 'title'];
    protected $with = ['owner', 'channel'];
   
    protected static function boot () {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function($thread) {
            $thread->replies()->delete();
        });
    }

    public function path() {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply) {
        $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters) {
        return $filters->apply($query);
    }
}
