<?php

namespace Modules\EventOrganizer\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\XotBaseModel;

class EventOrganizer extends XotBaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'organization',
        'website',
        'description',
        'event_id',
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'organization' => 'string',
        'website' => 'string',
        'description' => 'string',
        'event_id' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(\Modules\EventCategory\App\Models\Event::class);
    }
}