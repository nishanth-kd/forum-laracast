<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reply extends Model
{
    use CanBeFavorited, RecordsActivity;

    protected $fillable = ['body', 'user_id'];
    protected $with = ['owner', 'favorites'];
    protected $appends = ['favoritesCount', 'favoritedType', 'isFavorited'];

    protected static function boot () {
        parent::boot();

        static::created(function($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function path() {
        return $this->thread->path() . '#reply-' . $this->id;
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
