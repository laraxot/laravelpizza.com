<?php

declare(strict_types=1);

use Modules\Xot\Actions\Cast\SafeIntCastAction;

beforeEach(function (): void {
    $this->action = app(SafeIntCastAction::class);
});

it('returns int as-is', function (): void {
    expect($this->action->execute(42))->toBe(42);
});

it('casts null to default', function (): void {
    expect($this->action->execute(null))->toBe(0);
    expect($this->action->execute(null, 5))->toBe(5);
});

it('casts float to int', function (): void {
    expect($this->action->execute(3.9))->toBe(3);
    expect($this->action->execute(INF, 7))->toBe(7);
});

it('casts string to int', function (): void {
    expect($this->action->execute('42'))->toBe(42);
    expect($this->action->execute('  123  '))->toBe(123);
    expect($this->action->execute('1,234'))->toBe(1234);
    expect($this->action->execute('abc 99', 9))->toBe(9);
    expect($this->action->execute('+55abc'))->toBe(55);
});

it('casts bool to int', function (): void {
    expect($this->action->execute(true))->toBe(1);
    expect($this->action->execute(false))->toBe(0);
});

it('casts single-value array and stringable object', function (): void {
    expect($this->action->execute([8]))->toBe(8);

    $stringable = new class
    {
        public function __toString(): string
        {
            return '73';
        }
    };

    expect($this->action->execute($stringable))->toBe(73);
});

it('returns default for unsupported and empty-string edge cases', function (): void {
    $resource = fopen('php://memory', 'rb');
    expect(is_resource($resource))->toBeTrue()
        ->and($this->action->execute($resource, 11))->toBe(11)
        ->and($this->action->execute('', null))->toBe(0);
    fclose($resource);
});

it('executeWithRange clamps value', function (): void {
    expect($this->action->executeWithRange(150, 0, 100))->toBe(100);
    expect($this->action->executeWithRange(-10, 0, 100))->toBe(0);
});

it('executeAsId returns at least 1', function (): void {
    expect($this->action->executeAsId(0))->toBe(1);
    expect($this->action->executeAsId(5))->toBe(5);
});

it('has static cast method', function (): void {
    expect(SafeIntCastAction::cast('99'))->toBe(99);
    expect(SafeIntCastAction::castWithRange(150, 0, 100))->toBe(100);
    expect(SafeIntCastAction::castAsId(0))->toBe(1);
});
