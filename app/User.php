<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Thread;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName() {
        return 'name';
    }

    public function profile() {
        return '/profiles/' . $this->name; 
    }

    public function threads() {
        return $this->hasMany(Thread::class)->latest();
    }
}
