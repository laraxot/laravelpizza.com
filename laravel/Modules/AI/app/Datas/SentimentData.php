<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Spatie\LaravelData\Data;

class SentimentData extends Data
{
    public function __construct(
        public string $label = '',
        public float $score = 0.0,
        public ?string $warning = null,
        public ?string $error = null,
        public ?string $status = null,
        public ?bool $fallback = null,
    ) {}
}
