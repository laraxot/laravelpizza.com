<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Actions\Cast\SafeBooleanCastAction;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

test('safe array cast action works', function () {
    $action = app(SafeArrayCastAction::class);

    expect($action->execute(['a' => 1]))->toBe(['a' => 1])
        ->and($action->execute(null, ['def']))->toBe(['def'])
        ->and($action->execute(collect(['b' => 2])))->toBe(['b' => 2])
        ->and($action->execute((object) ['c' => 3]))->toBe(['c' => 3])
        ->and($action->execute('scalar'))->toBe(['scalar'])
        ->and($action->execute(new class {
            public $d = 4;
        }))->toBe(['d' => 4])
        ->and($action->execute(new class {
            public function toArray()
            {
                return ['e' => 5];
            }
        }))->toBe(['e' => 5])
        ->and($action->execute(new class {
            public function __toArray()
            {
                return ['f' => 6];
            }
        }))->toBe(['f' => 6]);

    expect($action->executeWithKeys(['a' => 1, 'b' => 2], ['a', 'b']))->toBe(['a' => 1, 'b' => 2])
        ->and($action->executeWithKeys(['a' => 1], ['a', 'b'], ['def']))->toBe(['def']);

    expect($action->executeWithFilter(['a' => 1, 'b' => 2, 'c' => 3], ['a', 'c']))->toBe(['a' => 1, 'c' => 3]);

    expect($action->executeWithValueType(['1', '2'], 'int'))->toBe([1, 2])
        ->and($action->executeWithValueType([1, 0], 'bool'))->toBe([true, false])
        ->and($action->executeWithValueType([1.1, 2.2], 'string'))->toBe(['1.1', '2.2']);

    expect($action->canCast([]))->toBeTrue();
    expect(SafeArrayCastAction::cast(null))->toBe([]);
});

test('safe string cast action works', function () {
    $action = app(SafeStringCastAction::class);

    expect($action->execute('test'))->toBe('test')
        ->and($action->execute(null))->toBe('')
        ->and($action->execute(true))->toBe('1')
        ->and($action->execute(false))->toBe('0')
        ->and($action->execute(123))->toBe('123')
        ->and($action->execute([]))->toBe('');

    expect(SafeStringCastAction::cast(456))->toBe('456');
});

test('safe int cast action works', function () {
    $action = app(SafeIntCastAction::class);

    expect($action->execute(123))->toBe(123)
        ->and($action->execute(123.9))->toBe(123)
        ->and($action->execute(null, 5))->toBe(5)
        ->and($action->execute('1.234,56'))->toBe(123456)
        ->and($action->execute(' +123 '))->toBe(123)
        ->and($action->execute(true))->toBe(1)
        ->and($action->execute(['789']))->toBe(789)
        ->and($action->execute(new class {
            public function __toString()
            {
                return '1011';
            }
        }))->toBe(1011)
        ->and($action->execute('invalid'))->toBe(0);

    expect($action->executeWithRange(50, 0, 100))->toBe(50)
        ->and($action->executeWithRange(150, 0, 100))->toBe(100)
        ->and($action->executeWithRange(-50, 0, 100))->toBe(0);

    expect($action->executeAsId(0))->toBe(1)
        ->and($action->executeAsId(10))->toBe(10);

    expect(SafeIntCastAction::cast('99'))->toBe(99);
});

test('safe boolean cast action works', function () {
    $action = app(SafeBooleanCastAction::class);

    expect($action->execute(true))->toBeTrue()
        ->and($action->execute(null, true))->toBeTrue()
        ->and($action->execute(1))->toBeTrue()
        ->and($action->execute(0))->toBeFalse()
        ->and($action->execute(1.1))->toBeTrue()
        ->and($action->execute(0.0))->toBeFalse()
        ->and($action->execute('yes'))->toBeTrue()
        ->and($action->execute('no'))->toBeFalse()
        ->and($action->execute(['a']))->toBeTrue()
        ->and($action->execute([]))->toBeFalse()
        ->and($action->execute((object) ['a' => 1]))->toBeTrue()
        ->and($action->execute((object) []))->toBeFalse();

    expect($action->executeWithCustomValues('Y', ['y'], ['n']))->toBeTrue()
        ->and($action->executeWithCustomValues('N', ['y'], ['n']))->toBeFalse();

    expect($action->executeWithThreshold(10, 5))->toBeTrue()
        ->and($action->executeWithThreshold(3, 5))->toBeFalse();

    expect($action->canCast(true))->toBeTrue();
    expect(SafeBooleanCastAction::cast('on'))->toBeTrue();
});
