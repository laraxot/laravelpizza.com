<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modules\Meetup\Models\Performer.
 *
 * Represents speakers, entertainers, and other performers at events.
 *
 * @property string $id
 * @property string $name
 * @property string|null $type
 * @property string|null $bio
 * @property string|null $photo
 * @property string|null $website
 * @property string|null $email
 * @property string|null $company
 * @property string|null $twitter
 * @property string|null $linkedin
 * @property string|null $github
 * @property array|null $meta_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder<Performer> newModelQuery()
 * @method static Builder<Performer> newQuery()
 * @method static Builder<Performer> query()
 * @method static Builder<Performer> byType(string $type)
 *
 * @mixin \Eloquent
 */
class Performer extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'type',
        'bio',
        'photo',
        'website',
        'email',
        'company',
        'twitter',
        'linkedin',
        'github',
        'meta_data',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meta_data' => 'array',
        ];
    }

    /**
     * Get events where this performer is scheduled.
     *
     * @return BelongsToMany<Event>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToManyX(Event::class, 'event_performer')
            ->withPivot(['role', 'order'])
            ->withTimestamps();
    }

    /**
     * Scope: filter by performer type.
     *
     * @param  Builder<Performer>  $query
     * @return Builder<Performer>
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }
}
