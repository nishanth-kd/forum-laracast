<?php

namespace App\Models;

trait CanBeFavorited {

    protected static function bootCanBeFavorited() {
        static::deleting(function($model) {
            $model->favorites->each->delete();
        });
    }

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
        $this->favorites()->where('user_id', auth()->id())->get()->each->delete();
    }

    public function getFavoritesCountAttribute() {
        return $this->favorites->count();
    }

    public function getFavoritedTypeAttribute() {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }
}