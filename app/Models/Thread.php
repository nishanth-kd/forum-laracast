<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'body', 'title'];
   
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
