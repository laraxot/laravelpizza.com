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
<<<<<<< HEAD
     * @param  array<string, mixed>  $elevationResponse
=======
     * @param array<string, mixed> $elevationResponse
>>>>>>> laraxot/dev
     */
    public function __construct(
        private array $elevationResponse = [],
        private ?\Throwable $exception = null,
<<<<<<< HEAD
    ) {}
=======
    ) {
    }
>>>>>>> laraxot/dev

    /**
     * @return array<string, mixed>
     */
    public function getElevation(float $latitude, float $longitude): array
    {
<<<<<<< HEAD
        if ($this->exception !== null) {
=======
        if (null !== $this->exception) {
>>>>>>> laraxot/dev
            throw $this->exception;
        }

        return $this->elevationResponse;
    }

    protected function getServiceName(): string
    {
        return 'google_maps';
    }
}
