<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters{
    
    protected $filters = ['by', 'popularity', 'unanswered'];

    public function by($username) {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    public function popularity($popularity) {
        return $this->builder->orderBy('replies_count', 'desc');
    }

    public function unanswered($unanswered) {
        return $this->builder->where('replies_count', 0);
    }
}