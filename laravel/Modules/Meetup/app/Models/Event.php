<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Traits\HasEvents;
use Modules\Activity\Traits\HasSnapshots;
use Modules\Cms\Models\Page;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Seo\Datas\SocialShareData;
use Modules\User\Models\User;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection;

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
 * @property string|null $user_id
 * @property string|null $organizer_id
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @property-read UserContract|null $owner
 * @property-read UserContract|null $organizer
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
 * @property-read ProfileContract|null $deleter
 * @property-read Collection<int, Snapshot> $snapshots
 * @property-read int|null $snapshots_count
 * @property-read EloquentStoredEventCollection<StoredEvent> $storedEvents
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
 * @property-read EventSponsor|EventPerformer|EventUser|null $pivot
 * @property-read Collection<int, User> $attendees
 * @property-read Collection<int, EventUser> $registrations
 * @property-read int|null $registrations_count
 * @property-read Collection<int, Performer> $performers
 * @property-read int|null $performers_count
 * @property-read Collection<int, Sponsor> $sponsors
 * @property-read int|null $sponsors_count
 * @property-read Venue|null $venue
 *
 * @method static Builder<static>|Event visibleTo(?\Modules\User\Models\User $user = null)
 * @method static Builder<static>|Event whereOrganizerId($value)
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
            $model->slug = self::uniqueSlug(Str::slug(empty($model->slug) ? $model->title : $model->slug));
        });
    }

    /**
     * Slug libero per un nuovo evento: due meetup con lo stesso titolo (es. "Laravel Pizza Milano")
     * non devono condividere l'URL /events/{slug}. Il secondo diventa "...-2", poi "-3" e cosi' via.
     */
    public static function uniqueSlug(string $base): string
    {
        $base = $base === '' ? 'evento' : $base;
        $slug = $base;
        $suffix = 2;

        // Le sotto-pagine CMS di /events (pages/events/my.json -> /events/my, past, view) occupano lo stesso spazio di URL
        // degli eventi: un evento con slug "my" renderebbe irraggiungibile "I miei eventi".
        $reserved = Page::query()->where('slug', 'like', 'events.%')->pluck('slug')
            ->filter(static fn (mixed $pageSlug): bool => \is_string($pageSlug))
            ->map(static fn (string $pageSlug): string => substr($pageSlug, strlen('events.')))
            ->all();

        while (in_array($slug, $reserved, true) || self::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
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

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id', 'id');
    }

    /**
     * Iscrizioni come righe della pivot: a differenza di attendees() non fa join con `users`,
     * che vive su un altro database, quindi funziona per conteggi, tabelle ed export.
     *
     * @return HasMany<EventUser, $this>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventUser::class, 'event_id', 'id');
    }

    /**
     * @return BelongsToMany<User, $this, EventUser, 'pivot'>
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToManyX(User::class, 'event_user')
            ->withTimestamps()
            ->using(EventUser::class);
    }

    /**
     * Proposta in attesa di approvazione (ProposeMeetupAction). Una bozza dell'organizzatore non lo e':
     * non si approva ne' si rifiuta, si pubblica dal pannello.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFull(): bool
    {
        return $this->attendees_count >= $this->max_attendees;
    }

    public function isUserRegistered(string|int $userId): bool
    {
        // Interroga direttamente la pivot: la relazione attendees() fa join con la tabella users,
        // che vive su un'altra connessione/database (user) e falliva in silenzio, restituendo false.
        return EventUser::query()
            ->where('event_id', $this->getKey())
            ->where('user_id', (string) $userId)
            ->exists();
    }

    /**
     * Scope: events visible to a specific user.
     * Super-admin sees all; published events are public; draft/pending only for owner.
     *
     * @param  Builder<Event>  $query
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
                $q->orWhere(function (Builder $sub) use ($user): void {
                    $sub->whereIn('status', ['pending', 'draft'])
                        ->where('user_id', $user->id);
                });
            }
        });
    }

    /**
     * Scope: only published events.
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
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
        $timingStatus = $startDate->isFuture() ? 'upcoming' : 'past';
        $localStart = $startDate->copy();
        $localStart->locale(app()->getLocale());
        $localEnd = $endDate->copy();
        $localEnd->locale(app()->getLocale());

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'timing_status' => $timingStatus,
            'status' => $this->status, // draft, pending, published
            'status_label' => __('meetup::event_form.fields.status.options.'.$this->status),
            'title' => $this->title,
            'description' => $this->description,
            // Formati ISO dipendenti dalla lingua corrente: "17 novembre 2026" / "November 17, 2026", "19:00" / "7:00 PM"
            'date' => $localStart->isoFormat('LL'),
            'date_string' => $localStart->isoFormat('LL'),
            'time' => $localStart->isoFormat('LT').' - '.$localEnd->isoFormat('LT'),
            'location' => $this->location,
            'attendees_current' => $this->attendees_count,
            'attendees_max' => $this->max_attendees,
            'image' => $this->coverImageUrl(),
            'url' => LaravelLocalization::localizeUrl('/events/'.$this->slug),
        ];
    }

    /**
     * URL pubblico della copertina: le immagini caricate dal pannello stanno sul disco `public`
     * (servono `php artisan storage:link`); URL assoluti e percorsi gia' pubblici restano com'erano.
     */
    public function coverImageUrl(): ?string
    {
        $path = $this->cover_image;
        if ($path === null || $path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
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
     * @return BelongsToMany<Performer, $this>
     */
    public function performers(): BelongsToMany
    {
        return $this->belongsToManyX(Performer::class);
    }

    /**
     * Get sponsors for this event.
     *
     * @return BelongsToMany<Sponsor, $this>
     */
    public function sponsors(): BelongsToMany
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

        $image = $this->coverImageUrl();
        if ($image !== null) {
            $data['image'] = [$image];
        }

        if ($this->organizer !== null) {
            $organizerData = [
                '@type' => 'Person',
                'name' => $this->organizer->name,
            ];

            // Add profile URL if available (Schema.org recommends URL for organizers)
            $organizerRouteKeyValue = $this->organizer->getRouteKey();
            $organizerRouteKey = is_string($organizerRouteKeyValue)
                ? $organizerRouteKeyValue
                : (is_int($organizerRouteKeyValue) ? (string) $organizerRouteKeyValue : '');
            $organizerProfileUrl = LaravelLocalization::localizeUrl('/profile/'.$organizerRouteKey);
            $organizerData['url'] = $organizerProfileUrl;

            // Niente email nel JSON-LD: la pagina e' pubblica e indicizzata, l'indirizzo finirebbe agli spammer (S-10).

            $data['organizer'] = $organizerData;
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
    public function getSocialShareData(): SocialShareData
    {
        return SocialShareData::from([
            'url' => LaravelLocalization::localizeUrl('/events/'.$this->slug),
            'title' => $this->title,
            'text' => Str::limit($this->description ?? '', 160),
            'image' => $this->coverImageUrl(),
        ]);
    }
}
