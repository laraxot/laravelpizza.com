<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Photon;

use Spatie\LaravelData\Data;

class PhotonPropertiesData extends Data
{
    public function __construct(
        public ?string $country,
        public ?string $city,
        public ?string $postcode,
        public ?string $street,
        public ?string $housenumber,
    ) {}
}
