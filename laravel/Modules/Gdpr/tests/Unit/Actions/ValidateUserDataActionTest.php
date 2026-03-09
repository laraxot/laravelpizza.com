<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

uses(Modules\Gdpr\Tests\TestCase::class);

use Illuminate\Support\Facades\Hash;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;

test('ValidateUserDataAction returns valid user data', function () {
    $action = new ValidateUserDataAction();

    // Use unique email to avoid uniqueness constraint issues
    $uniqueEmail = 'test'.uniqid().'@example.com';

    $formData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $uniqueEmail,
        'password' => 'password123',
    ];

    $result = $action->execute($formData);

    expect($result)->toBeArray()
        ->toHaveKeys(['first_name', 'last_name', 'email', 'password', 'type', 'lang', 'email_verified_at'])
        ->first_name->toBe('John')
        ->last_name->toBe('Doe')
        ->email->toBe($uniqueEmail)
        ->type->toBe('customer_user')
        ->email_verified_at->not->toBeNull();
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

    expect(Hash::check('plainpassword', $result['password']))->toBeTrue();
});
