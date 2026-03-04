<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeBooleanCastAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('casts various values to boolean correctly', function (): void {
    $action = app(SafeBooleanCastAction::class);

    // Booleans
    expect($action->execute(true))->toBeTrue();
    expect($action->execute(false))->toBeFalse();

    // Null
    expect($action->execute(null, true))->toBeTrue();
    expect($action->execute(null, false))->toBeFalse();

    // Integers
    expect($action->execute(1))->toBeTrue();
    expect($action->execute(0))->toBeFalse();
    expect($action->execute(-1))->toBeTrue();

    // Floats
    expect($action->execute(1.1))->toBeTrue();
    expect($action->execute(0.0))->toBeFalse();
    expect($action->execute(NAN, true))->toBeTrue();

    // Strings
    expect($action->execute('true'))->toBeTrue();
    expect($action->execute('1'))->toBeTrue();
    expect($action->execute('yes'))->toBeTrue();
    expect($action->execute('on'))->toBeTrue();
    expect($action->execute('enabled'))->toBeTrue();
    expect($action->execute('active'))->toBeTrue();
    expect($action->execute('sì'))->toBeTrue();
    
    expect($action->execute('false'))->toBeFalse();
    expect($action->execute('0'))->toBeFalse();
    expect($action->execute('no'))->toBeFalse();
    expect($action->execute('off'))->toBeFalse();
    expect($action->execute('disabled'))->toBeFalse();
    
    expect($action->execute(''))->toBeFalse();
    expect($action->execute('random', true))->toBeTrue();
    expect($action->execute('123.45'))->toBeTrue();
    expect($action->execute('0.00'))->toBeFalse();

    // Arrays
    expect($action->execute(['a']))->toBeTrue();
    expect($action->execute([]))->toBeFalse();

    // Objects
    $obj = new \stdClass();
    $obj->a = 1;
    expect($action->execute($obj))->toBeTrue();
    expect($action->execute(new \stdClass()))->toBeFalse();
});

it('casts with custom values correctly', function (): void {
    $action = app(SafeBooleanCastAction::class);
    
    expect($action->executeWithCustomValues('Y', ['Y'], ['N']))->toBeTrue();
    expect($action->executeWithCustomValues('N', ['Y'], ['N']))->toBeFalse();
    expect($action->executeWithCustomValues('maybe', ['Y'], ['N'], true))->toBeTrue();
});

it('casts with threshold correctly', function (): void {
    $action = app(SafeBooleanCastAction::class);
    
    expect($action->executeWithThreshold(10, 5))->toBeTrue();
    expect($action->executeWithThreshold(3, 5))->toBeFalse();
    expect($action->executeWithThreshold(3, 5, false))->toBeTrue();
});

it('checks if value can be cast to boolean', function (): void {
    $action = app(SafeBooleanCastAction::class);
    expect($action->canCast(true))->toBeTrue();
    expect($action->canCast(null))->toBeTrue();
    expect($action->canCast(1))->toBeTrue();
});

it('uses static boolean cast methods correctly', function (): void {
    expect(SafeBooleanCastAction::cast('on'))->toBeTrue();
    expect(SafeBooleanCastAction::castWithCustomValues('YES', ['yes'], ['no']))->toBeTrue();
    expect(SafeBooleanCastAction::castWithThreshold(100, 50))->toBeTrue();
});
