<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Arr\RangeIntersectAction;
use PHPUnit\Framework\Assert;

it('calculates range intersection correctly', function (): void {
    $action = app(RangeIntersectAction::class);

    // Case 1: $a1 >= $a0 && $a1 <= $b0 && $b0 <= $b1
    Assert::assertSame([15, 20], $action->execute(10, 20, 15, 25));
    // Case 2: $a0 >= $a1 && $a0 <= $b0 && $b0 <= $b1
    Assert::assertSame([15, 25], $action->execute(15, 25, 10, 30));
    // Case 3: $a1 >= $a0 && $a1 <= $b1 && $b1 <= $b0
    Assert::assertSame([15, 25], $action->execute(10, 30, 15, 25));
    // Case 4: $a0 < $a1 (No overlap)
    Assert::assertFalse($action->execute(10, 12, 15, 25));
    // Case 5: $a0 > $b1 (No overlap)
    Assert::assertFalse($action->execute(30, 40, 10, 20));
    // Case 6: $b1 > $b0 (No overlap handled by last check)
    Assert::assertSame([20, 30], $action->execute(20, 30, 10, 40)); // Actually falls into Case 2 logic above

    // Final fallback case: return [$a0, $b1]
    Assert::assertSame([15, 20], $action->execute(15, 20, 10, 25)); // Also Case 2
});
