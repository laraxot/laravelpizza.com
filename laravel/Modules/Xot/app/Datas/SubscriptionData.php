<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

/**
 * Class SubscriptionData - Gestisce la configurazione degli abbonamenti.
 * Utilizzato esclusivamente nell'ambito dell'architettura Filament-first.
 *
 * @phpstan-consistent-constructor
 */
final class SubscriptionData extends Data
{
    /**
     * @param  array<string, string|int>  $plans
     * @param  array<int, class-string<Model>>  $allowedModels
     */
    public function __construct(
        public readonly bool $enable = false,
        public readonly string $driver = 'stripe',
        public readonly array $plans = [],
        public readonly string $currency = 'EUR',
        public readonly array $allowedModels = [],
        public readonly bool $trialEnabled = true,
        public readonly int $trialDays = 14,
    ) {}

    /**
     * Create a new instance of SubscriptionData with default values.
     */
    public static function make(): self
    {
        return new self;
    }
}
