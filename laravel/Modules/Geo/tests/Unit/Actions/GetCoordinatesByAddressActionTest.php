<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetCoordinatesByAddressAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('returns null for empty address', function (): void {
    $action = new GetCoordinatesByAddressAction();

    // Without API keys configured, should return null
    $result = $action->execute('');

    Assert::assertNull($result);
});

it('returns null when google api key not configured', function (): void {
    $action = new GetCoordinatesByAddressAction();

    Config::set('services.google.maps_api_key', null);
    Config::set('services.bing.maps_api_key', null);
    Config::set('services.opencage.api_key', null);

    $result = $action->execute('Fake Address XYZ');

    Assert::assertNull($result);
});

it('returns null for non-existent address with mock', function (): void {
    $action = new GetCoordinatesByAddressAction();

    Config::set('services.google.maps_api_key', 'fake-key');
    Config::set('services.bing.maps_api_key', null);
    Config::set('services.opencage.api_key', null);

    // Mock empty results from Google
    Http::fake([
        'maps.googleapis.com/*' => Http::response([
            'status' => 'ZERO_RESULTS',
            'results' => [],
        ], 200),
    ]);

    $result = $action->execute('asdfghjklqwertyuizxcvbnm123456789');

    Assert::assertNull($result);
});
