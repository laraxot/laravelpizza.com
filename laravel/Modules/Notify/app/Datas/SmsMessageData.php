<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

readonly class SmsMessageData
{
    public function __construct(
        public string $recipient,
        public string $message,
        public null|string $sender = null,
        public null|string $reference = null,
        public null|string $scheduledDate = null,
    ) {}
}
