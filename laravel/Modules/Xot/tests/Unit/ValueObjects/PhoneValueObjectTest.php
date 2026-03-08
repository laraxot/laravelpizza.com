<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\ValueObjects;

use Modules\Xot\ValueObjects\PhoneValueObject;

it('accepts valid phone', function (): void {
    $phone = '+11234567890';
    $vo = PhoneValueObject::fromString($phone);
    expect($vo->toString())->toBe($phone);
});

it('throws on invalid phone', function (): void {
    expect(fn () => PhoneValueObject::fromString('12345'))
        ->toThrow(\InvalidArgumentException::class, 'It is not valid phone value');
});
