<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

readonly class SmsMessageData
{
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        public ?string $reference = null,
        public ?string $scheduledDate = null,
    ) {}
}
