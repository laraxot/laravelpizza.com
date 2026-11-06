<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\HereMap;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class HereMapResponseData extends Data
{
    /**
     * @param array<string, mixed>|null $position
     * @param array<string, mixed>|null $address
     */
    public function __construct(
        #[MapInputName('items.0.position')]
        public ?array $position,
        #[MapInputName('items.0.address')]
        public ?array $address,
    ) {
    }
}
