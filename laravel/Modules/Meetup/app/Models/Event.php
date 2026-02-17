<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string|null $duration
 * @property string $location
 * @property int|null $location_id
 * @property string $status
 * @property EventStatus $event_status
 * @property EventAttendanceMode $event_attendance_mode
 * @property int $attendees_count
 * @property int $max_attendees
 * @property string|null $cover_image
 * @property string|null $slug
 * @property string|null $url
 * @property array<array-key, mixed>|null $offers
 * @property array<array-key, mixed>|null $meta_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property int|null $organizer_id
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $owner
 * @property-read User|null $organizer
 *
 * @method static Builder<Event> newModelQuery()
 * @method static Builder<Event> newQuery()
 * @method static Builder<Event> query()
 * @method static Builder<Event> upcoming()
 * @method static Builder<Event> past()
 * @method static Builder<Event> bySlug(string $slug)
 * @method static Builder<Event> dateRange(Carbon $startDate, Carbon $endDate)
 *
 * @see https://schema.org/Event
 */
class Event extends BaseModel
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
        'slug',
        'url',
        'offers',
        'meta_data',
        'user_id',
        'organizer_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'meta_data' => 'array',
            'offers' => 'array',
            'attendees_count' => 'integer',
            'max_attendees' => 'integer',
            'event_status' => EventStatus::class,
            'event_attendance_mode' => EventAttendanceMode::class,
        ];
    }

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
     * Scope: only upcoming events (start_date >= now).
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereNotNull('start_date')->where('start_date', '>=', Carbon::now());
    }

    /**
     * Scope: only past events (start_date < now).
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->whereNotNull('start_date')->where('start_date', '<', Carbon::now());
    }

    /**
     * Scope: find event by slug column.
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopeBySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope: filter events for a specific date range.
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopeDateRange(Builder $query, Carbon $startDate, Carbon $endDate): Builder
    {
        return $query->whereBetween('start_date', [$startDate, $endDate]);
    }

    /**
     * Get event by slug (static shortcut).
     */
    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * Transform the event model into an array compatible with CMS blocks.
     * Includes slug for SEO-friendly URL construction in templates.
     *
     * @return array<string, mixed>
     */
    public function toBlockArray(): array
    {
        $startDate = $this->start_date ?? Carbon::now();
        $endDate = $this->end_date ?? $startDate;
        $status = $startDate->isFuture() ? 'upcoming' : 'past';

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'status' => $status,
            'status_label' => ucfirst($status),
            'title' => $this->title,
            'description' => $this->description,
            'date' => $startDate->format('F j, Y'),
            'date_string' => $startDate->format('F j, Y'),
            'time' => $startDate->format('g:i A').' - '.$endDate->format('g:i A'),
            'location' => $this->location,
            'attendees_current' => $this->attendees_count,
            'attendees_max' => $this->max_attendees,
            'image' => $this->cover_image ? asset($this->cover_image) : null,
            'url' => '/'.(request()->segment(1) ?? app()->getLocale()).'/events/'.$this->slug,
        ];
    }

    /**
     * Get the route key for the model (slug for SEO-friendly URLs).
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Generate Schema.org Event JSON-LD structured data.
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        $startDate = $this->start_date ?? Carbon::now();
        $endDate = $this->end_date ?? $startDate;

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $this->title,
            'startDate' => $startDate->toIso8601String(),
            'endDate' => $endDate->toIso8601String(),
            'eventStatus' => $this->event_status->toSchemaOrgUri(),
            'eventAttendanceMode' => $this->event_attendance_mode->toSchemaOrgUri(),
            'location' => [
                '@type' => 'Place',
                'name' => $this->location,
            ],
            'url' => LaravelLocalization::localizeUrl('/events/'.($this->slug ?? '')),
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
