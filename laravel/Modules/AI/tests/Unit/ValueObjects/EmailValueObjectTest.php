<?php

declare(strict_types=1);
use Modules\Xot\Tests\TestCase;
use Modules\Xot\ValueObjects\EmailValueObject;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('accepts valid email', function (): void {
    $email = 'test@example.com';
    $vo = new EmailValueObject($email);
    Assert::assertSame($email, $vo->email);
});

it('throws on invalid email')->todo();
