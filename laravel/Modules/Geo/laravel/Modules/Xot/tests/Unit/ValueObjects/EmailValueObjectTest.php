<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\ValueObjects\EmailValueObject;
use PHPUnit\Framework\Assert;

it('accepts valid email', function (): void {
    $email = 'test@example.com';
    $vo = new EmailValueObject($email);
    Assert::assertSame($email, $vo->email);
});

it('throws on invalid email', function (): void {
});
