<?php

namespace Modules\EventAttendee\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\EventAttendee\Database\Factories\EventAttendeeFactory;

class EventAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'registration_date',
        'status',
        'ticket_type',
        'payment_status',
        'attended',
        'check_in_time',
        'notes',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
        'check_in_time' => 'datetime',
        'attended' => 'boolean',
    ];

    protected static function newFactory()
    {
        return EventAttendeeFactory::new();
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