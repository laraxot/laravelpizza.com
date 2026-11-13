<?php

declare(strict_types=1);
use Modules\User\Console\Commands\AssignRoleCommand;
use Modules\User\Console\Commands\ChangeTypeCommand;
use Modules\User\Console\Commands\CreateTeamCommand;
use Modules\User\Console\Commands\CreateTenantCommand;
use Modules\User\Console\Commands\SuperAdminCommand;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('AssignRoleCommand can be instantiated', function () {
    expect(new AssignRoleCommand)->toEqual(new AssignRoleCommand);
});

test('ChangeTypeCommand can be instantiated', function () {
    expect(new ChangeTypeCommand)->toEqual(new ChangeTypeCommand);
});

test('SuperAdminCommand can be instantiated', function () {
    expect(new SuperAdminCommand)->toEqual(new SuperAdminCommand);
});

test('CreateTeamCommand can be instantiated', function () {
    expect(new CreateTeamCommand)->toEqual(new CreateTeamCommand);
});

test('CreateTenantCommand can be instantiated', function () {
    expect(new CreateTenantCommand)->toEqual(new CreateTenantCommand);
});
