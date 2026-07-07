<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Array\RangeIntersectAction;
use PHPUnit\Framework\Assert;

test('range intersect action handles basic intersection', function () {
    $action = app(RangeIntersectAction::class);

    // Case 1: a1 >= a0 && a1 <= b0 && b0 <= b1
    Assert::assertSame([15, 20], $action->execute(10, 20, 15, 25));
    // Case 2: a0 >= a1 && a0 <= b0 && b0 <= b1
    Assert::assertSame([15, 25], $action->execute(15, 25, 10, 30));
    // Case 3: a1 >= a0 && a1 <= b1 && b1 <= b0
    Assert::assertSame([15, 25], $action->execute(10, 30, 15, 25));
    // Case 4: No intersection (a0 < a1)
    Assert::assertFalse($action->execute(10, 12, 15, 25));
    // Case 5: No intersection (a0 > b1)
    Assert::assertFalse($action->execute(30, 40, 10, 20));
    // Case 6: b1 > b0
    Assert::assertSame([20, 30], $action->execute(20, 30, 10, 40)); // Falls into Case 2
});
