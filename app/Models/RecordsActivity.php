<?php

namespace App\Models;

trait RecordsActivity {

    protected static function bootRecordsActivity() {
        
        if(auth()->guest()) return;
        
        foreach(self::getRecordEvents() as $event) {
            static::$event(function($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function($model) {
            $model->activity()->delete();
        });
    }

    protected static function getRecordEvents() {
        return ['created'];
    }

    protected function recordActivity($event) {
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    public function activity() {
        return $this->morphMany('App\Models\Activity', 'subject');
    }

    protected function getActivityType($event) {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }

}