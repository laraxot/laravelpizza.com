<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/** Seeder canonico modello Permission (ex PermissionsSeeder). */
class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'moderate_doctors' => 'Can moderate doctor registrations',
            'view_doctors' => 'Can view doctors',
            'create_doctors' => 'Can create doctors',
            'edit_doctors' => 'Can edit doctors',
            'delete_doctors' => 'Can delete doctors',
            'authentication-log.view.any' => 'Can view all gli authentication logs',
            'authentication-log.view' => 'Can view own authentication logs',
            'authentication-log.create' => 'Can create authentication logs',
            'authentication-log.update' => 'Can update authentication logs',
            'authentication-log.delete' => 'Can delete authentication logs',
            'authentication-log.restore' => 'Can restore deleted authentication logs',
            'authentication-log.force-delete' => 'Can permanently delete authentication logs',
            'oauth-access-token.view.any' => 'Can view all i OAuth access tokens',
            'oauth-access-token.view' => 'Can view own OAuth access tokens',
            'oauth-access-token.create' => 'Can create OAuth access tokens',
            'oauth-access-token.update' => 'Can update OAuth access tokens',
            'oauth-access-token.delete' => 'Can delete OAuth access tokens',
            'oauth-access-token.restore' => 'Can restore deleted OAuth access tokens',
            'oauth-access-token.force-delete' => 'Can permanently delete OAuth access tokens',
            'oauth-refresh-token.view.any' => 'Can view all i OAuth refresh tokens',
            'oauth-refresh-token.view' => 'Can view own OAuth refresh tokens',
            'oauth-refresh-token.create' => 'Can create OAuth refresh tokens',
            'oauth-refresh-token.update' => 'Can update OAuth refresh tokens',
            'oauth-refresh-token.delete' => 'Can delete OAuth refresh tokens',
            'oauth-refresh-token.restore' => 'Can restore deleted OAuth refresh tokens',
            'oauth-refresh-token.force-delete' => 'Can permanently delete OAuth refresh tokens',
            'oauth-auth-code.view.any' => 'Can view all i OAuth authorization codes',
            'oauth-auth-code.view' => 'Can view own OAuth authorization codes',
            'oauth-auth-code.create' => 'Can create OAuth authorization codes',
            'oauth-auth-code.update' => 'Can update OAuth authorization codes',
            'oauth-auth-code.delete' => 'Can delete OAuth authorization codes',
            'oauth-auth-code.restore' => 'Can restore deleted OAuth authorization codes',
            'oauth-auth-code.force-delete' => 'Can permanently delete OAuth authorization codes',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        $role = Role::firstOrCreate([
            'name' => 'moderator',
            'guard_name' => 'web',
        ]);

        $role->givePermissionTo([
            'moderate_doctors',
            'view_doctors',
        ]);
    }
}
