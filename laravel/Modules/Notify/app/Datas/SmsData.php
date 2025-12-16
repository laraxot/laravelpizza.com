<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public string $from;

    public string $to;

    public string $body;
}
