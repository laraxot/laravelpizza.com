<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\RangeIntersectAction;


it('calculates range intersection correctly', function (): void {
    $action = app(RangeIntersectAction::class);

    // Case 1: $a1 >= $a0 && $a1 <= $b0 && $b0 <= $b1
    expect($action->execute(10, 20, 15, 25))->toBe([15, 20]);

    // Case 2: $a0 >= $a1 && $a0 <= $b0 && $b0 <= $b1
    expect($action->execute(15, 25, 10, 30))->toBe([15, 25]);

    // Case 3: $a1 >= $a0 && $a1 <= $b1 && $b1 <= $b0
    expect($action->execute(10, 30, 15, 25))->toBe([15, 25]);

    // Case 4: $a0 < $a1 (No overlap)
    expect($action->execute(10, 12, 15, 25))->toBeFalse();

    // Case 5: $a0 > $b1 (No overlap)
    expect($action->execute(30, 40, 10, 20))->toBeFalse();

    // Case 6: $b1 > $b0 (No overlap handled by last check)
    expect($action->execute(20, 30, 10, 40))->toBe([20, 30]); // Actually falls into Case 2 logic above

    // Final fallback case: return [$a0, $b1]
    expect($action->execute(15, 20, 10, 25))->toBe([15, 20]); // Also Case 2
});
