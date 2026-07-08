<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Spatie\LaravelData\Data;

class CompletionData extends Data
{
    public function __construct(
        public string $text,
        public int $promptTokens,
        public int $completionTokens,
        public int $totalTokens,
    ) {}
}
