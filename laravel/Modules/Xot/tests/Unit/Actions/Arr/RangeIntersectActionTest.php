<?php

declare(strict_types=1);

use Modules\Xot\Actions\Arr\RangeIntersectAction;

beforeEach(function (): void {
    $this->action = app(RangeIntersectAction::class);
});

it('returns intersection when a1 in [a0,b0] and b0 <= b1', function (): void {
    $result = $this->action->execute(0, 10, 2, 15);
    expect($result)->toBe([2, 10]);
});

it('returns intersection when a0 in [a1,b0] and b0 <= b1', function (): void {
    $result = $this->action->execute(5, 10, 0, 15);
    expect($result)->toBe([5, 10]);
});

it('returns intersection when a1 in [a0,b1] and b1 <= b0', function (): void {
    $result = $this->action->execute(0, 20, 2, 10);
    expect($result)->toBe([2, 10]);
});

it('returns false when a0 < a1 and no overlap', function (): void {
    $result = $this->action->execute(0, 5, 10, 15);
    expect($result)->toBeFalse();
});

it('returns false when a0 > b1', function (): void {
    $result = $this->action->execute(20, 30, 0, 10);
    expect($result)->toBeFalse();
});

it('returns [a0,b0] when a0 in [a1,b0] and b0 <= b1', function (): void {
    $result = $this->action->execute(10, 15, 5, 20);
    expect($result)->toBe([10, 15]);
});

it('returns false when b1 > b0 and no previous condition matches', function (): void {
    $result = $this->action->execute(20, 15, 10, 25);
    expect($result)->toBeFalse();
});

it('returns [a0, b1] when a0 >= a1 and b1 <= b0', function (): void {
    $result = $this->action->execute(10, 20, 5, 15);
    expect($result)->toBe([10, 15]);
});
