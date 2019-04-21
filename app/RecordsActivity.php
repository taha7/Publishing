<?php
namespace App;

trait RecordsActivity {

    //laravel will deal with this as static boot method in model
    protected static function bootRecordsActivity () {
        if(auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event); 
            });
        }
    }

    protected static function getActivitiesToRecord () {
        return ['created'];
    }

    protected function recordActivity ($event) {
        
        //It uses polymorphism search how
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);

        // Activity::create([
        //     'type' => $this->getActivityType($event),
        //     'user_id' => auth()->id(),
        //     'subject_id' => $this->id,
        //     'subject_type' => get_class($this)
        // ]);
    }

    public function activity () {
        return $this->morphMany('App\Activity', 'subject');
    }
    protected function getActivityType ($event) {
       $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}" ;
    }
}