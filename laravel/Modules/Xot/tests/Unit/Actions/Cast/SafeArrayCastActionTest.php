<?php

declare(strict_types=1);

use Modules\Xot\Actions\Cast\SafeArrayCastAction;

beforeEach(function (): void {
    $this->action = app(SafeArrayCastAction::class);
});

it('casts common input shapes to array', function (): void {
    expect($this->action->execute(['a' => 1]))->toBe(['a' => 1])
        ->and($this->action->execute(null, ['d']))->toBe(['d'])
        ->and($this->action->execute(5))->toBe([5]);
});

it('casts objects via toArray, __toArray and public props', function (): void {
    $toArrayObject = new class {
        public function toArray(): array
        {
            return ['x' => 1];
        }
    };

    $badToArrayObject = new class {
        public function toArray(): string
        {
            return 'bad';
        }
    };

    $magicToArrayObject = new class {
        public function __toArray(): array
        {
            return ['y' => 2];
        }
    };

    $badMagicToArrayObject = new class {
        public function __toArray(): string
        {
            return 'bad';
        }
    };

    $plainObject = new class {
        public int $z = 3;
    };

    expect($this->action->execute($toArrayObject))->toBe(['x' => 1])
        ->and($this->action->execute($badToArrayObject, ['default']))->toBe(['default'])
        ->and($this->action->execute($magicToArrayObject))->toBe(['y' => 2])
        ->and($this->action->execute($badMagicToArrayObject, ['fallback']))->toBe(['fallback'])
        ->and($this->action->execute($plainObject))->toBe(['z' => 3]);
});

it('casts stdClass branch explicitly', function (): void {
    $obj = new stdClass();
    $obj->a = 1;

    expect($this->action->execute($obj))->toBe(['a' => 1]);
});

it('validates required keys and filters allowed keys', function (): void {
    $value = ['name' => 'Mario', 'role' => 'admin', 'active' => true];

    expect($this->action->executeWithKeys($value, ['name']))->toBe($value)
        ->and($this->action->executeWithKeys($value, ['missing'], ['fallback']))->toBe(['fallback'])
        ->and($this->action->executeWithKeys($value, [new stdClass()], ['fallback']))->toBe($value)
        ->and($this->action->executeWithFilter($value, ['name', 'active']))->toBe(['name' => 'Mario', 'active' => true]);
});

it('casts values by requested value type', function (): void {
    $value = ['1', '2', '3'];

    expect($this->action->executeWithValueType($value, 'string'))->toBe(['1', '2', '3'])
        ->and($this->action->executeWithValueType($value, 'int'))->toBe([1, 2, 3])
        ->and($this->action->executeWithValueType($value, 'float'))->toBe([1.0, 2.0, 3.0])
        ->and($this->action->executeWithValueType($value, 'bool'))->toBe([true, true, true])
        ->and($this->action->executeWithValueType($value, 'unknown'))->toBe(['1', '2', '3']);
});

it('exposes canCast and static helper methods', function (): void {
    $resource = fopen('php://memory', 'rb');
    expect(is_resource($resource))->toBeTrue()
        ->and($this->action->canCast([]))->toBeTrue()
        ->and($this->action->canCast($resource))->toBeFalse()
        ->and(SafeArrayCastAction::cast('x'))->toBe(['x'])
        ->and(SafeArrayCastAction::castWithKeys(['k' => 1], ['k']))->toBe(['k' => 1])
        ->and(SafeArrayCastAction::castWithFilter(['k' => 1, 'z' => 2], ['k']))->toBe(['k' => 1])
        ->and(SafeArrayCastAction::castWithValueType(['1'], 'int'))->toBe([1]);

    fclose($resource);
});

it('returns default for non-castable value types', function (): void {
    $resource = fopen('php://memory', 'rb');
    expect(is_resource($resource))->toBeTrue()
        ->and($this->action->execute($resource, ['fallback']))->toBe(['fallback']);
    fclose($resource);
});
