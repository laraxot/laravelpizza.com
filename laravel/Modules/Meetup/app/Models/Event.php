<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\User\Models\User;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Activity\Traits\HasEvents;
use Modules\Activity\Traits\HasSnapshots;

/**
 * Modules\Meetup\Models\Event.
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $location
 * @property string $status
 * @property int $attendees_count
 * @property int $max_attendees
 * @property string|null $cover_image
 * @property array<array-key, mixed>|null $meta_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $owner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAttendeesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMaxAttendees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 */
class Event extends Model
{
    use HasXotFactory;
    use HasEvents;
    use HasSnapshots;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'status',
        'attendees_count',
        'max_attendees',
        'cover_image',
        'meta_data',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'meta_data' => 'array',
        'attendees_count' => 'integer',
        'max_attendees' => 'integer',
    ];

    protected $attributes = [
        'attendees_count' => 0,
        'max_attendees' => 100,
        'status' => 'draft',
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
}