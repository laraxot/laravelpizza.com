<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\ValueObjects\PhoneValueObject;
use PHPUnit\Framework\Assert;

it('accepts valid phone', function (): void {
    $phone = '+11234567890';
    $vo = PhoneValueObject::fromString($phone);
    Assert::assertSame($phone, $vo->toString());
});

it('throws on invalid phone', function (): void {
});
