<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Activity\Traits\HasEvents;
use Modules\Activity\Traits\HasSnapshots;
use Modules\Geo\Models\Place as GeoPlace;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Enums\RepeatFrequency;
use Modules\User\Models\User;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * Modules\Meetup\Models\Event.
 *
 * Schema.org Event implementation with structured data support.
 *
 * @property int $id
 * @property string $title
 * @property string|null $alternate_name
 * @property string|null $description
 * @property string $in_language
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string|null $duration
 * @property string|null $location
 * @property int|null $location_id
 * @property string $status
 * @property EventStatus $event_status
 * @property EventAttendanceMode $event_attendance_mode
 * @property int $attendees_count
 * @property int $max_attendees
 * @property string|null $cover_image
 * @property string|null $url
 * @property array|null $offers
 * @property array|null $meta_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property int|null $organizer_id
 * @property Carbon|null $door_time
 * @property bool $is_accessible_for_free
 * @property array|null $keywords
 * @property string|null $typical_age_range
 * @property string|null $audience
 * @property int|null $remaining_attendee_capacity
 * @property int|null $maximum_physical_attendee_capacity
 * @property int|null $maximum_virtual_attendee_capacity
 * @property int|null $super_event_id
 * @property Carbon|null $previous_start_date
 * @property Carbon|null $registration_opens_at
 * @property string|null $registration_url
 * @property RepeatFrequency|null $repeat_frequency
 * @property array|null $repeat_days
 * @property int|null $repeat_count
 * @property Carbon|null $schedule_end_date
 * @property array|null $except_dates
 * @property string $schedule_timezone
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $owner
 * @property-read User|null $organizer
 * @property-read GeoPlace|null $venue
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $attendees
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $performers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $sponsors
 * @property-read Event|null $superEvent
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
class Event extends BaseModel
{
    use HasEvents;
    use HasSnapshots;
    use HasXotFactory;

    protected $table = 'meetup_events';

