<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Modules\Xot\Actions\Array\RangeIntersectAction;


test('range intersect action handles basic intersection', function () {
    $action = app(RangeIntersectAction::class);

    // Case 1: a1 >= a0 && a1 <= b0 && b0 <= b1
    expect($action->execute(10, 20, 15, 25))->toBe([15, 20]);

    // Case 2: a0 >= a1 && a0 <= b0 && b0 <= b1
    expect($action->execute(15, 25, 10, 30))->toBe([15, 25]);

    // Case 3: a1 >= a0 && a1 <= b1 && b1 <= b0
    expect($action->execute(10, 30, 15, 25))->toBe([15, 25]);

    // Case 4: No intersection (a0 < a1)
    expect($action->execute(10, 12, 15, 25))->toBeFalse();

    // Case 5: No intersection (a0 > b1)
    expect($action->execute(30, 40, 10, 20))->toBeFalse();

    // Case 6: b1 > b0
    expect($action->execute(20, 30, 10, 40))->toBe([20, 30]); // Falls into Case 2
});
