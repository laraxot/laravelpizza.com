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
    new AssignRoleCommand;
});

test('ChangeTypeCommand can be instantiated', function () {
    new ChangeTypeCommand;
});

test('SuperAdminCommand can be instantiated', function () {
    new SuperAdminCommand;
});

test('CreateTeamCommand can be instantiated', function () {
    new CreateTeamCommand;
});

test('CreateTenantCommand can be instantiated', function () {
    new CreateTenantCommand;
});
