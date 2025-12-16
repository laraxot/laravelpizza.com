<?php

declare(strict_types=1);


namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class NetfunSmsMessage extends Data
{
    public function __construct(
        public string $recipient,
        public string $text,
        public string $sender,
        public null|string $reference = null,
        public null|string $scheduledDate = null,
    ) {}
}
