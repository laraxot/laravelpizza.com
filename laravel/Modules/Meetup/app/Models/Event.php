<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Activity\Traits\HasEvents;
use Modules\Activity\Traits\HasSnapshots;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\User\Models\User;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * Modules\Meetup\Models\Event.
 *
 * Schema.org Event implementation with structured data support.
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $in_language
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string|null $duration
 * @property string $location
 * @property int|null $location_id
 * @property string $status
 * @property EventStatus $event_status
 * @property EventAttendanceMode $event_attendance_mode
 * @property int $attendees_count
 * @property int $max_attendees
 * @property string|null $cover_image
 * @property string|null $url
 * @property array<array-key, mixed>|null $offers
 * @property array<array-key, mixed>|null $meta_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property int|null $organizer_id
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $owner
 * @property-read User|null $organizer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAttendeesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventAttendanceMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereInLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMaxAttendees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereOffers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereOrganizerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 *
 * @see https://schema.org/Event
 */
class Event extends Model
{
    use HasEvents;
    use HasSnapshots;
    use HasXotFactory;

    protected $fillable = [
        'title',
        'description',
        'in_language',
        'start_date',
        'end_date',
        'duration',
        'location',
        'location_id',
        'status',
        'event_status',
        'event_attendance_mode',
        'attendees_count',
        'max_attendees',
        'cover_image',
        'url',
        'offers',
        'meta_data',
        'user_id',
        'organizer_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'meta_data' => 'array',
        'offers' => 'array',
        'attendees_count' => 'integer',
        'max_attendees' => 'integer',
        'event_status' => EventStatus::class,
        'event_attendance_mode' => EventAttendanceMode::class,
    ];

    protected $attributes = [
        'attendees_count' => 0,
        'max_attendees' => 100,
        'status' => 'draft',
        'event_status' => 'EventScheduled',
        'event_attendance_mode' => 'OfflineEventAttendanceMode',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id', 'id');
    }

    /**
     * Generate Schema.org Event JSON-LD structured data.
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $this->title,
            'startDate' => $this->start_date->toIso8601String(),
            'endDate' => $this->end_date->toIso8601String(),
            'eventStatus' => $this->event_status->toSchemaOrgUri(),
            'eventAttendanceMode' => $this->event_attendance_mode->toSchemaOrgUri(),
            'location' => [
                '@type' => 'Place',
                'name' => $this->location,
            ],
        ];

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        if ($this->cover_image !== null) {
            $data['image'] = [asset($this->cover_image)];
        }

        if ($this->organizer !== null) {
            $data['organizer'] = [
                '@type' => 'Person',
                'name' => $this->organizer->name,
                'email' => $this->organizer->email,
            ];
        }

        if ($this->offers !== null) {
            $data['offers'] = $this->offers;
        }

        if ($this->url !== null) {
            $data['url'] = $this->url;
        }

        if ($this->in_language !== null) {
            $data['inLanguage'] = $this->in_language;
        }

        if ($this->duration !== null) {
            $data['duration'] = $this->duration;
        }

        $data['maximumAttendeeCapacity'] = $this->max_attendees;

        return $data;
    }
}
