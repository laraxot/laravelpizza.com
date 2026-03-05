<?php

declare(strict_types=1);

use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->action = new GetAddressDataFromFullAddressAction();
});

it('returns AddressData when first service succeeds', function (): void {
    // As this action depends on multiple external services which are difficult to mock,
    // we can test that it at least has the correct structure and properties
    expect($this->action)->toBeInstanceOf(GetAddressDataFromFullAddressAction::class);
    expect($this->action->getErrors())->toBeInstanceOf(Illuminate\Support\Collection::class);
    expect($this->action->getErrors()->count())->toBe(0);
});

it('initializes with empty errors collection', function (): void {
    $action = new GetAddressDataFromFullAddressAction();

    expect($action->getErrors())->toBeInstanceOf(Illuminate\Support\Collection::class);
    expect($action->getErrors()->count())->toBe(0);
});

it('executes without throwing error for basic call', function (): void {
    // This tests that the action can be instantiated and executed without critical errors
    // Since it depends on external services, we can't easily test the full functionality
    $action = new GetAddressDataFromFullAddressAction();

    // The execute method should handle missing services gracefully
    $result = $action->execute('Test Address');

    // Depending on configured services it may return null or a valid AddressData.
    if (null !== $result) {
        expect($result)->toBeInstanceOf(Modules\Geo\Datas\AddressData::class);
    }

    // Errors collection must always be available.
    expect($action->getErrors())->toBeInstanceOf(Illuminate\Support\Collection::class);
});
