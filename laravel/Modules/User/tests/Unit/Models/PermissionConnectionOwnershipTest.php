<?php

declare(strict_types=1);

use function Safe\file_get_contents;

uses(PHPUnit\Framework\TestCase::class);

/**
 * Gate facts:
 * 1. Behaviour: Permission/Role live on connection `user` (`fixcity_user`).
 * 2. Existing: PermissionTest — no connection ownership contract.
 * 3. User: «permissions deve stare dentro il db fixcity_user».
 */
test('permission and role models declare user connection', function (): void {
    $permission = file_get_contents(
        dirname(__DIR__, 3).'/app/Models/Permission.php'
    );
    $role = file_get_contents(
        dirname(__DIR__, 3).'/app/Models/Role.php'
    );

    expect($permission)->toContain("protected \$connection = 'user'");
    expect($role)->toContain("protected \$connection = 'user'");
});

test('permissions migration targets Permission model on user connection', function (): void {
    $source = file_get_contents(
        dirname(__DIR__, 3).'/database/migrations/2023_01_22_000007_create_permissions_table.php'
    );

    expect($source)
        ->toContain('Permission::class')
        ->toContain('tableCreate');
});
