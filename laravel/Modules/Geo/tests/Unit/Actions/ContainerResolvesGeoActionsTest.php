<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Actions\GoogleMaps\GetAddressFromGoogleMapsAction;
use Modules\Geo\Actions\Here\GetAddressFromHereMapsAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

test('il container risolve le action di geocoding senza sollevare', function (): void {
    Assert::assertTrue(is_callable([app(GetAddressFromGoogleMapsAction::class), 'execute']));
    Assert::assertTrue(is_callable([app(GetAddressFromHereMapsAction::class), 'execute']));
    Assert::assertTrue(is_callable([app(CalculateDistanceAction::class), 'execute']));
});

test('ogni risoluzione restituisce una istanza nuova, non un singleton condiviso', function (): void {
    Assert::assertNotSame(
        app(GetAddressFromGoogleMapsAction::class),
        app(GetAddressFromGoogleMapsAction::class),
    );
});
