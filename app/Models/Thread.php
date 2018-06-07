<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'channel_id', 'body', 'title'];
   
    public function path() {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }
    
    public function owner() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function channel() {
        return $this->belongsTo('App\Models\Channel');
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply) {
        $this->replies()->create($reply);
    }
}
