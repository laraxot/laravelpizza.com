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
 * @method static Builder<Venue> newModelQuery()
 * @method static Builder<Venue> newQuery()
 * @method static Builder<Venue> query()
 * @property string|null $user_id
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Meetup\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Meetup\Database\Factories\VenueFactory factory($count = null, $state = [])
 * @method static Builder<static>|Venue whereAddress($value)
 * @method static Builder<static>|Venue whereCapacity($value)
 * @method static Builder<static>|Venue whereCity($value)
 * @method static Builder<static>|Venue whereCountry($value)
 * @method static Builder<static>|Venue whereCreatedAt($value)
 * @method static Builder<static>|Venue whereCreatedBy($value)
 * @method static Builder<static>|Venue whereDescription($value)
 * @method static Builder<static>|Venue whereId($value)
 * @method static Builder<static>|Venue whereLatitude($value)
 * @method static Builder<static>|Venue whereLongitude($value)
 * @method static Builder<static>|Venue whereMetaData($value)
 * @method static Builder<static>|Venue whereName($value)
 * @method static Builder<static>|Venue wherePhone($value)
 * @method static Builder<static>|Venue whereUpdatedAt($value)
 * @method static Builder<static>|Venue whereUpdatedBy($value)
 * @method static Builder<static>|Venue whereUserId($value)
 * @method static Builder<static>|Venue whereWebsite($value)
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
        return $this->hasMany(Event::class, 'location_id', 'id');
    }

    /**
     * Generate Schema.org Place JSON-LD structured data.
     *
     * @see https://schema.org/Place
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        $data = [
            '@type' => 'Place',
            'name' => $this->name,
        ];

        if ($this->address !== null || $this->city !== null || $this->country !== null) {
            $data['address'] = array_filter([
                '@type' => 'PostalAddress',
                'streetAddress' => $this->address,
                'addressLocality' => $this->city,
                'addressCountry' => $this->country,
            ]);
        }

        if ($this->latitude !== null && $this->longitude !== null) {
            $data['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ];
        }

        if ($this->capacity !== null) {
            $data['maximumAttendeeCapacity'] = $this->capacity;
        }

        if ($this->phone !== null) {
            $data['telephone'] = $this->phone;
        }

        if ($this->website !== null) {
            $data['url'] = $this->website;
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        return $data;
    }
}
