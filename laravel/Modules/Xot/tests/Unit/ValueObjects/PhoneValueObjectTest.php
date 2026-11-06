<?php

declare(strict_types=1);
use Modules\Xot\Tests\TestCase;
use Modules\Xot\ValueObjects\PhoneValueObject;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('accepts valid phone', function (): void {
    $phone = '+11234567890';
    $vo = PhoneValueObject::fromString($phone);
    Assert::assertSame($phone, $vo->toString());
});

it('throws on invalid phone')->todo();