    /** @var list<string> */
    protected $fillable = [
        'title',
        'alternate_name',
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
        'super_event_id',
        'door_time',
        'is_accessible_for_free',
        'keywords',
        'typical_age_range',
        'audience',
        'previous_start_date',
        'registration_opens_at',
        'registration_url',
        'repeat_frequency',
        'repeat_days',
        'repeat_count',
        'schedule_end_date',
        'except_dates',
        'schedule_timezone',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'meta_data' => 'array',
            'offers' => 'array',
            'attendees_count' => 'integer',
            'max_attendees' => 'integer',
            'event_status' => EventStatus::class,
            'event_attendance_mode' => EventAttendanceMode::class,
            'repeat_frequency' => RepeatFrequency::class,
            'repeat_days' => 'array',
            'except_dates' => 'array',
            'repeat_count' => 'integer',
            'schedule_end_date' => 'datetime',
            'door_time' => 'datetime',
            'is_accessible_for_free' => 'boolean',
            'keywords' => 'array',
            'previous_start_date' => 'datetime',
            'registration_opens_at' => 'datetime',
            'registration_url' => 'string',
            'alternate_name' => 'string',
            'audience' => 'string',
            'typical_age_range' => 'string',
        ]);
    }

    /** @var array<string, mixed> */
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

    public function venue(): BelongsTo
    {
        return $this->belongsTo(GeoPlace::class, 'location_id', 'id');
    }

    public function superEvent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'super_event_id');
    }

    public function subEvents(): HasMany
    {
        return $this->hasMany(self::class, 'super_event_id');
    }

    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    public function performers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_performer');
    }

    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_sponsor');
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
            'eventStatus' => $this->event_status->toSchemaOrgUri(),
            'eventAttendanceMode' => $this->event_attendance_mode->toSchemaOrgUri(),
        ];

        if ($this->hasEventScheduleSchemaOrg()) {
            $data['eventSchedule'] = $this->getEventScheduleSchemaOrg();
        } else {
            $data['startDate'] = $this->start_date->toIso8601String();
            $data['endDate'] = $this->end_date->toIso8601String();
        }

        $locationSchema = $this->getLocationSchemaOrg();
        if ($locationSchema !== null) {
            $data['location'] = $locationSchema;
        }

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
            ];
        }

        if ($this->offers !== null) {
            $offers = $this->normalizeOffersSchemaOrg($this->offers);
            if ($offers !== null) {
                $data['offers'] = $offers;
            }
        }

        $url = $this->url;
        if (is_string($url) && $url !== '') {
            $data['url'] = $url;
            $data['mainEntityOfPage'] = $url;
        }

        $inLanguage = $this->in_language;
        if (! (is_string($inLanguage) && $inLanguage !== '')) {
            $inLanguage = (string) (config('app.locale') ?? 'it');
        }
        $data['inLanguage'] = $inLanguage;

        if ($this->duration !== null) {
            $data['duration'] = $this->duration;
        }

        $data['maximumAttendeeCapacity'] = $this->max_attendees;
        $data['remainingAttendeeCapacity'] = max(0, $this->max_attendees - $this->attendees_count);
        $data['isAccessibleForFree'] = $this->deriveIsAccessibleForFree();

        // Additional Schema.org properties
        if ($this->door_time !== null) {
            $data['doorTime'] = $this->door_time->toIso8601String();
        }

        if ($this->keywords !== null && $this->keywords !== []) {
            $data['keywords'] = $this->keywords;
        }

        if ($this->super_event_id !== null) {
            $superEvent = $this->superEvent;
            if ($superEvent instanceof self) {
                $data['superEvent'] = [
                    '@type' => 'Event',
                    'name' => $superEvent->title,
                ];

                if ($superEvent->start_date instanceof Carbon) {
                    $data['superEvent']['startDate'] = $superEvent->start_date->toIso8601String();
                }

                if ($superEvent->end_date instanceof Carbon) {
                    $data['superEvent']['endDate'] = $superEvent->end_date->toIso8601String();
                }
            }
        }

        // Capacity specifications
        if ($this->maximum_physical_attendee_capacity !== null) {
            $data['maximumPhysicalAttendeeCapacity'] = $this->maximum_physical_attendee_capacity;
        }

        if ($this->maximum_virtual_attendee_capacity !== null) {
            $data['maximumVirtualAttendeeCapacity'] = $this->maximum_virtual_attendee_capacity;
        }

        if ($this->alternate_name !== null) {
            $data['alternateName'] = $this->alternate_name;
        }

        if ($this->audience !== null) {
            $data['audience'] = $this->audience;
        }

        if ($this->typical_age_range !== null) {
            $data['typicalAgeRange'] = $this->typical_age_range;
        }

        if ($this->attendees()->exists()) {
            $data['attendee'] = $this->attendees->map(function (Model $user): array {
                /** @var User $user */
                return [
                    '@type' => 'Person',
                    'name' => $user->name,
                ];
            })->all();
        }

        if ($this->performers()->exists()) {
            $data['performer'] = $this->performers->map(function (Model $user): array {
                /** @var User $user */
                return [
                    '@type' => 'Person',
                    'name' => $user->name,
                ];
            })->all();
        }

        if ($this->sponsors()->exists()) {
            $data['sponsor'] = $this->sponsors->map(function (Model $user): array {
                /** @var User $user */
                return [
                    '@type' => 'Person',
                    'name' => $user->name,
                ];
            })->all();
        }

        return $data;
    }

    /**
     * Derive isAccessibleForFree from offers (price 0 or missing).
     */
    private function deriveIsAccessibleForFree(): bool
    {
        if ($this->offers === null || $this->offers === []) {
            return true;
        }
        $first = array_is_list($this->offers)
            ? ($this->offers[0] ?? [])
            : $this->offers;
        if (! is_array($first)) {
            return true;
        }
        $price = $first['price'] ?? '0';
        return $price === 0 || $price === '0' || $price === 0.0;
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function getLocationSchemaOrg(): ?array
    {
        if ($this->event_attendance_mode === EventAttendanceMode::ONLINE) {
            $url = $this->url;
            if (is_string($url) && $url !== '') {
                return [
                    '@type' => 'VirtualLocation',
                    'url' => $url,
                ];
            }

            return null;
        }

        $venue = $this->venue;
        if ($venue instanceof GeoPlace) {
            $place = [
                '@type' => 'Place',
            ];

            $name = $venue->formatted_address ?? null;
            if (is_string($name) && $name !== '') {
                $place['name'] = $name;
            }

            if ($venue->address !== null) {
                $place['address'] = $venue->address->toSchemaOrg();
            }

            if ($venue->latitude !== null && $venue->longitude !== null) {
                $place['geo'] = [
                    '@type' => 'GeoCoordinates',
                    'latitude' => $venue->latitude,
                    'longitude' => $venue->longitude,
                ];
            }

            return $place;
        }

        $locationName = $this->location;
        if ($locationName !== '') {
            return [
                '@type' => 'Place',
                'name' => $locationName,
            ];
        }

        return null;
    }

    protected function hasEventScheduleSchemaOrg(): bool
    {
        return is_string($this->repeat_frequency) && $this->repeat_frequency !== '';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getEventScheduleSchemaOrg(): array
    {
        $schedule = [
            '@type' => 'Schedule',
            'repeatFrequency' => $this->repeat_frequency,
            'scheduleTimezone' => $this->schedule_timezone !== '' ? $this->schedule_timezone : (string) config('app.timezone'),
        ];

        $repeatDays = $this->repeat_days;
        if (is_array($repeatDays) && $repeatDays !== []) {
            $schedule['byDay'] = $repeatDays;
        }

        if ($this->start_date instanceof Carbon) {
            $schedule['startDate'] = $this->start_date->toDateString();
            $schedule['startTime'] = $this->start_date->format('H:i:s');
        }

        if ($this->end_date instanceof Carbon) {
            $schedule['endTime'] = $this->end_date->format('H:i:s');
        }

        if ($this->schedule_end_date instanceof Carbon) {
            $schedule['endDate'] = $this->schedule_end_date->toDateString();
        }

        if (is_int($this->repeat_count)) {
            $schedule['repeatCount'] = $this->repeat_count;
        }

        $exceptDates = $this->except_dates;
        if (is_array($exceptDates) && $exceptDates !== []) {
            $schedule['exceptDate'] = $exceptDates;
        }

        return $schedule;
    }

    /**
     * @param array<array-key, mixed> $offers
     *
     * @return array<array-key, mixed>|null
     */
    protected function normalizeOffersSchemaOrg(array $offers): ?array
    {
        if ($offers === []) {
            return null;
        }

        $isList = array_is_list($offers);

        if ($isList) {
            $normalized = [];
            foreach ($offers as $offer) {
                if (! is_array($offer)) {
                    continue;
                }

                if (! isset($offer['@type'])) {
                    $offer['@type'] = 'Offer';
                }

                $normalized[] = $offer;
            }

            return $normalized !== [] ? $normalized : null;
        }

        if (! isset($offers['@type'])) {
            $offers['@type'] = 'Offer';
        }

        return $offers;
    }
}
