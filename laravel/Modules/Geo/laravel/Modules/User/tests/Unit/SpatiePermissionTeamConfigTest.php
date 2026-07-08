<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use PHPUnit\Framework\Assert;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Support\Config as PermissionConfig;

uses(Modules\User\Tests\TestCase::class);

test('spatie permission registrar uses user module models for teams', function (): void {
    $registrar = app(PermissionRegistrar::class);

    Assert::assertSame(Permission::class, config('permission.models.permission'));
    Assert::assertSame(Role::class, config('permission.models.role'));
    Assert::assertSame(Team::class, config('permission.models.team'));
    Assert::assertSame(Permission::class, $registrar->getPermissionClass());
    Assert::assertSame(Role::class, $registrar->getRoleClass());
    Assert::assertSame(Team::class, $registrar->getTeamClass());
    Assert::assertSame(Team::class, PermissionConfig::teamModel());
    Assert::assertTrue(config('permission.teams'));
});
