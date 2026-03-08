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
            'latitude' => // @var mixed latitude,
            'longitude' => // @var mixed longitude,
            'address' => // @var mixed address,
            'city' => // @var mixed city,
            'country' => // @var mixed country,
        ];
    }
}
