<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Illuminate\Support\Collection;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;

/**
 * @internal
 */
final class CalculateDistanceMatrixQueueStub extends CalculateDistanceMatrixAction
{
    /**
     * @param  list<array<mixed>>  $responses
     */
    public function __construct(
        private array $responses = [],
    ) {}

    private int $callIndex = 0;

    /**
     * @param  Collection<int, LocationData>  $origins
     * @param  Collection<int, LocationData>  $destinations
     * @return array<mixed>
     */
    public function execute(Collection $origins, Collection $destinations): array
    {
        unset($origins, $destinations);

        $response = $this->responses[$this->callIndex] ?? [[]];
        $this->callIndex++;

        return $response;
    }
}
