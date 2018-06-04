<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    
    public function path() {
        return '/threads/' . $this->id;
    }
    
    public function owner() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply) {
        $this->replies()->create($reply);
    }
}