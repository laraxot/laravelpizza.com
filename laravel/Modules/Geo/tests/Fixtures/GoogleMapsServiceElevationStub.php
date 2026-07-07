<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Services\GoogleMapsService;

/**
 * @internal
 */
final class GoogleMapsServiceElevationStub extends GoogleMapsService
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
    public function getElevation(float $latitude, float $longitude): array
    {
        if (null !== $this->exception) {
            throw $this->exception;
        }

        return $this->elevationResponse;
    }

    protected function getServiceName(): string
    {
        return 'google_maps';
    }
}
