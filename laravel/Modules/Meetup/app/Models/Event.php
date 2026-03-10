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
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property-read \Modules\Xot\Contracts\UserContract|null $owner
 * @property-read \Modules\Xot\Contracts\UserContract|null $organizer
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
 *
 * @property string|null $alternate_name
 * @property string|null $door_time
 * @property int $is_accessible_for_free
 * @property string|null $keywords
 * @property string|null $typical_age_range
 * @property string|null $audience
 * @property string|null $previous_start_date
 * @property string|null $registration_opens_at
 * @property string|null $registration_url
 * @property string|null $repeat_frequency
 * @property string|null $repeat_days
 * @property int|null $repeat_count
 * @property string|null $schedule_end_date
 * @property string|null $except_dates
 * @property string $schedule_timezone
 * @property int|null $super_event_id
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Snapshot> $snapshots
 * @property-read int|null $snapshots_count
 * @property-read \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<\Modules\Activity\Models\StoredEvent> $storedEvents
 * @property-read int|null $stored_events_count
 *
 * @method static \Modules\Meetup\Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static Builder<static>|Event whereAlternateName($value)
 * @method static Builder<static>|Event whereAttendeesCount($value)
 * @method static Builder<static>|Event whereAudience($value)
 * @method static Builder<static>|Event whereCoverImage($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereCreatedBy($value)
 * @method static Builder<static>|Event whereDescription($value)
 * @method static Builder<static>|Event whereDoorTime($value)
 * @method static Builder<static>|Event whereDuration($value)
 * @method static Builder<static>|Event whereEndDate($value)
 * @method static Builder<static>|Event whereEventAttendanceMode($value)
 * @method static Builder<static>|Event whereEventStatus($value)
 * @method static Builder<static>|Event whereExceptDates($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereInLanguage($value)
 * @method static Builder<static>|Event whereIsAccessibleForFree($value)
 * @method static Builder<static>|Event whereKeywords($value)
 * @method static Builder<static>|Event whereLocation($value)
 * @method static Builder<static>|Event whereLocationId($value)
 * @method static Builder<static>|Event whereMaxAttendees($value)
 * @method static Builder<static>|Event whereMetaData($value)
 * @method static Builder<static>|Event whereOffers($value)
 * @method static Builder<static>|Event wherePreviousStartDate($value)
 * @method static Builder<static>|Event whereRegistrationOpensAt($value)
 * @method static Builder<static>|Event whereRegistrationUrl($value)
 * @method static Builder<static>|Event whereRepeatCount($value)
 * @method static Builder<static>|Event whereRepeatDays($value)
 * @method static Builder<static>|Event whereRepeatFrequency($value)
 * @method static Builder<static>|Event whereScheduleEndDate($value)
 * @method static Builder<static>|Event whereScheduleTimezone($value)
 * @method static Builder<static>|Event whereSlug($value)
 * @method static Builder<static>|Event whereStartDate($value)
 * @method static Builder<static>|Event whereStatus($value)
 * @method static Builder<static>|Event whereSuperEventId($value)
 * @method static Builder<static>|Event whereTitle($value)
 * @method static Builder<static>|Event whereTypicalAgeRange($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event whereUpdatedBy($value)
 * @method static Builder<static>|Event whereUrl($value)
 * @method static Builder<static>|Event whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Event extends BaseModel
{
    use HasEvents;
    use HasSnapshots;
    use HasXotFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(static function (self $model): void {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });
    }

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
            'keywords' => 'array',
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
        'is_accessible_for_free' => 1,
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

    public function attendees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToManyX(User::class, 'event_user')
            ->withTimestamps()
            ->using(EventUser::class);
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['pending', 'draft']);
    }

    public function isFull(): bool
    {
        return $this->attendees_count >= $this->max_attendees;
    }

    public function isUserRegistered(string|int $userId): bool
    {
        return EventUser::query()
            ->where('event_id', $this->id)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Scope: filter events visible to a user.
     *
     * @param  Builder<Event>  $query
     * @param  User|null  $user
     * @return Builder<Event>
     */
    public function scopeVisibleTo(Builder $query, ?User $user = null): Builder
    {
        if ($user !== null && $user->hasRole('super-admin')) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($user): void {
            $q->where('status', 'published');

            if ($user !== null) {
                $q->orWhere('user_id', $user->id);
            }
        });
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
            'url' => LaravelLocalization::localizeUrl('/events/'.$this->slug),
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
     * Get the venue for this event.
     *
     * @return BelongsTo<Venue, $this>
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class, 'location_id', 'id');
    }

    /**
     * Get performers for this event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Performer, $this>
     */
    public function performers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToManyX(Performer::class);
    }

    /**
     * Get sponsors for this event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Sponsor, $this>
     */
    public function sponsors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToManyX(Sponsor::class);
    }

    /**
     * Generate Schema.org Event JSON-LD structured data.
     *
     * @see https://schema.org/Event
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
            'url' => LaravelLocalization::localizeUrl('/events/'.($this->slug ?? '')),
            'maximumAttendeeCapacity' => $this->max_attendees,
            'remainingAttendeeCapacity' => $this->max_attendees - $this->attendees_count,
        ];

        // Location: use Venue model if available, otherwise text
        if ($this->location_id !== null && $this->venue !== null) {
            $data['location'] = $this->venue->toSchemaOrg();
        } else {
            $data['location'] = [
                '@type' => 'Place',
                'name' => $this->location,
            ];
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

        if ($this->alternate_name !== null) {
            $data['alternateName'] = $this->alternate_name;
        }

        if ($this->door_time !== null) {
            $data['doorTime'] = $this->door_time;
        }

        $data['isAccessibleForFree'] = (bool) $this->is_accessible_for_free;

        if ($this->keywords !== null) {
            $data['keywords'] = $this->keywords;
        }

        if ($this->typical_age_range !== null) {
            $data['typicalAgeRange'] = $this->typical_age_range;
        }

        if ($this->audience !== null) {
            $data['audience'] = [
                '@type' => 'Audience',
                'audienceType' => $this->audience,
            ];
        }

        if ($this->previous_start_date !== null) {
            $data['previousStartDate'] = $this->previous_start_date;
        }

        // Performers
        if ($this->relationLoaded('performers') && $this->performers->isNotEmpty()) {
            $data['performer'] = $this->performers
                ->map(fn (Performer $p): array => $p->toSchemaOrg())
                ->values()
                ->all();
        }

        // Sponsors
        if ($this->relationLoaded('sponsors') && $this->sponsors->isNotEmpty()) {
            $data['sponsor'] = $this->sponsors
                ->map(fn (Sponsor $s): array => $s->toSchemaOrg())
                ->values()
                ->all();
        }

        // SuperEvent (series)
        if ($this->super_event_id !== null) {
            $data['superEvent'] = [
                '@type' => 'Event',
                '@id' => (string) $this->super_event_id,
            ];
        }

        return $data;
    }

    /**
     * Get social share data for this event.
     */
    public function getSocialShareData(): \Modules\Seo\Data\SocialShareData
    {
        return \Modules\Seo\Data\SocialShareData::from([
            'url' => LaravelLocalization::localizeUrl('/events/'.$this->slug),
            'title' => $this->title,
            'text' => \Illuminate\Support\Str::limit($this->description ?? '', 160),
            'image' => $this->cover_image ? asset($this->cover_image) : null,
        ]);
    }
}
