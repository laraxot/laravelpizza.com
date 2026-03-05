<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modules\Meetup\Models\Venue.
 *
 * @property string $id
 * @property string $name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $capacity
 * @property string|null $website
 * @property string|null $phone
 * @property string|null $description
 * @property array|null $meta_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder<Venue> newModelQuery()
 * @method static Builder<Venue> newQuery()
 * @method static Builder<Venue> query()
 *
 * @mixin \Eloquent
 */
class Venue extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'latitude',
        'longitude',
        'capacity',
        'website',
        'phone',
        'description',
        'meta_data',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'capacity' => 'integer',
            'meta_data' => 'array',
        ];
    }

    /**
     * Get events at this venue.
     *
     * @return HasMany<Event, $this>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'venue_id', 'id');
    }
}
