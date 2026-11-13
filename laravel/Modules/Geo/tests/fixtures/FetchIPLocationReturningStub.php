<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Datas\Location\IPLocationData;

/**
 * @internal
 */
final class FetchIPLocationReturningStub extends FetchIPLocationAction
{
    public function __construct(
        private readonly IPLocationData $locationData,
    ) {
    }

    public function execute(string $ip): IPLocationData
    {
        return $this->locationData;
    }
}
