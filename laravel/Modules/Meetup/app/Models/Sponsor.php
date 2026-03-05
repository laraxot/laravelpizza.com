<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modules\Meetup\Models\Sponsor.
 *
 * Represents companies or organizations sponsoring events.
 *
 * @property string $id
 * @property string $name
 * @property string|null $level
 * @property string|null $website
 * @property string|null $logo
 * @property string|null $description
 * @property string|null $email
 * @property string|null $contact_person
 * @property array<array-key, mixed>|null $meta_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder<Sponsor> newModelQuery()
 * @method static Builder<Sponsor> newQuery()
 * @method static Builder<Sponsor> query()
 *
 * @mixin \Eloquent
 */
class Sponsor extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'level',
        'website',
        'logo',
        'description',
        'contact_email',
        'contact_name',
        'order',
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
     * Get events where this sponsor is linked.
     *
     * @return BelongsToMany<Event, $this>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToManyX(Event::class, 'event_sponsor')->withTimestamps();
    }
}
