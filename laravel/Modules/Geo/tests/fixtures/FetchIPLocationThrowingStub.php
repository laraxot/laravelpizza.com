<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Datas\Location\IPLocationData;

/**
 * @internal
 */
final class FetchIPLocationThrowingStub extends FetchIPLocationAction
{
    public function __construct(
        private readonly \RuntimeException $exception,
    ) {
    }

    public function execute(string $ip): IPLocationData
    {
        throw $this->exception;
    }
}
