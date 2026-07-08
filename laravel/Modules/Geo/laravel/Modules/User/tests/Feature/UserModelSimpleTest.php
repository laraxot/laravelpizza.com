<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Model Simple', function (): void {
    test('user model can be instantiated', function (): void {
        /** @var TestCase $this */
        $user = new User();

        Assert::assertInstanceOf(User::class, $user);
    });

    test('user model can access connection', function (): void {
        $user = new User();

        Assert::assertSame('user', $user->getConnectionName());
    });

    test('user model can create basic record', function (): void {
        /* @var TestCase $this */
        $this->skipUnlessUsersTableReady();

        $user = createTestUser([
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'lang' => 'it',
            'is_active' => true,
        ]);

        Assert::assertInstanceOf(User::class, $user);
    });
});
