<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Photon;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class PhotonAddressData extends Data
{
    public function __construct(
        public ?string $country,
        public ?string $city,
        public ?string $postcode,
        public ?string $street,
        public ?string $housenumber,
        public array $coordinates,
    ) {}

    /**
     * @param  array{properties: array<string, mixed>, geometry: array{coordinates: array<float>}}  $feature
     */
    public static function fromPhotonFeature(array $feature): self
    {
        if (! isset($feature['properties']) || ! is_array($feature['properties'])) {
            throw new \InvalidArgumentException('Properties mancanti nel feature');
        }
        if (! isset($feature['geometry']['coordinates']) || ! is_array($feature['geometry']['coordinates'])) {
            throw new \InvalidArgumentException('Coordinate mancanti nel feature');
        }

        $properties = $feature['properties'];
        $coordinates = $feature['geometry']['coordinates'];

        if (! isset($coordinates[0], $coordinates[1])) {
            throw new \InvalidArgumentException('Coordinate non valide');
        }

        return new self(
            country: isset($properties['country']) && is_string($properties['country']) ? $properties['country'] : null,
            city: isset($properties['city']) && is_string($properties['city']) ? $properties['city'] : null,
            postcode: isset($properties['postcode']) && is_string($properties['postcode']) ? $properties['postcode'] : null,
            street: isset($properties['street']) && is_string($properties['street']) ? $properties['street'] : null,
            housenumber: isset($properties['housenumber']) && is_string($properties['housenumber']) ? $properties['housenumber'] : null,
            coordinates: [
                'latitude' => (float) $coordinates[1],
                'longitude' => (float) $coordinates[0],
            ],
        );
    }
}
