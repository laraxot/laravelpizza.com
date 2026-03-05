<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetCoordinatesByAddressAction;

uses(\Modules\Geo\Tests\LightTestCase::class);

beforeEach(function () {
    $this->action = new GetCoordinatesByAddressAction;
});

it('returns null for empty address', function (): void {
    // Without API keys configured, should return null
    $result = $this->action->execute('');

    expect($result)->toBeNull();
});

it('returns null when google api key not configured', function (): void {
    Config::set('services.google.maps_api_key', null);
    Config::set('services.bing.maps_api_key', null);
    Config::set('services.opencage.api_key', null);

    $result = $this->action->execute('Fake Address XYZ');

    expect($result)->toBeNull();
});

it('returns null for non-existent address with mock', function (): void {
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

    $result = $this->action->execute('asdfghjklqwertyuizxcvbnm123456789');

    expect($result)->toBeNull();
});
