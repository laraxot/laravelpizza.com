<?php

namespace Modules\EventNotification\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\EventNotification\Database\Factories\EventNotificationFactory;

class EventNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
        'read_at',
        'sent_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return EventNotificationFactory::new();
    }

    public function event()
    {
        return $this->belongsTo(\Modules\Meetup\App\Models\Event::class);
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\App\Models\User::class);
    }
}