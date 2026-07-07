<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ValidateUserDataAction returns valid user data', function () {
    $action = new ValidateUserDataAction();
    $uniqueEmail = 'test'.uniqid().'@example.com';

    $formData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $uniqueEmail,
        'password' => 'password123',
    ];

    $result = $action->execute($formData);

    Assert::assertArrayHasKey('first_name', $result);
    Assert::assertArrayHasKey('last_name', $result);
    Assert::assertArrayHasKey('email', $result);
    Assert::assertArrayHasKey('password', $result);
    Assert::assertArrayHasKey('type', $result);
    Assert::assertArrayHasKey('lang', $result);
    Assert::assertArrayHasKey('email_verified_at', $result);
    Assert::assertSame('John', $result['first_name']);
    Assert::assertSame('Doe', $result['last_name']);
    Assert::assertSame($uniqueEmail, $result['email']);
    Assert::assertSame('customer_user', $result['type']);
    Assert::assertNotNull($result['email_verified_at']);
});

test('ValidateUserDataAction hashes password', function () {
    $action = new ValidateUserDataAction();
    $uniqueEmail = 'test'.uniqid().'@example.com';

    $formData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $uniqueEmail,
        'password' => 'plainpassword',
    ];

    $result = $action->execute($formData);

    Assert::assertIsString($result['password']);
    Assert::assertTrue(Hash::check('plainpassword', $result['password']));
});
