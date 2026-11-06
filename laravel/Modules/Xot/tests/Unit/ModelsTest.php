<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\Xot\Models\Module;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('can create a test user', function () {
    $email = 'test-'.uniqid('', true).'@example.com';
    $user = UserFactory::new()->createOne([
        'name' => 'Test User',
        'email' => $email,
    ]);

    Assert::assertInstanceOf(User::class, $user);
    Assert::assertSame('Test User', $user->name);
    Assert::assertSame($email, $user->email);
});

it('can create a test tenant', function () {
    $tenant = TenantFactory::new()->createOne([
        'name' => 'Test Tenant',
        'domain' => 'test.example.com',
    ]);

    Assert::assertInstanceOf(Tenant::class, $tenant);
    Assert::assertSame('Test Tenant', $tenant->name);
    Assert::assertSame('test.example.com', $tenant->domain);
});

it('can resolve a sushi module row', function () {
    $module = Module::query()->first();

    if ($module === null) {
        Assert::markTestSkipped('No nwidart modules registered in test runtime.');
    }

    Assert::assertInstanceOf(Module::class, $module);
    Assert::assertNotEmpty($module->name);
});
