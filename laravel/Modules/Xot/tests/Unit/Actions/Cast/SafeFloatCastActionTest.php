<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Tests\TestCase;

uses(TestCase::class);

test('safe float cast action works', function () {
    $action = app(SafeFloatCastAction::class);

    expect($action->execute(12.3))->toBe(12.3)
        ->and($action->execute(INF, 5.5))->toBe(5.5)
        ->and($action->execute(123))->toBe(123.0)
        ->and($action->execute(null, 1.1))->toBe(1.1)
        ->and($action->execute('12,34'))->toBe(12.34)
        ->and($action->execute('1.23e2'))->toBe(123.0)
        ->and($action->execute(true))->toBe(1.0)
        ->and($action->execute(['15.5']))->toBe(15.5)
        ->and($action->execute(new class {
            public function __toString()
            {
                return '20.2';
            }
        }))->toBe(20.2)
        ->and($action->execute('invalid'))->toBe(0.0);

    expect($action->executeWithRange(50.5, 0.0, 100.0))->toBe(50.5)
        ->and($action->executeWithRange(150.0, 0.0, 100.0))->toBe(100.0)
        ->and($action->executeWithRange(-50.0, 0.0, 100.0))->toBe(0.0);

    expect($action->executeWithPrecision(12.3456, 2))->toBe(12.35)
        ->and($action->executeWithPrecision(12.3456, 0))->toBe(12.0);

    expect($action->executeAsPercentage(120.0))->toBe(100.0)
        ->and($action->executeAsPercentage(-10.0))->toBe(0.0);

    expect($action->executeAsCurrency(-12.3456))->toBe(12.35);

    expect(SafeFloatCastAction::cast('9.99'))->toBe(9.99);
});
