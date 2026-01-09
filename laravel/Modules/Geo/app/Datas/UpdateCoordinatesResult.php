<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

/**
 * Result DTO for bulk coordinate update operations.
 *
 * Encapsulates statistics and error details from UpdateCoordinatesAction.
 */
class UpdateCoordinatesResult extends Data
{
    /**
     * @param int                                                  $totalProcessed Total number of records processed
     * @param int                                                  $successCount   Number of successfully updated records
     * @param int                                                  $failureCount   Number of failed updates
     * @param Collection<int, array{model: string, error: string}> $errors         Collection of error details
     */
    public function __construct(
        public readonly int $totalProcessed,
        public readonly int $successCount,
        public readonly int $failureCount,
        public readonly Collection $errors,
    ) {
    }

    /**
     * Check if there were any errors during processing.
     */
    public function hasErrors(): bool
    {
        return $this->failureCount > 0;
    }

    /**
     * Check if all operations were successful.
     */
    public function isCompleteSuccess(): bool
    {
        return 0 === $this->failureCount && $this->successCount > 0;
    }

    /**
     * Check if all operations failed.
     */
    public function isCompleteFailure(): bool
    {
        return 0 === $this->successCount && $this->totalProcessed > 0;
    }

    /**
     * Get success rate as percentage.
     */
    public function getSuccessRate(): float
    {
        if (0 === $this->totalProcessed) {
            return 0.0;
        }

        return $this->successCount / $this->totalProcessed * 100;
    }

    /**
     * Get formatted error messages.
     *
     * @return array<int, string>
     */
    public function getErrorMessages(): array
    {
        $messages = $this->errors
            ->map(fn (array $error): string => "{$error['model']}: {$error['error']}")
            ->values()
            ->toArray();

        Assert::isArray($messages);

        /* @var array<int, string> $messages */
        return $messages;
    }

    /**
     * Get summary message for notifications.
     */
    public function getSummaryMessage(): string
    {
        $rate = number_format($this->getSuccessRate(), 1);

        return "Processed {$this->totalProcessed} records. "
            ."Successfully updated {$this->successCount} ({$rate}%). "
            ."Failed: {$this->failureCount}.";
    }
}
