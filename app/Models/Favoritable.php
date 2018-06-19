<?php

namespace App\Models;

trait Favoritable {

    public function favorites() {
        return $this->morphMany('App\Models\Favorite', 'favorited');
    }

    public function isFavorited() {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function favorite() {
        if(! $this->isFavorited()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function getFavoritesCountAttribute() {
        return $this->favorites->count();
    }
}