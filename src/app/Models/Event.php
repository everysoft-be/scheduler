<?php

namespace everysoft\dxScheduler\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $table = "everysoft_dxscheduler_events";
    protected $guarded = [];

    public function scheduler()
    {
        return $this->belongsTo(Scheduler::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'parent_id');
    }

    public function getSchedulerIdsAttribute()
    {
        $events = $this->events()->select('scheduler_id')->get();
        $ids = [];
        foreach($events as $event)
        {
            $ids[] = $event->scheduler_id;
        }
        return $ids;
    }
}