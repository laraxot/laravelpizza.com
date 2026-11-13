<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Actions\GoogleMapsAction;

/**
 * @internal
 */
final class GoogleMapsServiceElevationStub extends GoogleMapsAction
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
