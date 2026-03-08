<?php

namespace Modules\EventAnalytics\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\EventAnalytics\Database\Factories\EventAnalyticsFactory;

class EventAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'metric_name',
        'metric_value',
        'recorded_at',
    ];

    protected $casts = [
        'metric_value' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return EventAnalyticsFactory::new();
    }

    public function event()
    {
        return $this->belongsTo(\Modules\Meetup\App\Models\Event::class);
    }
}