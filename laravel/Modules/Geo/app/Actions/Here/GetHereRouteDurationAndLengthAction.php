<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Here;

use Modules\Geo\Adapters\HereClient;
use Spatie\QueueableAction\QueueableAction;

class GetHereRouteDurationAndLengthAction
{
    use QueueableAction;

    public function __construct(
        private readonly HereClient $hereClient = new HereClient(),
    ) {
    }

    /**
     * @return array<string, mixed>|null
     */
    public function execute(float $lat1, float $lon1, float $lat2, float $lon2): ?array
    {
        return $this->hereClient->getDurationAndLength($lat1, $lon1, $lat2, $lon2);
    }
}
