<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Collection;

uses(TestCase::class);

it('casts various values to array correctly', function (): void {
    $action = app(SafeArrayCastAction::class);

    // Already array
    expect($action->execute(['a' => 1]))->toBe(['a' => 1]);

    // Null
    expect($action->execute(null, ['default']))->toBe(['default']);

    // Collection
    expect($action->execute(collect(['b' => 2])))->toBe(['b' => 2]);

    // stdClass
    $obj = new \stdClass();
    $obj->c = 3;
    expect($action->execute($obj))->toBe(['c' => 3]);

    // Object with toArray
    $objToArray = new class { public function toArray() { return ['d' => 4]; } };
    expect($action->execute($objToArray))->toBe(['d' => 4]);

    // Object with __toArray
    $objUnderscoreToArray = new class { public function __toArray() { return ['e' => 5]; } };
    expect($action->execute($objUnderscoreToArray))->toBe(['e' => 5]);

    // Regular object (public properties)
    $regObj = new class { public $f = 6; };
    expect($action->execute($regObj))->toBe(['f' => 6]);

    // Scalar
    expect($action->execute('test'))->toBe(['test']);
    expect($action->execute(123))->toBe([123]);

    // Fallback
    expect($action->execute(fopen('php://memory', 'r'), ['fallback']))->toBe(['fallback']);
});

it('validates required keys correctly', function (): void {
    $action = app(SafeArrayCastAction::class);
    $data = ['a' => 1, 'b' => 2];

    expect($action->executeWithKeys($data, ['a', 'b']))->toBe($data);
    expect($action->executeWithKeys($data, ['a', 'c'], ['error' => true]))->toBe(['error' => true]);
});

it('filters keys correctly', function (): void {
    $action = app(SafeArrayCastAction::class);
    $data = ['a' => 1, 'b' => 2, 'c' => 3];

    expect($action->executeWithFilter($data, ['a', 'c']))->toBe(['a' => 1, 'c' => 3]);
});

it('casts values to specific type correctly', function (): void {
    $action = app(SafeArrayCastAction::class);
    $data = ['1', '2', '3'];

    expect($action->executeWithValueType($data, 'int'))->toBe([1, 2, 3]);
    expect($action->executeWithValueType([1, 0, true], 'bool'))->toBe([true, false, true]);
    expect($action->executeWithValueType([1.1, 2.2], 'string'))->toBe(['1.1', '2.2']);
    expect($action->executeWithValueType(['1.1', '2.2'], 'float'))->toBe([1.1, 2.2]);
    expect($action->executeWithValueType(['a', 'b'], 'invalid'))->toBe(['a', 'b']);
});

it('checks if value can be cast', function (): void {
    $action = app(SafeArrayCastAction::class);
    expect($action->canCast([]))->toBeTrue();
    expect($action->canCast(null))->toBeTrue();
    expect($action->canCast('str'))->toBeTrue();
    expect($action->canCast(new \stdClass()))->toBeTrue();
});

it('uses static cast method correctly', function (): void {
    expect(SafeArrayCastAction::cast(['foo' => 'bar']))->toBe(['foo' => 'bar']);
    expect(SafeArrayCastAction::castWithKeys(['a' => 1], ['a']))->toBe(['a' => 1]);
    expect(SafeArrayCastAction::castWithFilter(['a' => 1, 'b' => 2], ['a']))->toBe(['a' => 1]);
    expect(SafeArrayCastAction::castWithValueType(['1'], 'int'))->toBe([1]);
});
