<?php

namespace App\Models;

trait CanBeFavorited {

    public function favorites() {
        return $this->morphMany(Favorite::class, 'favorited');
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

    public function getFavoritedType() {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }
}