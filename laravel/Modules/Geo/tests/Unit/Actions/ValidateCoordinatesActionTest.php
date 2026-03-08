<?php

declare(strict_types=1);

use Modules\Geo\Actions\ValidateCoordinatesAction;

beforeEach(function () {
    $action = new ValidateCoordinatesAction();
});

it('validates valid coordinates correctly', function (): void {
    // Test valid coordinates
    expect($action->execute(45.4642, 9.1900)); // Milano
    expect($action->execute(40.7128, -74.0060)); // New York
    expect($action->execute(0, 0)); // Equator/Greenwich
    expect($action->execute(90, 180)); // North pole, far east
    expect($action->execute(-90, -180)); // South pole, far west
});

it('rejects invalid latitude', function (): void {
    // Test invalid latitudes
    expect($action->execute(91, 0)); // Too north
    expect($action->execute(-91, 0)); // Too south
    expect($action->execute(100, 0)); // Way too north
    expect($action->execute(-100, 0)); // Way too south
});

it('rejects invalid longitude', function (): void {
    // Test invalid longitudes
    expect($action->execute(0, 181)); // Too east
    expect($action->execute(0, -181)); // Too west
    expect($action->execute(0, 200)); // Way too east
    expect($action->execute(0, -200)); // Way too west
});

it('validates boundary coordinates', function (): void {
    // Test exact boundary values - should be valid
    expect($action->execute(90, 180)); // North pole, far east
    expect($action->execute(-90, -180)); // South pole, far west
    expect($action->execute(90, -180)); // North pole, far west
    expect($action->execute(-90, 180)); // South pole, far east
});

it('handles decimal coordinates correctly', function (): void {
    // Test high precision coordinates
    expect($action->execute(45.123456, 9.654321));
    expect($action->execute(-45.123456, -9.654321));
    expect($action->execute(89.999999, 179.999999));
    expect($action->execute(-89.999999, -179.999999));
});

it('handles zero coordinates', function (): void {
    // Test coordinates with zero values
    expect($action->execute(0, 0));
    expect($action->execute(0, 10));
    expect($action->execute(10, 0));
});

it('rejects coordinates with extreme values', function (): void {
    // Test with extreme values that are clearly out of bounds
    expect($action->execute(1000, 1000));
    expect($action->execute(-1000, -1000));
    expect($action->execute(999.99, -999.99));
});
