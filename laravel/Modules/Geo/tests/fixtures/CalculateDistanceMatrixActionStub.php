<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Illuminate\Support\Collection;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;

/**
 * @internal
 */
final class CalculateDistanceMatrixActionStub extends CalculateDistanceMatrixAction
{
    /**
     * @param  array<array<array{distance: array{text: string, value: int}, duration: array{text: string, value: int}, status: string}>>  $response
     */
    public function __construct(
        private array $response = [],
        private ?\Throwable $exception = null,
    ) {}

    /**
     * @param  Collection<int, LocationData>  $origins
     * @param  Collection<int, LocationData>  $destinations
     * @return array<array<array{distance: array{text: string, value: int}, duration: array{text: string, value: int}, status: string}>>
     */
    public function execute(Collection $origins, Collection $destinations): array
    {
        if ($this->exception !== null) {
            throw $this->exception;
        }

        return $this->response;
    }
}
