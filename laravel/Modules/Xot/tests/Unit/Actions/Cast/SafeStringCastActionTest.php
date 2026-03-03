<?php

declare(strict_types=1);

use Modules\Xot\Actions\Cast\SafeStringCastAction;

beforeEach(function (): void {
    $this->action = app(SafeStringCastAction::class);
});

it('returns string as-is', function (): void {
    expect($this->action->execute('hello'))->toBe('hello');
});

it('casts null to empty string', function (): void {
    expect($this->action->execute(null))->toBe('');
});

it('casts bool to 1 or 0', function (): void {
    expect($this->action->execute(true))->toBe('1');
    expect($this->action->execute(false))->toBe('0');
});

it('casts scalar to string', function (): void {
    expect($this->action->execute(42))->toBe('42');
});

it('casts array to empty string', function (): void {
    expect($this->action->execute([1]))->toBe('');
});

it('has static cast method', function (): void {
    expect(SafeStringCastAction::cast('x'))->toBe('x');
});
