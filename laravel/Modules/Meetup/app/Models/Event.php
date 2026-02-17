<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

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

         * Scope a query to only include upcoming events.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeUpcoming($query)

        {

            return $query->where('start_date', '>=', \Carbon\Carbon::now());

        }

    

        /**

         * Scope a query to only include past events.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopePast($query)

        {

            return $query->where('start_date', '<', \Carbon\Carbon::now());

        }

    

        /**

         * Scope a query to filter events by status.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @param string $status

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeFilter($query, string $status)

        {

            switch ($status) {

                case 'upcoming':

                    return $this->scopeUpcoming($query);

                case 'past':

                    return $this->scopePast($query);

                case 'all':

                default:

                    return $query;

            }

        }

    

        /**

         * Scope a query to order events by a specific column.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @param string $column

         * @param string $direction

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeOrderBy($query, string $column = 'start_date', string $direction = 'asc')

        {

            $allowedColumns = ['start_date', 'end_date', 'title', 'created_at', 'updated_at'];

            $allowedDirections = ['asc', 'desc'];

            

            $column = in_array($column, $allowedColumns) ? $column : 'start_date';

            $direction = in_array($direction, $allowedDirections) ? $direction : 'asc';

            

            return $query->orderBy($column, $direction);

        }

    

        /**

         * Scope a query to limit the number of events returned.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @param int $limit

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeLimit($query, int $limit = 10)

        {

            return $query->limit($limit);

        }

    

        /**

         * Scope a query to paginate events.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @param int $perPage

         * @param int $page

         * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator

         */

        public function scopePaginate($query, int $perPage = 10, int $page = 1)

        {

            return $query->paginate($perPage, ['*'], 'page', $page);

        }

    

        /**

         * Scope a query to order by start_date (default ordering).

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeOrderByStartDate($query)

        {

            return $this->scopeOrderBy($query, 'start_date', 'asc');

        }

    

        /**

         * Scope a query to order by title.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeOrderByTitle($query)

        {

            return $this->scopeOrderBy($query, 'title', 'asc');

        }

    

        /**

         * Scope a query to order by end_date.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeOrderByEndDate($query)

        {

            return $this->scopeOrderBy($query, 'end_date', 'asc');

        }

    

        /**

         * Get a single event by slug.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @param string $slug

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeBySlug($query, string $slug)

        {

            return $query->whereHas('meta_data', function ($q) use ($slug) {

                $q->where('slug', $slug);

            });

        }

    

        /**

         * Get events for a specific date range.

         *

         * @param \Illuminate\Database\Eloquent\Builder $query

         * @param \Carbon\Carbon $startDate

         * @param \Carbon\Carbon $endDate

         * @return \Illuminate\Database\Eloquent\Builder

         */

        public function scopeDateRange($query, \Carbon\Carbon $startDate, \Carbon\Carbon $endDate)

        {

            return $query->whereBetween('start_date', [$startDate, $endDate]);

        }

    

        /**

         * Get events with pagination.

         *

         * @param int $perPage

         * @param int|null $page

         * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator

         */

        public static function getWithPagination(int $perPage = 10, int $page = null)

        {

            $query = self::query();

            return $query->paginate($perPage, ['*'], 'page', $page);

        }

    

        /**

         * Get upcoming events with pagination.

         *

         * @param int $perPage

         * @param int|null $page

         * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator

         */

        public static function getUpcomingWithPagination(int $perPage = 10, int $page = null)

        {

            $query = self::upcoming();

            return $query->paginate($perPage, ['*'], 'page', $page);

        }

    

        /**

         * Get past events with pagination.

         *

         * @param int $perPage

         * @param int|null $page

         * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator

         */

        public static function getPastWithPagination(int $perPage = 10, int $page = null)

        {

            $query = self::past();

            return $query->paginate($perPage, ['*'], 'page', $page);

        }

    

        /**

         * Get events ordered by start date.

         *

         * @param int $limit

         * @return \Illuminate\Database\Eloquent\Collection

         */

        public static function getOrderedByStartDate(int $limit = 10)

        {

            $query = self::query();

            return $query->orderBy('start_date', 'asc')->limit($limit)->get();

        }

    

        /**

         * Get upcoming events ordered by start date.

         *

         * @param int $limit

         * @return \Illuminate\Database\Eloquent\Collection

         */

        public static function getUpcomingOrderedByStartDate(int $limit = 10)

        {

            $query = self::upcoming();

            return $query->orderBy('start_date', 'asc')->limit($limit)->get();

        }

    

        /**

         * Get past events ordered by start date.

         *

         * @param int $limit

         * @return \Illuminate\Database\Eloquent\Collection

         */

        public static function getPastOrderedByStartDate(int $limit = 10)

        {

            $query = self::past();

            return $query->orderBy('start_date', 'desc')->limit($limit)->get();

        }

    

        /**

         * Get events by slug.

         *

    /**
     * Get event by slug.
     *
     * @param  string  $slug
     * @return \Modules\Meetup\Models\Event|null
     */
    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->first();
    }

    

        /**

         * Get events with ordering and limiting.

         *

         * @param string $filter

         * @param string $orderBy

         * @param string $direction

         * @param int $limit

         * @return \Illuminate\Database\Eloquent\Collection

         */

        public static function getWithOrderingAndLimit(

            string $filter = 'all',

            string $orderBy = 'start_date',

            string $direction = 'asc',

            int $limit = 10

        ) {

            $query = self::query();

            

            // Apply filter

            switch ($filter) {

                case 'upcoming':

                    $query = $query->upcoming();

                    break;

                case 'past':

                    $query = $query->past();

                    break;

                case 'all':

                default:

                    break;

            }

            

            // Apply ordering

            $allowedColumns = ['start_date', 'end_date', 'title', 'created_at', 'updated_at'];

            $allowedDirections = ['asc', 'desc'];

            

            $orderBy = in_array($orderBy, $allowedColumns) ? $orderBy : 'start_date';

            $direction = in_array($direction, $allowedDirections) ? $direction : 'asc';

            

            $query = $query->orderBy($orderBy, $direction);

            

            // Apply limit

            $query = $query->limit($limit);

            

            return $query->get();

        }

    /**
     * Transform the event model into an array compatible with CMS blocks.
     *
     * @return array<string, mixed>
     */
    public function toBlockArray(): array
    {
        $status = $this->start_date->isFuture() ? 'upcoming' : 'past';

        return [
            'status' => $status,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->start_date->format('F j, Y'),
            'time' => $this->start_date->format('g:i A').' - '.$this->end_date->format('g:i A'),
            'location' => $this->location,
            'attendees_current' => $this->attendees_count,
            'attendees_max' => $this->max_attendees,
            'url' => $this->url ?? "/it/events/".(string) $this->slug,
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
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
