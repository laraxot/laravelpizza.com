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
<<<<<<< .merge_file_lLMc0X
<<<<<<< .merge_file_cC9KCa
<<<<<<< .merge_file_26RWc6
     * @param  array<string, mixed>  $elevationResponse
=======
     * @param array<string, mixed> $elevationResponse
>>>>>>> .merge_file_FnUp3I
=======
     * @param array<string, mixed> $elevationResponse
>>>>>>> .merge_file_fYOHTI
=======
     * @param array<string, mixed> $elevationResponse
>>>>>>> .merge_file_bGwmJ0
     */
    public function __construct(
        private array $elevationResponse = [],
        private ?\Throwable $exception = null,
<<<<<<< .merge_file_lLMc0X
<<<<<<< .merge_file_cC9KCa
<<<<<<< .merge_file_26RWc6
    ) {}
=======
    ) {
    }
>>>>>>> .merge_file_FnUp3I
=======
    ) {
    }
>>>>>>> .merge_file_fYOHTI
=======
    ) {
    }
>>>>>>> .merge_file_bGwmJ0

    /**
     * @return array<string, mixed>
     */
    public function getElevation(float $latitude, float $longitude): array
    {
<<<<<<< .merge_file_lLMc0X
<<<<<<< .merge_file_cC9KCa
<<<<<<< .merge_file_26RWc6
        if ($this->exception !== null) {
=======
        if (null !== $this->exception) {
>>>>>>> .merge_file_FnUp3I
=======
        if (null !== $this->exception) {
>>>>>>> .merge_file_fYOHTI
=======
        if (null !== $this->exception) {
>>>>>>> .merge_file_bGwmJ0
            throw $this->exception;
        }

        return $this->elevationResponse;
    }

    protected function getServiceName(): string
    {
        return 'google_maps';
    }
}
