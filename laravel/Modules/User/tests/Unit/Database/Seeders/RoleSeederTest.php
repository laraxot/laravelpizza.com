<?php

declare(strict_types=1);
use Modules\User\Database\Seeders\RoleSeeder;
use Modules\User\Models\Role;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * @covers \Modules\User\Database\Seeders\RoleSeeder
 */
it('creates expected roles', function (): void {
    $expectedRoles = [
        'super-admin',
        'admin',
        'moderator',
        'editor',
        'user',
        'guest',
    ];

    $seeder = new RoleSeeder;
    $seeder->setContainer(app());
    $seeder->run();

    foreach ($expectedRoles as $roleName) {
        Assert::assertTrue(Role::where('name', $roleName)->where('guard_name', 'web')->exists());
    }

    $roleCount = Role::where('guard_name', 'web')->count();
    Assert::assertGreaterThanOrEqual(count($expectedRoles), $roleCount);
});

it('is idempotent when run multiple times', function (): void {
    $seeder = new RoleSeeder;
    $seeder->setContainer(app());

    $seeder->run();
    $countAfterFirstRun = Role::where('guard_name', 'web')->count();

    $seeder->run();
    $countAfterSecondRun = Role::where('guard_name', 'web')->count();

    Assert::assertSame($countAfterFirstRun, $countAfterSecondRun);
});
