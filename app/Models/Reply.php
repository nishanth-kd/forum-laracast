<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['body', 'user_id'];
    public function path() {
        return $this->thread->path() . '#reply' . $this->reply->id;
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }
    public function owner() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites() {
        return $this->morphMany('App\Models\Favorite', 'favorited');
    }

    public function favorite() {
        if(! $this->isFavorited()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function isFavorited() {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}
