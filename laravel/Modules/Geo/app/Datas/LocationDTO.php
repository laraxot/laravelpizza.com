<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

readonly class LocationDTO
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?string $address = null,
        public ?string $city = null,
        public ?string $country = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
            'city' => $city,
            'country' => $country,
        ];
    }
}
