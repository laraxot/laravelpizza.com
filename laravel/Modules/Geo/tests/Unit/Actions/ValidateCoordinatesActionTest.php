<?php

declare(strict_types=1);

use Modules\Geo\Actions\ValidateCoordinatesAction;
use Modules\Geo\Tests\TestCase;


beforeEach(function () {
    $this->action = new ValidateCoordinatesAction();
});

it('validates valid coordinates correctly', function (): void {
    // Test valid coordinates
    expect($this->action->execute(45.4642, 9.1900))->toBeTrue(); // Milano
    expect($this->action->execute(40.7128, -74.0060))->toBeTrue(); // New York
    expect($this->action->execute(0, 0))->toBeTrue(); // Equator/Greenwich
    expect($this->action->execute(90, 180))->toBeTrue(); // North pole, far east
    expect($this->action->execute(-90, -180))->toBeTrue(); // South pole, far west
});

it('rejects invalid latitude', function (): void {
    // Test invalid latitudes
    expect($this->action->execute(91, 0))->toBeFalse(); // Too north
    expect($this->action->execute(-91, 0))->toBeFalse(); // Too south
    expect($this->action->execute(100, 0))->toBeFalse(); // Way too north
    expect($this->action->execute(-100, 0))->toBeFalse(); // Way too south
});

it('rejects invalid longitude', function (): void {
    // Test invalid longitudes
    expect($this->action->execute(0, 181))->toBeFalse(); // Too east
    expect($this->action->execute(0, -181))->toBeFalse(); // Too west
    expect($this->action->execute(0, 200))->toBeFalse(); // Way too east
    expect($this->action->execute(0, -200))->toBeFalse(); // Way too west
});

it('validates boundary coordinates', function (): void {
    // Test exact boundary values - should be valid
    expect($this->action->execute(90, 180))->toBeTrue(); // North pole, far east
    expect($this->action->execute(-90, -180))->toBeTrue(); // South pole, far west
    expect($this->action->execute(90, -180))->toBeTrue(); // North pole, far west
    expect($this->action->execute(-90, 180))->toBeTrue(); // South pole, far east
});

it('handles decimal coordinates correctly', function (): void {
    // Test high precision coordinates
    expect($this->action->execute(45.123456, 9.654321))->toBeTrue();
    expect($this->action->execute(-45.123456, -9.654321))->toBeTrue();
    expect($this->action->execute(89.999999, 179.999999))->toBeTrue();
    expect($this->action->execute(-89.999999, -179.999999))->toBeTrue();
});

it('handles zero coordinates', function (): void {
    // Test coordinates with zero values
    expect($this->action->execute(0, 0))->toBeTrue();
    expect($this->action->execute(0, 10))->toBeTrue();
    expect($this->action->execute(10, 0))->toBeTrue();
});

it('rejects coordinates with extreme values', function (): void {
    // Test with extreme values that are clearly out of bounds
    expect($this->action->execute(1000, 1000))->toBeFalse();
    expect($this->action->execute(-1000, -1000))->toBeFalse();
    expect($this->action->execute(999.99, -999.99))->toBeFalse();
});
