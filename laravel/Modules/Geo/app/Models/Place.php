<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Geo\Contracts\HasGeolocation;

use function Safe\json_encode;

/**
 * @property Address|null $address
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property string $formatted_address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property Model|\Eloquent $linked
 * @property PlaceType|null $placeType
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static Builder<static>|Place newModelQuery()
 * @method static Builder<static>|Place newQuery()
 * @method static Builder<static>|Place query()
 *
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string|null $premise
 * @property string|null $premise_short
 * @property string|null $locality
 * @property string|null $locality_short
 * @property string|null $postal_town
 * @property string|null $postal_town_short
 * @property string|null $administrative_area_level_3
 * @property string|null $administrative_area_level_3_short
 * @property string|null $administrative_area_level_2
 * @property string|null $administrative_area_level_2_short
 * @property string|null $administrative_area_level_1
 * @property string|null $administrative_area_level_1_short
 * @property string|null $country
 * @property string|null $country_short
 * @property string|null $street_number
 * @property string|null $street_number_short
 * @property string|null $route
 * @property string|null $route_short
 * @property string|null $postal_code
 * @property string|null $postal_code_short
 * @property string|null $googleplace_url
 * @property string|null $googleplace_url_short
 * @property string|null $point_of_interest
 * @property string|null $point_of_interest_short
 * @property string|null $political
 * @property string|null $political_short
 * @property string|null $campground
 * @property string|null $campground_short
 * @property string|null $nearest_street
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $post_type
 * @property \Modules\Xot\Contracts\ProfileContract|null $deleter
 *
 * @method static \Modules\Geo\Database\Factories\PlaceFactory factory($count = null, $state = [])
 * @method static Builder<static>|Place whereAddress($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel1($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel1Short($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel2($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel2Short($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel3($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel3Short($value)
 * @method static Builder<static>|Place whereCampground($value)
 * @method static Builder<static>|Place whereCampgroundShort($value)
 * @method static Builder<static>|Place whereCountry($value)
 * @method static Builder<static>|Place whereCountryShort($value)
 * @method static Builder<static>|Place whereCreatedAt($value)
 * @method static Builder<static>|Place whereCreatedBy($value)
 * @method static Builder<static>|Place whereDeletedBy($value)
 * @method static Builder<static>|Place whereFormattedAddress($value)
 * @method static Builder<static>|Place whereGoogleplaceUrl($value)
 * @method static Builder<static>|Place whereGoogleplaceUrlShort($value)
 * @method static Builder<static>|Place whereId($value)
 * @method static Builder<static>|Place whereLatitude($value)
 * @method static Builder<static>|Place whereLocality($value)
 * @method static Builder<static>|Place whereLocalityShort($value)
 * @method static Builder<static>|Place whereLongitude($value)
 * @method static Builder<static>|Place whereModelId($value)
 * @method static Builder<static>|Place whereModelType($value)
 * @method static Builder<static>|Place whereNearestStreet($value)
 * @method static Builder<static>|Place wherePointOfInterest($value)
 * @method static Builder<static>|Place wherePointOfInterestShort($value)
 * @method static Builder<static>|Place wherePolitical($value)
 * @method static Builder<static>|Place wherePoliticalShort($value)
 * @method static Builder<static>|Place wherePostType($value)
 * @method static Builder<static>|Place wherePostalCode($value)
 * @method static Builder<static>|Place wherePostalCodeShort($value)
 * @method static Builder<static>|Place wherePostalTown($value)
 * @method static Builder<static>|Place wherePostalTownShort($value)
 * @method static Builder<static>|Place wherePremise($value)
 * @method static Builder<static>|Place wherePremiseShort($value)
 * @method static Builder<static>|Place whereRoute($value)
 * @method static Builder<static>|Place whereRouteShort($value)
 * @method static Builder<static>|Place whereStreetNumber($value)
 * @method static Builder<static>|Place whereStreetNumberShort($value)
 * @method static Builder<static>|Place whereUpdatedAt($value)
 * @method static Builder<static>|Place whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Place extends BaseModel implements HasGeolocation
{
    /**
     * List of address components used in the application.
     *
     * @var array<string>
     */
    public static array $address_components = [
        'premise',
        'locality',
        'postal_town',
        'administrative_area_level_3',
        'administrative_area_level_2',
        'administrative_area_level_1',
        'country',
        'street_number',
        'route',
        'postal_code',
        'point_of_interest',
        'political',
    ];

    protected $fillable = [
        'id',
        'post_id',
        'post_type',
        'model_id',
        'model_type',
        'premise',
        'locality',
        'postal_town',
        'administrative_area_level_3',
        'administrative_area_level_2',
        'administrative_area_level_1',
        'country',
        'street_number',
        'route',
        'postal_code',
        'googleplace_url',
        'point_of_interest',
        'political',
        'campground',
        'locality_short',
        'administrative_area_level_2_short',
        'administrative_area_level_1_short',
        'country_short',
        'latlng',
        'latitude',
        'longitude',
        'formatted_address',
        'nearest_street',
        'extra_data',
    ];

    /**
     * Get the linked model.
     */
    public function linked(): MorphTo
    {
        return $this->morphTo('post');
    }

    /**
     * Get the place type.
     */
    public function placeType(): BelongsTo
    {
        return $this->belongsTo(PlaceType::class, 'type_id');
    }

    /**
     * Get the address.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    #[\Override]
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    #[\Override]
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    #[\Override]
    public function getFormattedAddress(): string
    {
        return (string) ($this->formatted_address ?? $this->address->formatted_address ?? '');
    }

    public function getLatitudeAttribute(): ?float
    {
        if (! isset($this->attributes['latitude'])) {
            return null;
        }

        $latitude = $this->attributes['latitude'];
        if (! is_numeric($latitude)) {
            return null;
        }

        $latitude = (float) $latitude;

        return is_finite($latitude) && $latitude >= -90 && $latitude <= 90 ? $latitude : null;
    }

    public function getLongitudeAttribute(): ?float
    {
        if (! isset($this->attributes['longitude'])) {
            return null;
        }

        $longitude = $this->attributes['longitude'];
        if (! is_numeric($longitude)) {
            return null;
        }

        $longitude = (float) $longitude;

        return is_finite($longitude) && $longitude >= -180 && $longitude <= 180 ? $longitude : null;
    }

    public function getFormattedAddressAttribute(): string
    {
        $address = $this->attributes['formatted_address'] ?? '';

        return is_string($address) ? $address : '';
    }

    #[\Override]
    public function hasValidCoordinates(): bool
    {
        return $this->latitude !== null
            && $this->longitude !== null
            && $this->latitude >= -90
            && $this->latitude <= 90
            && $this->longitude >= -180
            && $this->longitude <= 180;
    }

    #[\Override]
    public function getMapIcon(): ?string
    {
        $slug = $this->placeType->slug ?? null;
        $type = is_string($slug) ? $slug : 'default';
        $markerConfig = config("geo.markers.types.{$type}");

        if (! is_array($markerConfig)) {
            $markerConfig = config('geo.markers.types.default');
        }

        if (! is_array($markerConfig)) {
            return null;
        }

        $icon = $markerConfig['icon'] ?? null;

        if (is_array($icon)) {
            return json_encode($icon);
        }

        return is_string($icon) ? $icon : null;
    }

    #[\Override]
    public function getLocationType(): ?string
    {
        $name = $this->placeType->name ?? null;

        return is_string($name) ? $name : null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'extra_data' => 'array',
        ];
    }
}
