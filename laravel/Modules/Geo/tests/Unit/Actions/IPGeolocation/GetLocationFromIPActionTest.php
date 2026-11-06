<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\IPGeolocation;

use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Actions\IPGeolocation\GetLocationFromIPAction;
use Modules\Geo\Datas\Location\IPLocationData;
use Modules\Geo\Tests\Fixtures\FetchIPLocationReturningStub;
use Modules\Geo\Tests\Fixtures\FetchIPLocationThrowingStub;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

function makeGetLocationFromIPAction(FetchIPLocationAction $fetchAction): GetLocationFromIPAction
{
    app()->instance(FetchIPLocationAction::class, $fetchAction);

    return new GetLocationFromIPAction();
}

it('delegates to fetch action and returns result', function (): void {
    $fetchAction = new FetchIPLocationReturningStub(new IPLocationData(
        ip: '8.8.8.8',
        city: 'Ashburn',
        region: null,
        country: 'US',
        countryName: 'United States',
        latitude: null,
        longitude: null,
        timezone: null,
        isp: null,
    ));
    $action = makeGetLocationFromIPAction($fetchAction);

    $result = $action->execute('8.8.8.8');

    Assert::assertInstanceOf(IPLocationData::class, $result);
    Assert::assertSame('8.8.8.8', $result->ip);
    Assert::assertSame('Ashburn', $result->city);
});

it('propagates exception when fetch action throws', function (): void {
    $fetchAction = new FetchIPLocationThrowingStub(new \RuntimeException('not found'));
    $action = makeGetLocationFromIPAction($fetchAction);

    try {
        $action->execute('192.168.1.1');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('not found', $exception->getMessage());
    }
});
