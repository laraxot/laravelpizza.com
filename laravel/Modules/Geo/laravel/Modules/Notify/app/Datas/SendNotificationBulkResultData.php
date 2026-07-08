<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per il risultato di SendRecordsNotificationBulkAction.
 */
class SendNotificationBulkResultData extends Data
{
    /**
     * @param  Collection<int, array{record: string, channel: string, error: string}>  $errors
     */
    public function __construct(
        public readonly int $successCount,
        public readonly int $errorCount,
        /** @var Collection<int, array{record: string, channel: string, error: string}> */
        public readonly Collection $errors,
        public readonly int $totalProcessed,
    ) {}
}
