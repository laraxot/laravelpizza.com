<?php

declare(strict_types=1);

namespace Modules\Rating\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/** Config tenant per la SettingPage di Rating, senza chiavi esposte al form. */
class RatingConfigData extends Data
{
    use MakesFromTenantConfig;
}
