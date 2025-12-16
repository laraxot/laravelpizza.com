<?php

declare(strict_types=1);


namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class NetfunSmsData extends Data
{
    public function __construct(
        public string $recipient,
        public string $message,
        public string $sender,
        public null|string $reference = null,
        public null|string $scheduledDate = null,
    ) {}
}
