<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

class GeoData extends Data
{
    public array $latlng;

    public string $route;

    public string $street_number;

    public string $postal_code;

    public string $administrative_area_level_3;

    public string $administrative_area_level_2_short;

    public string $value;
}
