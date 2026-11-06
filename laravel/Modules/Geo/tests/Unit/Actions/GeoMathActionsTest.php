<?php

declare(strict_types=1);

use Modules\Geo\Actions\GoogleMaps\FetchGoogleMapsElevationAction;
use Modules\Geo\Actions\Here\GetHereRouteDurationAndLengthAction;
use Modules\Geo\Actions\Math\CalculateGeoDistanceAction;
use Modules\Geo\Actions\Math\GenerateHaversineSqlAction;
use PHPUnit\Framework\Assert;

test('CalculateGeoDistanceAction can be instantiated', function (): void {
    Assert::assertInstanceOf(CalculateGeoDistanceAction::class, app(CalculateGeoDistanceAction::class));
});

test('GenerateHaversineSqlAction can be instantiated', function (): void {
    Assert::assertInstanceOf(GenerateHaversineSqlAction::class, app(GenerateHaversineSqlAction::class));
});

test('FetchGoogleMapsElevationAction can be instantiated', function (): void {
    Assert::assertInstanceOf(FetchGoogleMapsElevationAction::class, app(FetchGoogleMapsElevationAction::class));
});

test('GetHereRouteDurationAndLengthAction can be instantiated', function (): void {
    Assert::assertInstanceOf(GetHereRouteDurationAndLengthAction::class, app(GetHereRouteDurationAndLengthAction::class));
});

test('CalculateGeoDistanceAction returns zero for same point', function (): void {
    $action = app(CalculateGeoDistanceAction::class);

    expect($action->execute(45.0, 9.0, 45.0, 9.0, 'K'))->toBe(0.0);
});

test('GenerateHaversineSqlAction uses custom field names', function (): void {
    $sql = app(GenerateHaversineSqlAction::class)->execute(45.0, 9.0, 'lat', 'lng');

    expect($sql)->toContain('`lat`')->toContain('`lng`');
});
