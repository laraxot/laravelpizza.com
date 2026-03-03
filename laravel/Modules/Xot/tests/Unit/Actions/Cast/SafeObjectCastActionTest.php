<?php

declare(strict_types=1);

use Modules\Xot\Actions\Cast\SafeObjectCastAction;

beforeEach(function (): void {
    $this->action = app(SafeObjectCastAction::class);
    $this->obj = new class
    {
        public string $name = 'Mario';
        public string $age = '42';
        public string $score = '12.5';
        public string $active = '1';
        public array $meta = ['k' => 'v'];
        public string $empty = '';

        public function greet(string $name): string
        {
            return "Hi {$name}";
        }

        public function fail(): string
        {
            throw new RuntimeException('boom');
        }
    };
});

it('checks property presence and values', function (): void {
    expect($this->action->hasProperty($this->obj, 'name'))->toBeTrue()
        ->and($this->action->hasNonNullProperty($this->obj, 'name'))->toBeTrue()
        ->and($this->action->hasNonEmptyProperty($this->obj, 'name'))->toBeTrue()
        ->and($this->action->hasNonEmptyProperty($this->obj, 'empty'))->toBeFalse()
        ->and($this->action->hasPropertyValue($this->obj, 'name', 'Mario'))->toBeTrue();
});

it('casts typed property getters', function (): void {
    expect($this->action->getStringProperty($this->obj, 'name'))->toBe('Mario')
        ->and($this->action->getIntProperty($this->obj, 'age'))->toBe(42)
        ->and($this->action->getFloatProperty($this->obj, 'score'))->toBe(12.5)
        ->and($this->action->getBooleanProperty($this->obj, 'active'))->toBeTrue()
        ->and($this->action->getArrayProperty($this->obj, 'meta'))->toBe(['k' => 'v'])
        ->and($this->action->getStringProperty($this->obj, 'missing', 'fallback'))->toBe('fallback');
});

it('casts generic typed getter and validated getter', function (): void {
    expect($this->action->getTypedProperty($this->obj, 'name', 'string'))->toBe('Mario')
        ->and($this->action->getTypedProperty($this->obj, 'age', 'int'))->toBe(42)
        ->and($this->action->getTypedProperty($this->obj, 'score', 'float'))->toBe(12.5)
        ->and($this->action->getTypedProperty($this->obj, 'active', 'bool'))->toBeTrue()
        ->and($this->action->getTypedProperty($this->obj, 'meta', 'array'))->toBe(['k' => 'v']);

    $ok = $this->action->getValidatedProperty($this->obj, 'age', 'int', fn (int $v): bool => $v > 18, 0);
    $ko = $this->action->getValidatedProperty($this->obj, 'age', 'int', fn (int $v): bool => $v > 99, 0);

    expect($ok)->toBe(42)->and($ko)->toBe(0);
});

it('checks methods and calls methods safely', function (): void {
    expect($this->action->hasMethod($this->obj, 'greet'))->toBeTrue()
        ->and($this->action->callMethodSafely($this->obj, 'greet', ['Luigi']))->toBe('Hi Luigi')
        ->and($this->action->callMethodSafely($this->obj, 'missing', [], 'default'))->toBe('default')
        ->and($this->action->callMethodSafely($this->obj, 'fail', [], 'default'))->toBe('default');
});

