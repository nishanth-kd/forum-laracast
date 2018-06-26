<?php

namespace App\Models;

trait CanBeFavorited {

    public function favorites() {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function getIsFavoritedAttribute() {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function favorite() {
        if(! $this->is_favorited) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function unfavorite() {
        //$this->favorites()->delete(['user_id' => auth()->id()]);
        $this->favorites()->where('user_id', auth()->id())->delete();
    }

    public function getFavoritesCountAttribute() {
        return $this->favorites->count();
    }

    public function getFavoritedTypeAttribute() {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }
}