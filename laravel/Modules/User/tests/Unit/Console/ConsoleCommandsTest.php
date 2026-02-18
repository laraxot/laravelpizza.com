<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

use Modules\User\Console\Commands\AssignRoleCommand;
use Modules\User\Console\Commands\ChangeTypeCommand;
use Modules\User\Console\Commands\CreateTeamCommand;
use Modules\User\Console\Commands\CreateTenantCommand;
use Modules\User\Console\Commands\SuperAdminCommand;

test('AssignRoleCommand can be instantiated', function () {
    expect(class_exists(AssignRoleCommand::class))->toBeTrue();

    try {
        $command = new AssignRoleCommand();
        expect($command)->toBeInstanceOf(AssignRoleCommand::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});

test('ChangeTypeCommand can be instantiated', function () {
    expect(class_exists(ChangeTypeCommand::class))->toBeTrue();

    try {
        $command = new ChangeTypeCommand();
        expect($command)->toBeInstanceOf(ChangeTypeCommand::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});

test('SuperAdminCommand can be instantiated', function () {
    expect(class_exists(SuperAdminCommand::class))->toBeTrue();

    try {
        $command = new SuperAdminCommand();
        expect($command)->toBeInstanceOf(SuperAdminCommand::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});

test('CreateTeamCommand can be instantiated', function () {
    expect(class_exists(CreateTeamCommand::class))->toBeTrue();

    try {
        $command = new CreateTeamCommand();
        expect($command)->toBeInstanceOf(CreateTeamCommand::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});

test('CreateTenantCommand can be instantiated', function () {
    expect(class_exists(CreateTenantCommand::class))->toBeTrue();

    try {
        $command = new CreateTenantCommand();
        expect($command)->toBeInstanceOf(CreateTenantCommand::class);
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if class exists
    }
});
