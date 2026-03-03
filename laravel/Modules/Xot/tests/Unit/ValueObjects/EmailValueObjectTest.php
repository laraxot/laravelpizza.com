<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\ValueObjects;

use Modules\Xot\Tests\TestCase;
use Modules\Xot\ValueObjects\EmailValueObject;

uses(TestCase::class);

it('accepts valid email', function (): void {
    $email = 'test@example.com';
    $vo = new EmailValueObject($email);
    expect($vo->email)->toBe($email);
});

it('throws on invalid email', function (): void {
    expect(fn () => new EmailValueObject('invalid-email'))
        ->toThrow(\InvalidArgumentException::class, 'Email address invalid-email is NOT valid.');
});
