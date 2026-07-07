<?php

declare(strict_types=1);

namespace Modules\Job\Datas;

use Spatie\LaravelData\Data;

class CommandData extends Data
{
    /**
     * @param  array<int, array<string, mixed>>  $arguments
     * @param  array<string, mixed>  $options
     */
    public function __construct(
        public string $name,
        public string $description,
        public string $signature,
        public string $full_name,
        public array $arguments,
        public array $options,
    ) {}
}
