<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Actions\GoogleMaps\GoogleMapsHttpAction;

/**
 * @internal
 */
final class GoogleMapsHttpActionElevationStub extends GoogleMapsHttpAction
{
    /**
     * @param array<string, mixed> $elevationResponse
     */
    public function __construct(
        private array $elevationResponse = [],
        private ?\Throwable $exception = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function executeElevation(float $latitude, float $longitude): array
    {
        if (null !== $this->exception) {
            throw $this->exception;
        }

        return $this->elevationResponse;
    }
}
