<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\ValidateCoordinatesAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('validates valid coordinates correctly', function (): void {
    $action = new ValidateCoordinatesAction();

    // Test valid coordinates
    Assert::assertTrue($action->execute(45.4642, 9.1900)); // Milano
    Assert::assertTrue($action->execute(40.7128, -74.0060)); // New York
    Assert::assertTrue($action->execute(0, 0)); // Equator/Greenwich
    Assert::assertTrue($action->execute(90, 180)); // North pole, far east
    Assert::assertTrue($action->execute(-90, -180)); // South pole, far west
});

it('rejects invalid latitude', function (): void {
    $action = new ValidateCoordinatesAction();

    // Test invalid latitudes
    Assert::assertFalse($action->execute(91, 0)); // Too north
    Assert::assertFalse($action->execute(-91, 0)); // Too south
    Assert::assertFalse($action->execute(100, 0)); // Way too north
    Assert::assertFalse($action->execute(-100, 0)); // Way too south
});

it('rejects invalid longitude', function (): void {
    $action = new ValidateCoordinatesAction();

    // Test invalid longitudes
    Assert::assertFalse($action->execute(0, 181)); // Too east
    Assert::assertFalse($action->execute(0, -181)); // Too west
    Assert::assertFalse($action->execute(0, 200)); // Way too east
    Assert::assertFalse($action->execute(0, -200)); // Way too west
});

it('validates boundary coordinates', function (): void {
    $action = new ValidateCoordinatesAction();

    // Test exact boundary values - should be valid
    Assert::assertTrue($action->execute(90, 180)); // North pole, far east
    Assert::assertTrue($action->execute(-90, -180)); // South pole, far west
    Assert::assertTrue($action->execute(90, -180)); // North pole, far west
    Assert::assertTrue($action->execute(-90, 180)); // South pole, far east
});

it('handles decimal coordinates correctly', function (): void {
    $action = new ValidateCoordinatesAction();

    // Test high precision coordinates
    Assert::assertTrue($action->execute(45.123456, 9.654321));
    Assert::assertTrue($action->execute(-45.123456, -9.654321));
    Assert::assertTrue($action->execute(89.999999, 179.999999));
    Assert::assertTrue($action->execute(-89.999999, -179.999999));
});

it('handles zero coordinates', function (): void {
    $action = new ValidateCoordinatesAction();

    // Test coordinates with zero values
    Assert::assertTrue($action->execute(0, 0));
    Assert::assertTrue($action->execute(0, 10));
    Assert::assertTrue($action->execute(10, 0));
});

it('rejects coordinates with extreme values', function (): void {
    $action = new ValidateCoordinatesAction();

    // Test with extreme values that are clearly out of bounds
    Assert::assertFalse($action->execute(1000, 1000));
    Assert::assertFalse($action->execute(-1000, -1000));
    Assert::assertFalse($action->execute(999.99, -999.99));
});
