<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Gdpr\Tests\TestCase $this */
    User::query()->delete();
});

it('can access database connection', function (): void {
    $count = User::count();

    Assert::assertIsInt($count);
});

it('can create user via factory', function (): void {
    $user = UserFactory::new()->createOne([
        'email' => 'test@example.com',
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);

    Assert::assertSame('test@example.com', $user->email);
});
